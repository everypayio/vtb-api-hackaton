<?php

declare(strict_types=1);

namespace App\Models;


class Bank extends Model
{
    protected $attributes = [
        'bic'      => null,
        'name'     => null,
        'accounts' => [],
        'swbics'   => null,
        'full'     => [],
    ];
    protected $fillable = [
        'bic',
        'name',
        'accounts',
        'full',
    ];

    public function getNameWithBicAttribute()
    {
        return $this->bic." ".$this->name;
    }
}
