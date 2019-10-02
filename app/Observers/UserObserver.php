<?php

namespace App\Observers;

use App\User;
use Encore\Admin\Facades\Admin;

class UserObserver
{
	/**
	 * 监听用户创建的事件。
	 *
	 * @param  User  $user
	 * @return void
	 */
	public function creating(User $user)
	{
		if (empty($user->password)){
			$user->password = \Crypt::encryptString('123456');
		}
		$user->admin_users_id = Admin::user()->id??0;
		//
	}


	/**
	 * 监听用户删除事件。
	 *
	 * @param  User  $user
	 * @return void
	 */
	public function deleting(User $user)
	{
		//
	}

	public function updating(User $user)
	{

	}
}