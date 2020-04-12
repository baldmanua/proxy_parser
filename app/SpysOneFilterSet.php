<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\SpysOneFilterSet
 *
 * @property int $id
 * @property int $xpp
 * @property int $xf1
 * @property int $xf2
 * @property int $xf3
 * @property int $xf4
 * @property int $xf5
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SpysOneFilterSet newModelQuery()
 * @method static Builder|SpysOneFilterSet newQuery()
 * @method static Builder|SpysOneFilterSet query()
 * @method static Builder|SpysOneFilterSet whereCreatedAt($value)
 * @method static Builder|SpysOneFilterSet whereId($value)
 * @method static Builder|SpysOneFilterSet whereStatus($value)
 * @method static Builder|SpysOneFilterSet whereUpdatedAt($value)
 * @method static Builder|SpysOneFilterSet whereXf1($value)
 * @method static Builder|SpysOneFilterSet whereXf2($value)
 * @method static Builder|SpysOneFilterSet whereXf3($value)
 * @method static Builder|SpysOneFilterSet whereXf4($value)
 * @method static Builder|SpysOneFilterSet whereXf5($value)
 * @method static Builder|SpysOneFilterSet whereXpp($value)
 * @mixin Eloquent
 */
class SpysOneFilterSet extends Model
{

    public static function getOldestUpdated()
    {
        return self::oldest('updated_at')->first();
    }
}
