<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string|null $description
 * @property string $value
 * @property-read mixed $val
 * @property bool $active
 * @method static Setting newModelQuery()
 * @method static Setting newQuery()
 * @method static Setting query()
 * @method static Setting where(...$arg)
 * @method static Setting create(array $attributes)
 * @method static int update(array $attributes)
 * @method static Setting first()
 * @method static Setting firstOrFail()
 * @method static Setting find($value)
 * @method static Setting findOrFail($value)
 * @method static bool exists()
 */
class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'name',
        'title',
        'description',
        'type',
        'value',
        'active',
    ];

    public $timestamps = false;
}
