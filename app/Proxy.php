<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Proxy
 *
 * @property int $id
 * @property string $address
 * @property string $port
 * @property string $type
 * @property string $anonymity
 * @property string $country
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Proxy newModelQuery()
 * @method static Builder|Proxy newQuery()
 * @method static Builder|Proxy query()
 * @method static Builder|Proxy whereAddress($value)
 * @method static Builder|Proxy whereAnonymity($value)
 * @method static Builder|Proxy whereCountry($value)
 * @method static Builder|Proxy whereCreatedAt($value)
 * @method static Builder|Proxy whereId($value)
 * @method static Builder|Proxy wherePort($value)
 * @method static Builder|Proxy whereType($value)
 * @method static Builder|Proxy whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Proxy extends Model
{
    //
}
