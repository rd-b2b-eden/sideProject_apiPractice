<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DataGot
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $count;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $count)
    {
        $this->count = $count;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
