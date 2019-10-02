<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RileUser
 *
 * @property int $role_id
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RileUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RileUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RileUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RileUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RileUser whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RileUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RileUser whereUserId($value)
 * @mixin \Eloquent
 */
class RileUser extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'admin_role_users';

    /**
     * @var array
     */
    protected $fillable = ['role_id', 'user_id', 'created_at', 'updated_at'];

}
