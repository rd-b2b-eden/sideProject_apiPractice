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
    private int $sleepTime = 1; //延遲時間
    /**
     * @throws DatabaseException
     */
    public function createData($count): JsonResponse
    {
        if (!is_null($count)) {
            // 有資料
            $count = intval($count);
            // 隨機產生資料
            try {
                sleep($this->sleepTime);
                Data::factory()->count($count)->create();
            }catch (\Exception $exception){
                throw new DatabaseException('database insert error.');
            }
        }else{
            // 無資料
            throw new ApiException(500);
        }
        $headers = array(
            'Content-Type' => 'application/json; charset=utf-8'
        );
        return response()->json(['status' => StatusMessage::SUCCESS, 'detail' => '資料產生成功，共產生'.$count.'筆'], Response::HTTP_OK, $headers, JSON_UNESCAPED_UNICODE);
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
