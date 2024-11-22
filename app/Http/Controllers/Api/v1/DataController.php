<?php

namespace App\Http\Controllers\Api\v1;

use App\Common\StatusMessage;
use App\Events\DataGot;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Jobs\CreateData;
use App\Service\DataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DataController extends Controller
{
    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeByCommand(Request $request): JsonResponse
    {
        $count = $request->input('count');
        if (isset($count)) {
            $this->dataService->createQueue($count);
            $headers = array(
                'Content-Type' => 'application/json; charset=utf-8'
            );
            return response()->json(['status' => StatusMessage::EVENT_SUCCESS, 'detail' => '[command] 資料產生中，將產生'.$count.'筆'], Response::HTTP_OK, $headers, JSON_UNESCAPED_UNICODE);
        }else{
            throw new ApiException('[parameter] 輸入參數count錯誤');
        }
    }

    public function storeByEvent(Request $request): JsonResponse
    {
        $count = $request->input('count');
        $service = app(DataService::class);
        event(new DataGot($service, $count));
        $headers = array(
            'Content-Type' => 'application/json; charset=utf-8'
        );
        return response()->json(['status' => StatusMessage::EVENT_SUCCESS, 'detail' => '[event] 資料產生中，將產生'.$count.'筆'], Response::HTTP_OK, $headers, JSON_UNESCAPED_UNICODE);
    }

    public function storeByJob(Request $request): JsonResponse
    {
        $count = $request->input('count');
        $service = app(DataService::class);
        $this->dispatch(new CreateData($service, $count));
        $headers = array(
            'Content-Type' => 'application/json; charset=utf-8'
        );
        return response()->json(['status' => StatusMessage::EVENT_SUCCESS, 'detail' => '[job] 資料產生中，將產生'.$count.'筆'], Response::HTTP_OK, $headers, JSON_UNESCAPED_UNICODE);
    }
}
