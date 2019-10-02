<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HdrsArea
 *
 * @property int $id
 * @property string $hdrs_area
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsArea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsArea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsArea query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsArea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsArea whereHdrsArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsArea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsArea whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $name 区域
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsArea whereName($value)
 */
class HdrsArea extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'hdrs_area';

    /**
     * @var array
     */
    protected $fillable = ['name', 'created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
    public function user() {
    	return $this->hasOne(User::class);
	}

	/**
	 * @desc 获取 所有 id => name
	 * @return array
	 */
	public static function getIdToName()
	{
		return self::select(['id', 'name'])->get()->mapWithKeys(function ($item) {
			return [$item['id'] => $item['name']];
		})->toArray();
	}
}
