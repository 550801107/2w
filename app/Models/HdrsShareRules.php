<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HdrsShareRules
 *
 * @property int $id
 * @property int $integral
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShareRules newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShareRules newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShareRules query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShareRules whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShareRules whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShareRules whereIntegral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HdrsShareRules whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HdrsShareRules extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['integral', 'created_at', 'updated_at'];

}
