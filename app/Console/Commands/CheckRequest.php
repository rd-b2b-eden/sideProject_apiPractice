<?php

namespace App\Console\Commands;

use App\Exceptions\DatabaseException;
use App\Service\DataService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class CheckRequest extends Command
{
    protected DataService $dataService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '檢查是否有request在redis需要處理';

    public function __construct()
    {
        $this->dataService = new DataService();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws DatabaseException
     */
    public function handle(): void
    {
        $request = Redis::keys('data-request-*');
        $queueCount = count($request);
        if (empty($request)) {
            $this->info('無任何request需處理');
        }else{
            $sum = 0;
            foreach ($request as $value){
                $count = Redis::get($value);
                if ($count === null) {
                    $this->error('[error] 參數錯誤');
                    return;
                }
                $sum += intval($count);
                $response = $this->dataService->createData($count);
                Redis::del($value);
            }
            $this->info('已完成' . $queueCount . '筆queue，共產生' . $sum . '筆資料');
        }
    }
}
