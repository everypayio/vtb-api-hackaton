<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Ramsey\Uuid\Guid\Guid;
use Illuminate\Support\Str;
use Symfony\Component\Uid\Ulid;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    FilamentUser
{
    use Authorizable;
    use MustVerifyEmail;
    use CanResetPassword;
    use Authenticatable;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Notifiable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'organization',
        'apikey',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function accounts()
    {
        return $this->hasMany(Account::class, 'owner_id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() == 'client';
    }

    public function getApikey()
    {
        if (!$this->apikey) {
            $this->apikey = Str::orderedUuid();
            static::update(['apikey' => Str::orderedUuid()->toString()]);
            $this->fresh();
        }

        return $this->apikey;
    }
}
