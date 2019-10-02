<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HdrsClock
 *
 * @property int $id
 * @property int $integral
 * @property int $days
 * @property int $days_integral
 * @property string $rules
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClock query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClock whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClock whereDaysIntegral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClock whereIntegral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClock whereRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClock whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HdrsClock extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'hdrs_clock';

    /**
     * @var array
     */
    protected $fillable = ['integral', 'days', 'days_integral', 'rules', 'created_at', 'updated_at'];

}
