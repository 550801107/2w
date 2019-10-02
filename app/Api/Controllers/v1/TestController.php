<?php
namespace App\Api\Controllers\v1;

use App\Api\Controllers\ApiControllers;

/**
 * Created by PhpStorm.
 * User: fanlingang
 * Date: 2019/6/20
 * Time: 09:50
 */

class TestController extends ApiControllers
{



	public function login1()
	{
		$code = request('code');
		var_dump(miniProgram()->auth->session($code));die;
		$credentials = request(['email', 'password']);

		if (! $token = auth('api')->attempt($credentials)) {
			return response()->json(['error' => 'Unauthorized'], 401);
		}

		return $this->respondWithToken($token);
	}
}