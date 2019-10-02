<?php
/**
 * Created by PhpStorm.
 * User: fanlingang
 * Date: 2019/6/18
 * Time: 20:57
 */

/**
 * @desc 获取 用户 状态
 * @return array
 */
function getStatusDescript() {
	$states = [
		'on'  => ['value' => 1, 'text' => '启用', 'color' => 'success'],
		'off' => ['value' => 2, 'text' => '禁用', 'color' => 'danger'],
	];
	return $states;
}

/**
 * @desc 获取 视频类型
 * @return array
 */
function getVideoTypeDescript() {
	$states = [
		'on'  => ['value' => 1, 'text' => '会员', 'color' => 'success'],
		'off' => ['value' => 2, 'text' => '分享', 'color' => 'danger'],
	];
	return $states;
}

/**
 * @return \EasyWeChat\MiniProgram\Application
 */
function miniProgram() {
	$config = [
		'app_id' => env('MINI_PROGRAM_APP_ID'),
		'secret' => env('MINI_PROGRAM_APP_SECRET'),

		// 下面为可选项
		// 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
		'response_type' => 'array',

		'log' => [
			'level' => env('MINI_PROGRAM_LEVEL'),
			'file' => env('LOG_CHANNEL'),
		],
	];
	return \EasyWeChat\Factory::miniProgram($config);
}