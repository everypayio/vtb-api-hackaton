<?php

declare(strict_types=1);

namespace App\Database;

use MongoDB\Driver\CursorInterface;

class CursorAdapter implements \Iterator
{
    public function __construct(protected CursorInterface & \Iterator $cursor)
    {
        $cursor->setTypeMap([
                                'array'    => 'array',
                                'document' => 'array',
                                'root'     => 'array',
                            ]);
    }

    public static function make($cursor)
    {
        return new static($cursor);
    }

    public function toArray()
    {
        return $this->cursor->toArray();
    }

    public function current(): mixed
    {
        return $this->cursor->current();
    }

    public function next(): void
    {
        $this->cursor->next();
    }

    public function valid(): bool
    {
        return $this->cursor->valid();
    }

    public function rewind(): void
    {
        $this->cursor->rewind();
    }

    public function first(): mixed
    {
        $this->rewind();

        return $this->cursor->current();
    }

    public function key(): mixed
    {
        return $this->cursor->key();
    }
}
