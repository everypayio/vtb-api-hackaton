<?php declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AuthorizedEvent implements ShouldBroadcast
{
    /**
     * AuthorizedEvent constructor.
     *
     * @param string $stateId
     * @param bool $isAuthorized
     * @param array $additional
     */
    public function __construct(
        protected string $stateId,
        protected bool   $isAuthorized,
        protected array  $additional = [],
    )
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel("state.$this->stateId");
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'authorize';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return array_merge([
            'isAuthorized' => $this->isAuthorized,
        ], $this->additional);
    }
}
