<?php

namespace App\Service;

use App\Common\StatusMessage;
use App\Exceptions\ApiException;
use App\Exceptions\DatabaseException;
use App\Models\Data;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DataService
{
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
}
