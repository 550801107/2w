<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HdrsComplaints
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsComplaints newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsComplaints newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsComplaints query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsComplaints whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsComplaints whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsComplaints whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsComplaints whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsComplaints whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsComplaints whereUserId($value)
 * @mixin \Eloquent
 * @property string $mobile 联系方式
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsComplaints whereMobile($value)
 */
class HdrsComplaints extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'mobile', 'content', 'created_at', 'updated_at'];


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function user()
	{
		return $this->belongsTo(User::class)->withDefault();
	}
}
