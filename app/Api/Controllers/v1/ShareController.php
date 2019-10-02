<?php
namespace App\Api\Controllers\v1;


use App\Api\Controllers\ApiControllers;
use App\Models\HdrsIntegralLog;
use App\Models\HdrsShare;
use App\Models\HdrsShareRules;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShareController extends ApiControllers
{
	/**
	 * @param Request $request
	 * @return mixed
	 * @desc 分享记录
	 */
	public function index(Request $request) {
		$this->validate($request, [
			'page' => 'integer',
			'per_page' => 'integer'
		]);
		$user = auth()->user();
		$data = HdrsShare::where(['send_id' => $user['id']])
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 20);
		if (empty($data)) {
			return $this->success('');
		}
		$ids = $data->pluck('receive_id');
		if (empty($ids)){
			return $this->success('');
		}
		$users = User::select(['id', 'avatar', 'nickname','is_members'])->whereIn('id', $ids)->get()->toArray();
		foreach ($data as $k=>$v){
			foreach ($users as $k1=>$v1) {
				if ($v['receive_id'] == $v1['id']) {
					$data[$k]['avatar'] = $v1['avatar'];
					$data[$k]['nickname'] = $v1['nickname'];
					$data[$k]['is_members'] = $v1['is_members'];
				}
			}
		}
		return $this->success($data);
	}

	/**
	 * @param Request $request
	 * @return mixed
	 * @desc 认证用户点击我分享的小程序链接得积分
	 */
	public function shareGetIntegral(Request $request)
	{
        $user = auth()->user();
        $this->validate($request, [
			'from_id' => 'required|integer',
		]);
		if (empty(User::find($request['from_id']))){
			return $this->failed('此用户不存在');
		}

		// 应该加多少积分
		$integral = HdrsShareRules::first()['integral'];

		$model = HdrsShare::where(['send_id' => $request['from_id'],'receive_id' => $user['id']])->get()->toArray();
		if($user['id']==$request['from_id']){
            return $this->status('successs',['data'=>['data' => '自己分享无效']],201);
        }
		if(!empty($model)){
            return $this->status('successs',['data'=>['data' => '已经分享']],201);
        }

		// 在事务内 执行
		try{
			DB::transaction(function ()  use ($integral, $request){
				$user = auth()->user();
				// 加积分
				User::where(['id' => $request['from_id'], 'active' => User::ACTIVE])
					->increment('integral', $integral);

				// 分享表记录
				HdrsShare::create([
									  'send_id' => $request['from_id'],
									  'receive_id' => $user['id'],
									  'type' => HdrsShare::SHARE,
									  'integral' => $integral,
								  ]);
				// 积分记录log
				HdrsIntegralLog::create([
											'user_id' => $request['from_id'],
											'goods' => '分享得积分',
											'integral_num' => '+'.$integral,
											'title' => 'Share|'.$user['id']
										]);
			}, 2);
		}catch (\Throwable $e) {
			logger($e->getMessage());
			return $this->failed('执行失败');
		}

		return $this->success('');
	}


}