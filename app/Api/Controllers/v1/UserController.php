<?php
namespace App\Api\Controllers\v1;

use App\Api\Controllers\ApiControllers;
use App\User;
use Illuminate\Http\Request;
use App\Models\HdrsClocklog;
use Illuminate\Support\Facades\Cache;

class UserController extends ApiControllers
{

	public function __construct()
	{

	}

	/**
	 * @desc 获取用户信息
	 * @return mixed
	 */
	public function getUserInfo() {
		$user = auth()->user();
		if (!empty($user->id)) {
            $qian = HdrsClocklog::where(['date' => date('Y-m-d'),'user_id'=>$user->id])->first();
            return $this->success([
				'id' => $user->id,
				'mobile' => $user->mobile,
				'is_clock' => $qian?'1':'0',
				'integral' => $user->integral,
				'is_members' => $user->is_members
						   ]);
		}
		return $this->failed('未授权');
	}

	/**
	 * @desc 更新 用户信息，比如 用户头像，昵称
	 *
	 * @param Request $request
	 * @return mixed
	 * 	userInfo	UserInfo	用户信息对象，不包含 openid 等敏感信息
	rawData	string	不包括敏感信息的原始数据字符串，用于计算签名
	signature	string	使用 sha1( rawData + sessionkey ) 得到字符串，用于校验用户信息，详见 用户数据的签名验证和加解密
	encryptedData	string	包括敏感数据在内的完整用户信息的加密数据，详见 用户数据的签名验证和加解密
	iv	string	加密算法的初始向量，详见 用户数据的签名验证和加解密
	 */
	public function updateUserInfo(Request $request) {
		$this->validate($request, [
//			'userInfo' => 'required',
//			'rawData' => 'required',
//			'signature' => 'required',
			'encryptedData' => 'required',
			'iv' => 'required',
		]);

		$user = auth()->user();
		$session_key = Cache::get('session_key:'.$user['openid']);
		$data  =  miniProgram()->encryptor->decryptData($session_key, request('iv'), request('encryptedData'));

		$status = User::where(['id' => $user->id])
					  ->update([
								   'nickname' => $data['nickName'],
								   'avatar' => $data['avatarUrl']
							   ]);
		if ($status) {
			return $this->success(['message' => '更新成功']);
		}
		return $this->failed('更新失败');
	}

	/**
	 * @desc 会员绑定
	 * iv,encryptedData
	 * @param Request $request
	 * @return mixed
	 */
	public function bind(Request $request)
	{
		$this->validate($request, [
			'encryptedData' => 'required',
			'iv' => 'required',
		]);
		$encryptedData = request('encryptedData');
		$iv = request('iv');
		$user = auth()->user();
		$session_key = Cache::get('session_key:'.$user['openid']);
		$decryptedData = miniProgram()->encryptor->decryptData($session_key, $iv, $encryptedData);
		$res = User::find($user['id']);
		if ($res['is_members']==2){
			return $this->success(['message' => '已绑定']);
		}
		$userInfo = User::where(['mobile' => $decryptedData['phoneNumber']])->first();
		// 如果是 线下 认证用户
		if (!empty($userInfo)) {
			// TODO: 使用事务
			$userInfo->openid = $user['openid'];
            $userInfo->avatar = $user['avatar'];
            // 更新线下 认证用户 openid
			$userInfo->save();
			// 删除原来的
			$status = User::where(['id' => $user['id']])->delete();
		}else{
			// 如果没有 线下绑定
			$userInfo = User::where(['id' => $user['id']])->first();
			$userInfo->mobile = $decryptedData['phoneNumber'];
			$userInfo->is_members = 1;
			$status = $userInfo->save();
		}

		if ($status) {
			$data['msg'] = '绑定成功';
		}else{
			$data['msg'] = '绑定失败';
		}
		return $this->success($data);
	}
}