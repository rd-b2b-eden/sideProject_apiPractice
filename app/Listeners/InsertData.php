<?php

namespace App\Listeners;

use App\Events\DataGot;
use App\Service\DataService;
use Illuminate\Contracts\Queue\ShouldQueue;

class InsertData implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param DataGot $event
     * @return void
     */
    public function handle(DataGot $event): void
    {
        $count = $event->getCount();
        $dataService = app(DataService::class);
        $dataService->createData($count);
    }
}
