<?php
namespace App\Api\Controllers\v1;


use App\Admin\Controllers\BaseController;
use App\Api\Controllers\ApiControllers;
use App\Models\HdrsClocklog;
use App\Models\HdrsArea;
use App\Models\HdrsClock;
use App\Models\HdrsIntegralLog;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IntegralController extends ApiControllers
{

	public function index(Request $request) {

	}

	/**
	 * @desc 地区 积分排名
	 */
	public function area_rank(Request $request) {
        $this->validate($request, [
			'page' => 'integer',
			'per_page' => 'integer'
		]);

		$user = auth()->user();
//		$area_name = HdrsArea::select('name')->where(['id' => $user->area_id])->first();
//		if (empty($area_name)){
//            return $this->status('successs',['data'=>['message' => '未设置区域']],201);
//		}
		// 当前用户排名
		$current_user_rank = User::where('integral', '<', $user->integral)->count();
		// 分页数据
		$page_data = User::select(['id', 'avatar', 'nickname', 'integral'])
						 ->where(['active' => User::ACTIVE])
//						 ->where(['active' => User::ACTIVE, 'area_id' => $user->area_id])
						 ->orderBy('integral', 'desc')
						 ->paginate($request->per_page ?? 20);
        $model = User::select(['id', 'avatar', 'nickname', 'integral'])
            ->where(['active' => User::ACTIVE])
            ->orderBy('integral', 'desc')
            ->get();
        foreach ($model->toArray() as $key => $val){
            if($val['id']==$user->id){
                $info = $val;
                $info['pai'] = $key+1;
            }
        }
		$data = [
//			'area_name' => $area_name->name,
			'area_name' => '积分',
			'current_user_rank' => $current_user_rank + 1,
			'current_user_integral' => $user->integral,
			'user' => $info,
			'page_data' => $page_data->toArray()['data'],
			'last_page' => $page_data->toArray()['last_page'],
			];
		return $this->success($data);
	}

    /**
     * @param Request $request
     * @return mixed
     * @desc 积分记录
     */
    public function integer_log(Request $request) {
        $this->validate($request, [
            'page' => 'integer',
            'per_page' => 'integer'
        ]);
        $user = auth()->user();
        $page_data = HdrsIntegralLog::where(['user_id' => $user['id']])->paginate($request->per_page ?? 20);
        if (empty($page_data)) {
            return $this->success('');
        }
        $data = [
            'integral' => $user->integral,
            'page_data' => $page_data->toArray()['data'],
            'last_page' => $page_data->toArray()['last_page'],
        ];
        return $this->success($data);
    }

    /**
     * @desc 签到
     */
    public function clock(Request $request) {
        $user = auth()->user();
        $id = $user->id;
        $jin = HdrsClocklog::where(['date' => date('Y-m-d'),'user_id'=>$id])->first();
        if(!$jin){
            $rules = HdrsClock::first();
            if(!$rules){
                return $this->failed(['message' => '签到功能未开启']);
            }
            //每日签到
            try{
                DB::transaction(function ()  use ($user,$rules){
                    $info = HdrsClocklog::where(['date' => date('Y-m-d',strtotime('-1day')),'user_id'=>$user['id']])->first();
                    // 加积分
                    $users = User::find($user['id']);
                    $users->clock = $info?$users['clock']+1:1;
                    $users->integral = $users['integral'] + $rules['integral'];
                    $users -> save();

                    //2019-10-02，新增万里牛积分对接
                    $GuzzleUrl = "";
                    $http = new BaseController();
                    $http->httpByIntegral('GET',$GuzzleUrl,$info->integral);

                    // 积分记录log
                    HdrsIntegralLog::create([
                        'user_id' => $user['id'],
                        'goods' => '每日签到',
                        'integral_num' => '+'.$rules['integral'],
                        'title' => '签到得积分'
                    ]);
                    //签到记录
                    HdrsClocklog::create([
                        'user_id' => $user['id'],
                        'date' => date('Y-m-d'),
                    ]);
                }, 2);
            }catch (\Throwable $e) {
                logger($e->getMessage());
                return $this->failed('每日签到失败');
            }
            //连续签到
            $model =  User::find($id);
            if($model['clock']==$rules['days'] ||$model['clock']>$rules['days']){
                try{
                    DB::transaction(function ()  use ($user,$rules){
                        // 加积分
                        $info = User::find($user['id']);
                        $info->clock = 0;
                        $info->integral = $info['integral'] + $rules['days_integral'];
                        $info -> save();

                        //2019-10-02，新增万里牛积分对接
                        $GuzzleUrl = "";
                        $http = new BaseController();
                        $http->httpByIntegral('GET',$GuzzleUrl,$info->integral);

                        // 积分记录log
                        HdrsIntegralLog::create([
                            'user_id' => $user['id'],
                            'goods' => '连续'.$rules['days'].'天签到',
                            'integral_num' => '+'.$rules['days_integral'],
                            'title' => '连续签到得积分'
                        ]);
                    }, 2);
                }catch (\Throwable $e) {
                    logger($e->getMessage());
                    return $this->failed('连续签到失败');
                }
                return $this->success(['message' => '连续签到成功，获得'.$rules['integral']+$rules['days_integral'].'积分']);
            }
            return $this->success(['message' => '签到成功，获得'.$rules['integral'].'积分']);
        }else{
            return $this->status('successs',['data'=>['message' => '您已签到']],201);
        }

    }

}