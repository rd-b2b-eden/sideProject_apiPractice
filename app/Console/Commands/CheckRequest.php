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
            $dataService = new DataService();
            $sum = 0;
            foreach ($request as $value){
                $count = Redis::get($value);
                $sum += $count;
                if (is_null($count)) {
                    $this->error('[error] 參數錯誤');
                }else{
                    sleep(1);   // 延遲1秒
                    $response = $dataService->createData($count);
                    Redis::del($value);
                }
            }
            $this->info('已完成'.$queueCount.'筆queue，共產生'.$sum.'筆資料');
        }
    }
}
