<?php

namespace App\Events;

use App\Service\DataService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DataGot
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private DataService $dataService;
    private mixed $count;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DataService $dataService, mixed $count)
    {
        $this->dataService = $dataService;
        $this->count = $count;
    }

    public function getDataService(): DataService
    {
        return $this->dataService;
    }

    public function getCount(): mixed
    {
        return $this->count;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
