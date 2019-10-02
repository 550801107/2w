<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HdrsGroup
 *
 * @property int $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsGroup whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $name 名称
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsGroup whereName($value)
 * @property-read \App\Models\HdrsVideo $video
 */
class HdrsGroup extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'hdrs_group';

    /**
     * @var array
     */
    protected $fillable = ['title', 'created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function user() {
		return $this->hasOne(User::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function video() {
		return $this->hasOne(HdrsVideo::class);
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
