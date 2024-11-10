<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{

    protected $attributes = [
        'options'     => [],
        'owner_id'    => null,
        'bik'         => null,
        'corrAccount' => null,
        'number'      => null,
    ];

    protected $fillable = [
        'bik',
        'corrAccount',
        'number',
        'title',
        'options',
        'owner_id',
    ];

    protected $appends = [
        'accountMasked',
        'shortName',
    ];

    public function scopeOwned($q, $user_id)
    {
        return $q->where('owner_id', $user_id);
    }

    public function bank(): HasOne|\MongoDB\Laravel\Relations\HasOne
    {
        return $this->hasOne(Bank::class, 'bic', 'bik');
    }

    public function owner(): HasOne|\MongoDB\Laravel\Relations\HasOne
    {
        return $this->hasOne(User::class, '_id', 'owner_id');
    }

    public function getAccountMaskedAttribute(): ?string
    {
        if (!$this->id) {
            return null;
        }

        return Str::mask(substr($this->number, -8), '●', 0, 4);
    }

    public function getShortNameAttribute()
    {
        if (!$this->id) {
            return null;
        }

        return $this->getAccountMaskedAttribute()." - ".$this->bik.' '.$this->bank->name;
    }
}
