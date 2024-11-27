<?php

namespace App\Service;

use App\Formatter\response\StatusMessage;
use App\Models\Data;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class DataService
{
    private int $sleepSecond = 1; //延遲時間
    /**
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
     * @param int $count
     * @return array 建立queue
     * 建立queue
     */
    public function createQueue(int $count): array
    {
        $redis = Redis::connection();
        $redis->set('data-request-'.Str::uuid()->toString(),$count);
        return [
            'status' => StatusMessage::COMMAND_SUCCESS,
            'description' => '[command] 資料產生中，將產生' . $count . '筆',
        ];
    }
}
