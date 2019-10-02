<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HdrsIntegralLog
 *
 * @property int $id
 * @property int $user_id
 * @property string $goods
 * @property string $integral_num
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsIntegralLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsIntegralLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsIntegralLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsIntegralLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsIntegralLog whereGoods($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsIntegralLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsIntegralLog whereIntegralNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsIntegralLog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsIntegralLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsIntegralLog whereUserId($value)
 * @mixin \Eloquent
 */
class HdrsIntegralLog extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'hdrs_integral_log';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'goods', 'integral_num', 'title', 'created_at', 'updated_at'];

}
