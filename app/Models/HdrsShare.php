<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HdrsShare
 *
 * @property int $id
 * @property int $send_id
 * @property int $receive_id
 * @property int $video_id
 * @property boolean $type
 * @property int $integral
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShare newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShare newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShare query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShare whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShare whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShare whereIntegral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShare whereReceiveId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShare whereSendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShare whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShare whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShare whereVideoId($value)
 * @mixin \Eloquent
 */
class HdrsShare extends Model
{
	// 分享得积分标识
	const SHARE = 3;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'hdrs_share';

    /**
     * @var array
     */
    protected $fillable = ['send_id', 'receive_id', 'video_id', 'type', 'integral', 'created_at', 'updated_at'];

    public function share() {
        return $this->belongsTo(User::class,'receive_id');
    }

}
