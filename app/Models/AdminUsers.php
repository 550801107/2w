<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdminUsers
 *
 * @property int $id
 * @property string $storename
 * @property string $mobile
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $avatar
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers whereStorename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers whereUsername($value)
 * @mixin \Eloquent
 * @property string $store_name
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers whereStoreName($value)
 * @property string $address
 * @property int $storenumber
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUsers whereStorenumber($value)
 */
class AdminUsers extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['store_name', 'mobile', 'username', 'password', 'name', 'avatar', 'remember_token', 'created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function user() {
		return $this->hasOne(User::class);
	}

	/**
	 * @desc 获取 所有 id => store_name
	 * @return array
	 */
	public static function getIdToStoreName()
	{
		return self::select(['id', 'store_name'])->get()->mapWithKeys(function ($item) {
			return [$item['id'] => $item['store_name']];
		})->toArray();
	}
}
