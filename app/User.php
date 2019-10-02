<?php

namespace App;

use App\Models\AdminUsers;
use App\Models\HdrsArea;
use App\Models\HdrsComplaints;
use App\Models\HdrsGroup;
use App\Models\HdrsShare;
use Encore\Admin\Facades\Admin;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\User
 *
 * @property int $id
 * @property string $openid
 * @property string $name
 * @property string $mobile
 * @property string $avatar
 * @property int $adminuser_id
 * @property int $area_id
 * @property int $group_id
 * @property int $integral
 * @property int $is_members
 * @property int $is_delete
 * @property string $email
 * @property \Illuminate\Support\Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HdrsComplaints $hdrsComplaints
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdminuserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIntegral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsMembers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $nickname 昵称
 * @property int $active 1:正常，2：禁用
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User notActive()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User isActive($active = 1)
 * @property int $admin_users_id 所属店铺id
 * @property-read \App\Models\HdrsArea $area
 * @property-read \App\Models\HdrsGroup $group
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdminUsersId($value)
 * @property-read \App\Models\AdminUsers $adminUsers
 * @property int $clock 连续签到
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereClock($value)
 */

class User extends Authenticatable implements JWTSubject
{
	// 正常
	const ACTIVE = 1;
	// 禁用
	const NOT_ACTIVE = 2;
	// 认证会员
	const AUTHENTICATION = 2;

    use Notifiable;

    protected $table = "hdrs_users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'openid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}


    public function hdrsComplaints() {
		return $this->hasOne(HdrsComplaints::class)->withDefault();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function area() {
    	return $this->belongsTo(HdrsArea::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function group() {
		return $this->belongsTo(HdrsGroup::class);
	}


    public function share() {
        return $this->belongsTo(HdrsShare::class,'receive_id');
    }

	public function adminUsers()
	{
		return $this->belongsTo(AdminUsers::class);
	}

	/**
	 * @desc 默认 查询 状态正常的用户
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param int $active
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeIsActive($query, $active = self::ACTIVE) {
		return $query->where('active', $active);
	}


	public static function getIsMemberDescript() {
		$states = [
			'on'  => ['value' => 1, 'text' => '未认证', 'color' => 'danger'],
			'off' => ['value' => 2, 'text' => '已认证', 'color' => 'success'],
		];
		return $states;
	}

    public static function getTody()
    {
        $id = Admin::user()->id;
        $result = User::where('admin_users_id','=',$id)
            ->whereDay('created_at',date('d'))
            ->count();
        return $result;
    }

    public static function getYesterday()
    {
        $id = Admin::user()->id;
        $result = User::where('admin_users_id','=',$id)
            ->whereDay('created_at',date('d',strtotime("-1 day")))
            ->count();
        return $result;
    }

}
