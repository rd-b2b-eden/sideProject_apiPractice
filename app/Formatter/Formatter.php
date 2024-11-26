<?php

namespace App\Formatter;

use App\Formatter\response\StatusMessage;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Formatter
{
    public function dataResponse($response, $httpCode = Response::HTTP_OK): JsonResponse
    {
        $statusCode = $response['status'] ?? StatusMessage::ERROR;
        $description = $response['description'] ?? StatusMessage::getDescription($statusCode);
        $httpCode = StatusMessage::getHttpCode($statusCode);
        $description = str_replace('\u0000', '', $description);

        $result =  [
            'metadata' =>   [
                "status"        =>  $statusCode,
                "description"   =>  $description
            ]
        ];

        return response()->json($result, $httpCode, [], JSON_UNESCAPED_UNICODE);
    }
}
