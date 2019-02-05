<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Insect
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Insect newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Insect newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Insect query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Insect whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Insect whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Insect whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Insect whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Insect whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $position
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Insect sorted()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Insect wherePosition($value)
 */
class Insect extends Model {
    use \Rutorika\Sortable\SortableTrait;
}
