<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HdrsVideo
 *
 * @property int $id
 * @property string $title
 * @property string $picture
 * @property string $video_url
 * @property int $get_integral
 * @property string $length_time
 * @property int $pv
 * @property int $group_id
 * @property boolean $active
 * @property boolean $is_delete
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo whereGetIntegral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo whereIsDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo whereLengthTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo wherePv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $type 状态 1 会员视频;2免费视屏
 * @property-read \App\Models\HdrsGroup $group
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsVideo whereVideoUrl($value)
 */
class HdrsVideo extends Model
{
	// 正常
	const ACTIVE = 1;
	// 禁用
	const NOT_ACTIVE = 2;
	// 免费视频
	const FREE = 2;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'hdrs_video';

    /**
     * @var array
     */
    protected $fillable = ['title', 'picture', 'video_url', 'get_integral', 'length_time', 'pv', 'group_id', 'active', 'is_delete', 'created_at', 'updated_at'];


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function group() {
		return $this->belongsTo(HdrsGroup::class);
	}


//	public function getVideoUrlAttribute($value)
//	{
//		return urldecode($value);
//	}
}
