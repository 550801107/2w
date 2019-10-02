<?php
namespace App\Api\Controllers\v1;


use App\Api\Controllers\ApiControllers;
use App\Models\HdrsAdvert;

class AdvertController extends ApiControllers
{

	/**
	 * @desc 获取首页广告列表
	 * @return mixed
	 */
	public function AdvertList() {
		$data = HdrsAdvert::select(['title', 'url', 'link_url', ])->where(['status'=>0])->orderBy('sort', 'desc')->limit(3)->get();
//		dd($data);
		if (!empty($data)) {
			foreach ($data as $k=>$v) {
				$data[$k]['url'] = env('IMG_URL').'/'.$v['url'];
			}
		}

		return $this->success($data);
	}


}