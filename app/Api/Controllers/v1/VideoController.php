<?php
namespace App\Api\Controllers\v1;


use App\Api\Controllers\ApiControllers;
use App\Models\HdrsGroup;
use App\Models\HdrsIntegralLog;
use App\Models\HdrsVideo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VideoController extends ApiControllers
{

	/**
	 * @desc 根据会员 级别 返回 最新的 第一条视频
	 * @return mixed
	 */
	public function NewVideo() {
		$user = auth()->user();
		// 是认证会员，看 视频分组第一个
		if ($user['is_members'] == User::AUTHENTICATION){
			$data = HdrsVideo::where(['active' => HdrsVideo::ACTIVE, 'group_id'=>$user['group_id']])
							 ->select('id', 'title', 'picture', 'video_url')
							 ->orderBy('created_at', 'desc')
							 ->first();
		}else{
			// 如果不是 认证会员
			$data = HdrsVideo::where(['type' => HdrsVideo::FREE, 'active' => HdrsVideo::ACTIVE])
							 ->select('id', 'title', 'picture', 'video_url')
							 ->orderBy('created_at', 'desc')
							 ->first();
		}
		if (!empty($data)) {
			$tmp = $data->toArray();
			$data = [
				'id' => $tmp['id'],
				'title' => $tmp['title'],
				'picture' => env('IMG_URL'). '/'.$tmp['picture'],
				'video_url' => env('IMG_URL'). '/'.$tmp['video_url'],
			];
		}
		return $this->success($data);
	}

	/**
	 * @desc 获取 免费视频
	 * @param Request $request
	 * @return mixed
	 */
	public function FreeVideoList(Request $request) {
		$this->validate($request, [
			'page' => 'integer',
			'per_page' => 'integer'
		]);
		$video_data = HdrsVideo::where(['type'=>HdrsVideo::FREE, 'active' => HdrsVideo::ACTIVE])
							   ->select('id', 'title', 'picture', 'video_url','length_time','created_at')
							   ->orderBy('created_at', 'desc')
							   ->paginate($request->per_page ?? 20)->toArray();

		if (!empty($video_data['data'])) {
			foreach ($video_data['data'] as $k=>$v) {
                $video_data['data'][$k]['new'] = substr($v['created_at'],0,10)==date('Y-m-d')?'1':'0';
                $video_data['data'][$k]['picture'] = env('IMG_URL') .'/' . $video_data['data'][$k]['picture'];
				$video_data['data'][$k]['video_url'] = env('IMG_URL') .'/' . $video_data['data'][$k]['video_url'];
			}
		}
		$data = [
			'page_data' => $video_data['data'],
			'last_page' => $video_data['last_page'],
		];
		return $this->success($data);
	}

	/**
	 * @desc 根据会员分组 获取 认证会员视频
	 * @param Request $request
	 * @return mixed
	 */
	public function GroupVideoList(Request $request) {
		$this->validate($request, [
			'page' => 'integer',
			'per_page' => 'integer'
		]);
		$user = auth()->user();
		$video_data = HdrsVideo::where(['group_id'=>$user['group_id'], 'active' => HdrsVideo::ACTIVE])
							   ->select('id', 'title', 'picture', 'video_url','length_time','created_at')
							   ->orderBy('created_at', 'desc')
							   ->paginate($request->per_page ?? 20)->toArray();

		if (!empty($video_data['data'])) {
			foreach ($video_data['data'] as $k=>$v) {
                $video_data['data'][$k]['new'] = substr($v['created_at'],0,10)==date('Y-m-d')?'1':'0';
                $video_data['data'][$k]['picture'] = env('IMG_URL') .'/' . $video_data['data'][$k]['picture'];
				$video_data['data'][$k]['video_url'] = env('IMG_URL') .'/' . $video_data['data'][$k]['video_url'];
			}
		}
		$data = [
			'page_data' => $video_data['data'],
			'last_page' => $video_data['last_page'],
		];
		return $this->success($data);
	}

    /**
     * @desc 非会员展示特殊的会员视频列表
     * @param Request $request
     * @return mixed
     */
    public function GroupVideoMember(Request $request) {
        $this->validate($request, [
            'page' => 'integer',
            'per_page' => 'integer'
        ]);
//        $user = auth()->user();
        $group = HdrsGroup::where(['name'=>'非会员视频'])->first()->toArray();
        $video_data = HdrsVideo::where(['group_id'=>$group['id'], 'active' => HdrsVideo::ACTIVE])
            ->select('id', 'title', 'picture', 'video_url','length_time','created_at')
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 20)->toArray();

        if (!empty($video_data['data'])) {
            foreach ($video_data['data'] as $k=>$v) {
                $video_data['data'][$k]['new'] = substr($v['created_at'],0,10)==date('Y-m-d')?'1':'0';
                $video_data['data'][$k]['picture'] = env('IMG_URL') .'/' . $video_data['data'][$k]['picture'];
                $video_data['data'][$k]['video_url'] = env('IMG_URL') .'/' . $video_data['data'][$k]['video_url'];
            }
        }
        $data = [
            'page_data' => $video_data['data'],
            'last_page' => $video_data['last_page'],
        ];
        return $this->success($data);
    }

	/**
	 * @param Request $request
	 * @return mixed
	 * @desc 进入视频时，打标记
	 */
	public function inVideoTimeMark(Request $request)
	{
		$this->validate($request, [
			'video_id' => 'required|integer',
		]);
		$status = Cache::set($this->getVideoMarkKey($request['video_id']), time(), 86400);
		if (!$status) {
			return $this->failed('打点失败');
		}
		return $this->success('');
	}

	/**
	 * @param Request $request
	 * @return mixed
	 * @desc 退出视频时  删除标记
	 */
	public function delVideoTimeMark(Request $request)
	{
		$this->validate($request, [
			'video_id' => 'required|integer',
		]);
		$status = Cache::delete($this->getVideoMarkKey($request['video_id']));
		if (!$status) {
			return $this->failed('删除失败');
		}
		return $this->success('');
	}

	/**
	 * @desc 看视频奖励积分
	 * @param Request $request
	 * @return mixed
	 */
	public function rewardIntegral(Request $request)
	{
		$this->validate($request, [
			'video_id' => 'required|integer',
		]);
		$videoInfo = HdrsVideo::where(['id' => $request['video_id'], 'active' => HdrsVideo::ACTIVE])->first();
		if (empty($videoInfo)) {
			return $this->failed('不存在此视频');
		}
		$videoInfo = $videoInfo->toArray();
		$user = auth()->user();

		// 判断 是否 之前 已经得过了
		$res = HdrsIntegralLog::where([
										  'user_id' => $user['id'],
										  'title' => 'Video|'.$videoInfo['id']
									  ])
							  ->select('id')->first();
		if (!empty($res)) {
            return $this->success('');
		}
		// 判断 时间是否够了
		if ((time()-Cache::get($this->getVideoMarkKey($request['video_id']))) < $videoInfo['length_time']) {
            return $this->success('观看时间不足');
		}
		// 在事务内 执行
		try{
			DB::transaction(function ()  use ($user, $videoInfo){
				// 加积分
				User::where(['id' => $user['id'], 'active' => User::ACTIVE])
					->increment('integral', $videoInfo['get_integral']);
				// 积分记录log
				HdrsIntegralLog::create([
											'user_id' => $user['id'],
											'goods' => '观看视频得积分',
											'integral_num' => '+'.$videoInfo['get_integral'],
											'title' => 'Video|'.$videoInfo['id']
										]);
			}, 2);
		}catch (\Throwable $e) {
			logger($e->getMessage());
			return $this->failed('执行失败');
		}
		// 删除标记
		Cache::delete($this->getVideoMarkKey($videoInfo['id']));
		return $this->success(['data'=>"观看视频获得".$videoInfo['get_integral'].'积分']);
	}

	/**
	 * @desc 获取 视频标记键值
	 * @param int $id 视频id
	 * @return string
	 */
	private function getVideoMarkKey(int $id)
	{
		return 'video_mark'.auth()->user()['id'].$id;
	}


}