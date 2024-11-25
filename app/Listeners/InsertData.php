<?php

namespace App\Listeners;

use App\Events\DataGot;
use App\Exceptions\DatabaseException;
use App\Service\DataService;
use Illuminate\Contracts\Queue\ShouldQueue;

class InsertData implements ShouldQueue
{
    private DataService $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Handle the event.
     *
     * @param DataGot $event
     * @return void
     * @throws DatabaseException
     */
    public function handle(DataGot $event): void
    {
        $count = $event->getCount();
        $this->dataService->createData($count);
    }
}
