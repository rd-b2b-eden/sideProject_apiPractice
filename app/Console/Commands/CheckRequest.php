<?php

namespace App\Console\Commands;

use App\Exceptions\ApiException;
use App\Exceptions\DatabaseException;
use App\Service\DataService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class CheckRequest extends Command
{
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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws DatabaseException
     */
    public function handle(): void
    {
        $redis = Redis::connection();
        $request = $redis->keys('data-request-*');
        $queueCount = count($request);
        if (is_null($request)) {
            $this->info('無任何request需處理');
        }else{
            $dataService = new DataService();
            $sum = 0;
            foreach ($request as $value){
                $count = $redis->get($value);
                $sum += $count;
                if (is_null($count)) {
                    $this->error('[error] 參數錯誤');
                }else{
                    sleep(1);   // 延遲1秒
                    $response = $dataService->createData($count);
                    $redis->del($value);
                }
            }
            $this->info('已完成'.$queueCount.'筆queue，共產生'.$sum.'筆資料');
        }
    }
}
