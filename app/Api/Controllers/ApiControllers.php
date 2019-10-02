<?php
/**
 * Created by PhpStorm.
 * User: fanlingang
 * Date: 2019/6/19
 * Time: 22:17
 */
namespace App\Api\Controllers;

use App\Api\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApiControllers extends Controller
{

	use ApiResponse;


	public function validate(Request $request, array $rules,
								array $messages = [], array $customAttributes = []) {
		$validator = \Validator::make($request->all(), $rules, $messages, $customAttributes);
		if ($validator->fails()) {
			throw new HttpResponseException($this->failed($validator->errors(), 422));
		}
	}

	/**
	 * 需要小程序的code
	 * Get a JWT via given credentials.
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login(Request $request)
	{
		$this->validate($request, [
			'code' => 'required'
		]);

		$code = request('code');
		$res = miniProgram()->auth->session($code);
 		if (!empty($res['openid'])) {
			//存在与不存在 都更新 session_key 到redis
            if(isset($res['expires_in'])){
                $expires_in = $res['expires_in'];
            }else{
                $expires_in = 7200;
            }
            Cache::set('session_key:'.$res['openid'], $res['session_key'], $expires_in);
			// 判断openid是否存在
			$user = User::where(['openid' => $res['openid'], 'active' => User::ACTIVE])->select(['id', 'nickname', 'mobile', 'integral', 'is_members',])->first();
			if (empty($user)) {
				$user = User::create(['openid' => $res['openid']]);
			}
			$token = auth('api')->login($user);
			return $this->respondWithToken($token);
		}
		return $this->failed('Unauthorized', 401);
	}

	/**
	 * Get the authenticated User.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function me()
	{
//		return response()->json(auth()->user());
	}

	/**
	 * Log the user out (Invalidate the token).
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout()
	{
//		auth()->logout();
//
//		return response()->json(['message' => 'Successfully logged out']);
	}

	/**
	 * Refresh a token.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function refresh()
	{
//		return $this->respondWithToken(auth()->refresh());
	}

	/**
	 * Get the token array structure.
	 *
	 * @param  string $token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function respondWithToken($token)
	{
		return $this->success([
									'access_token' => $token,
									'token_type' => 'bearer',
									'expires_in' => env('JWT_TTL')
								]);
	}


}