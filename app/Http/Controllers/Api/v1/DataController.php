<?php

namespace App\Http\Controllers\Api\v1;

use App\Common\StatusMessage;
use App\Events\DataGot;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Jobs\CreateData;
use App\Service\DataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class DataController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function storeByCommand(StorePostRequest $request): JsonResponse
    {
        $validated = $request->safe()->only(['count']);
        $dataService = new DataService();
        $dataService->createQueue($validated['count']);
        return response()->json(['status' => StatusMessage::COMMAND_SUCCESS, 'detail' => '[command] 資料產生中，將產生'.$validated['count'].'筆'], Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }

    public function storeByEvent(StorePostRequest $request): JsonResponse
    {
        $validated = $request->safe()->only(['count']);
        event(new DataGot($validated['count']));
        return response()->json(['status' => StatusMessage::EVENT_SUCCESS, 'detail' => '[event] 資料產生中，將產生'.$validated['count'].'筆'], Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }

    public function storeByJob(StorePostRequest $request): JsonResponse
    {
        $validated = $request->safe()->only(['count']);
        $this->dispatch(new CreateData($validated['count']));
        return response()->json(['status' => StatusMessage::JOB_SUCCESS, 'detail' => '[job] 資料產生中，將產生'.$validated['count'].'筆'], Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }
}
