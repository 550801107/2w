<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HdrsAdvert
 *
 * @property int $id
 * @property string $url
 * @property int $sort
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsAdvert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsAdvert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsAdvert query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsAdvert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsAdvert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsAdvert whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsAdvert whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsAdvert whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsAdvert whereUrl($value)
 * @mixin \Eloquent
 * @property string $title 标题
 * @property string $link_url 外链
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsAdvert whereLinkUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsAdvert whereTitle($value)
 */
class HdrsAdvert extends Model
{
    // 正常
    const ACTIVE = 0;
    // 禁用
    const NOT_ACTIVE = 1;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'hdrs_advert';

    /**
     * @var array
     */
    protected $fillable = ['url', 'sort', 'status', 'created_at', 'updated_at'];

}
