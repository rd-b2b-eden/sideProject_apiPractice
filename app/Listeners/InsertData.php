<?php

namespace App\Listeners;

use App\Events\DataGot;
use App\Exceptions\DatabaseException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InsertData implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param \App\Events\DataGot $event
     * @return void
     * @throws DatabaseException
     */
    public function handle(DataGot $event): void
    {
        $dataService = $event->getDataService();
        $count = $event->getCount();
        $dataService->createData($count);
    }
}
