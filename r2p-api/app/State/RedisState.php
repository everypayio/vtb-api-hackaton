<?php declare(strict_types=1);

namespace App\State;

use App\State\Exceptions\InvalidStateException;
use Illuminate\Support\Facades\Redis;
use Throwable;

class RedisState extends State
{
    protected ?string $key = null;

    /**
     * RedisState constructor.
     *
     * @param ?string $prefix
     */
    public function __construct(
        protected readonly ?string $prefix = null,
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function prepare(string $id): static
    {
        $this->key = $id;

        if (is_string($this->prefix)) {
            $this->key = "$this->prefix$this->key";
        }

        return parent::prepare($id);
    }

    /**
     * {@inheritDoc}
     * @throws InvalidStateException
     */
    public function load(): static
    {
        $rawState = Redis::command('get', [$this->key]);

        try {
            $this->state = json_decode($rawState, true);
        } catch (Throwable $exception) {
            throw new InvalidStateException(
                id: $id,
                previous: $exception,
            );
        }

        $this->loadInternals($this->state['__internals']);
        unset($this->state['__internals']);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function exists(): bool
    {
        return (bool)Redis::command('exists', [$this->key]);
    }

    /**
     * {@inheritDoc}
     */
    public function save(): static
    {
        $value = json_encode(array_merge(
            $this->get(),
            ['__internals' => $this->dumpInternals()],
        ));

        $options = [$this->key, $value];

        if (!is_null($this->ttl)) {
            $options[] = $this->ttl;
        }

        Redis::command('set', $options);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function destroy(): static
    {
        Redis::command('del', [$this->key]);

        return $this;
    }
}
