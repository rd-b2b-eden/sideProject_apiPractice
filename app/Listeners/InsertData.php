<?php

namespace App\Listeners;

use App\Events\DataGot;
use App\Exceptions\DatabaseException;
use App\Service\DataService;
use Illuminate\Contracts\Queue\ShouldQueue;

class InsertData implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param DataGot $event
     * @param DataService $dataService
     * @return void
     * @throws DatabaseException
     */
    public function handle(DataGot $event, DataService $dataService): void
    {
        $count = $event->getCount();
        $dataService->createData($count);
    }
}
