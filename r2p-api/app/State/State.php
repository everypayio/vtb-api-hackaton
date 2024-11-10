<?php declare(strict_types=1);

namespace App\State;

use App\State\Contracts\StateContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class State implements StateContract
{
    protected ?string $id = null;
    protected array $state = [];
    protected ?int $ttl = null;

    /**
     * {@inheritDoc}
     */
    public function initialize(array $state = []): static
    {
        $this->prepare(Str::uuid()->toString());

        $this->state = $state;
        $this->state['id'] = $this->getId();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function ttl(?int $ttl = null): static
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function prepare(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function set(string $key, mixed $value): static
    {
        Arr::set($this->state, $key, $value);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function merge(string $key, array $state): static
    {
        $this->set($key, array_merge(
            $this->get($key, []),
            $state,
        ));

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function get(?string $key = null, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return $this->state;
        }

        return Arr::get($this->state, $key, $default);
    }

    /**
     * Dump internals.
     *
     * @return array
     */
    protected function dumpInternals(): array
    {
        return [
            'ttl' => $this->ttl,
        ];
    }

    /**
     * Load internals.
     *
     * @param array $internals
     * @return void
     */
    protected function loadInternals(array $internals): void
    {
        $this->ttl = $internals['ttl'];
    }
}
