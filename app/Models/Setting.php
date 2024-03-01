<?php

namespace App\Models;

use App\Helpers\Setting\SettingsTypesEnum;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string|null $description
 * @property string $type
 * @property string $value
 * @property-read  string|bool|int|float|CarbonInterface $val
 * @property bool $active
 * @method static Setting newModelQuery()
 * @method static Setting newQuery()
 * @method static Setting query()
 * @method static Setting create(array $attributes)
 * @method static Setting update(array $attributes)
 * @method static Setting first()
 * @method static Setting firstOrFail()
 * @method static Setting find($value)
 * @method static Setting findOrFail($value)
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

    public function val(): Attribute
    {
        return Attribute::make(
            get: fn () => SettingsTypesEnum::parse($this->type, $this->value)
        );
    }
}
