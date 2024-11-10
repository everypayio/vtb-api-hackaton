<?php declare(strict_types=1);

namespace App\State\Contracts;

interface StateContract
{
    /**
     * Initialize.
     *
     * @param array $state
     * @return static
     */
    public function initialize(array $state = []): static;

    /**
     * Set ttl.
     *
     * @param ?int $ttl
     * @return static
     */
    public function ttl(?int $ttl = null): static;

    /**
     * Prepare.
     *
     * @param string $id
     * @return static
     */
    public function prepare(string $id): static;

    /**
     * Load.
     *
     * @return static
     */
    public function load(): static;

    /**
     * Determinate is state exists.
     *
     * @return bool
     */
    public function exists(): bool;

    /**
     * Save.
     *
     * @return static
     */
    public function save(): static;

    /**
     * Destroy.
     *
     * @return static
     */
    public function destroy(): static;

    /**
     * Get id.
     *
     * @return ?string
     */
    public function getId(): ?string;

    /**
     * Set value.
     *
     * @param string $key
     * @param mixed $value
     * @return static
     */
    public function set(string $key, mixed $value): static;

    /**
     * Merge.
     *
     * @param string $key
     * @param array $state
     * @return static
     */
    public function merge(string $key, array $state): static;

    /**
     * Get.
     *
     * @param ?string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(?string $key = null, mixed $default = null): mixed;
}
