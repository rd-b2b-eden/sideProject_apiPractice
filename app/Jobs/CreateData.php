<?php

namespace App\Jobs;

use App\Exceptions\DatabaseException;
use App\Service\DataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $count;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $count)
    {
        $this->count = $count;
    }

    /**
     * Execute the job.
     *
     * @param DataService $dataService
     * @return void
     * @throws DatabaseException
     */
    public function handle(DataService $dataService): void
    {
        $dataService->createData($this->count);
    }
}
