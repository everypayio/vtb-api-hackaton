<?php declare(strict_types=1);

namespace App\Models;

class Widget extends Model {
    protected $fillable = [
        'type',
        'account',
        'settings'
    ];
}
