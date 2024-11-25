<?php

namespace App\Service;

use App\Common\StatusMessage;
use App\Exceptions\ApiException;
use App\Exceptions\DatabaseException;
use App\Models\Data;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class DataService
{
    private int $sleepSecond = 1; //延遲時間
    /**
     * @throws DatabaseException
     */
    public function createData(int $count): void
    {
        // 隨機產生資料
        sleep($this->sleepSecond);
        for ($i = 0; $i < $count; $i++) {
            Data::create([
                'id' => Str::uuid()->toString(),
                'description' => Str::random(),
            ]);
        }
    }

    /**
     * @param $count
     * @return void
     * 建立queue
     */
    public function createQueue($count): void
    {
        $redis = Redis::connection();
        $redis->set('data-request-'.Str::uuid()->toString(),$count);
    }
}
