<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Test1
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test1 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test1 newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Test1 onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test1 query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test1 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test1 whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test1 whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test1 whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test1 whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Test1 whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test1 withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Test1 withoutTrashed()
 * @mixin \Eloquent
 */
class Test1 extends Model
{

     use SoftDeletes;
     protected $fillable = ['key','value',];





}