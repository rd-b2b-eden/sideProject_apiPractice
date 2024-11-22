<?php

namespace App\Jobs;

use App\Exceptions\DatabaseException;
use App\Models\Data;
use App\Service\DataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected DataService $dataService;
    protected mixed $count;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(DataService  $dataService, mixed $count)
    {
        $this->dataService = $dataService;
        $this->count = $count;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws DatabaseException
     */
    public function handle(): void
    {
        sleep(1);   // 延遲1秒
        $this->dataService->createData($this->count);
    }
}