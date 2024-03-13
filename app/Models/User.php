<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $ulid
 * @property string $name
 * @property string $email
 * @property string $password
 * @property CarbonInterface|null $email_verified_at
 * @property CarbonInterface $created_at
 * @property CarbonInterface|null $updated_at
 * @property CarbonInterface|null $blocked_at
 * @property string|null $blocked_reason
 * @method static Builder newModelQuery()
 * @method static Builder newQuery()
 * @method static Builder query()
 * @method static Builder create(array $attributes)
 * @method static Builder first()
 * @method static Builder firstOrFail()
 * @method static Builder find($value)
 * @method static Builder findOrFail($value)
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected string $guard_name = 'api';

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (User $customer) {
            $customer->ulid = (string)Str::ulid();
        });
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => empty(trim($value)) ? '' : $value,
        );
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            set: function (string $value) {
                $validate = Validator::make(
                    ['email' => $value],
                    ['email' => 'required', 'email']
                );
                if ($validate->fails()) {
                    throw new \Exception($validate->errors()->first());
                }
                return $value;
            }
        );
    }
}
