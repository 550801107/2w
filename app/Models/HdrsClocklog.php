<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\HdrsClocklog
 *
 * @property int $id
 * @property int $user_id
 * @property string $date
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClocklog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClocklog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClocklog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClocklog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClocklog whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClocklog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClocklog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsClocklog whereUserId($value)
 * @mixin \Eloquent
 */
class HdrsClocklog extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'hdrs_clock_log';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'date', 'created_at', 'updated_at'];

}
