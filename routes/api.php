<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace("v1")->group(function(){
	// 登录
	Route::post('login', 'UserController@login');
	// 首页广告列表
	Route::get('advert_list', 'AdvertController@AdvertList');
	Route::middleware(['jwt.auth'])->group(function() {
		// 认证用户点击我分享的小程序链接得积分
		Route::post('share', 'ShareController@shareGetIntegral');
		// 分享列表
		Route::get('share_list', 'ShareController@index');
		// 会员绑定
		Route::post('bind', 'UserController@bind');
		// 更新用户信息
		Route::post('update_user', 'UserController@updateUserInfo');
		// 获取用户信息
		Route::post('user_info', 'UserController@getUserInfo');
		// 投诉
		Route::post('complaints', 'ComplaintsController@add');
		// 我的排行
		Route::get('area_rank', 'IntegralController@area_rank');
        // 积分记录
        Route::get('integer_log', 'IntegralController@integer_log');

		/********视频相关**********/
		Route::group(['prefix' => 'video'],function ()
		{
			// 获取免费视频
			Route::get('free_list', 'VideoController@FreeVideoList');
			// 根据会员分组 获取 认证会员视频
			Route::get('group_list', 'VideoController@GroupVideoList');
			Route::get('group_member', 'VideoController@GroupVideoMember');
			Route::get('group_info', 'VideoController@GroupVideoInfo');
			// 根据会员 级别 返回 最新的 第一条视频
			Route::get('new_video', 'VideoController@NewVideo');
			// 看视频得积分
			Route::post('reward_integral', 'VideoController@rewardIntegral');
			// 进入视频时，打标记
			Route::post('time_mark', 'VideoController@inVideoTimeMark');
			// 退出视频时，删除标记
			Route::post('del_time_mark', 'VideoController@delVideoTimeMark');
		});

        Route::get('clock', 'IntegralController@clock');

	});
});