<?php declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Support\Str;
use Symfony\Component\Uid\Ulid;

trait UsesUlid
{
    protected static function generateUuidOrUlidForModel($model): string
    {
        return $model->hasUlid() ? Ulid::generate() : (string)Str::orderedUuid();
    }

    public function hasUlid(): bool
    {
        return !(isset($this->uuid_type) && $this->uuid_type == 'uuid');
    }

    public function ulid(): Ulid
    {
        return Ulid::fromString($this->{$this->getKeyName()});
    }

    protected static function bootUsesUlid(): void
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                // Generates order UUID, so all generated UUID will be sorted by asc id
                $model->{$model->getKeyName()} = self::generateUuidOrUlidForModel($model);
            }
        });

        static::creating(function ($model) {
            if (!$model->{$model->getKeyName()}) {
                // generate ULID or UUID for model
                $model->{$model->getKeyName()} = self::generateUuidOrUlidForModel($model);
            }
        });

        static::saving(function ($model) {
            $originalUlid = $model->getOriginal($model->getKeyName());

            // do not change ULID, ever
            if ($originalUlid !== $model->{$model->getKeyName()}) {
                $model->{$model->getKeyName()} = $originalUlid;
            }
        });
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }
}
