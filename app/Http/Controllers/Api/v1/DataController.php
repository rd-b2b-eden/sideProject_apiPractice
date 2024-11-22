<?php

namespace App\Http\Controllers\Api\v1;

use App\Common\StatusMessage;
use App\Events\DataGot;
use App\Exceptions\ApiException;
use App\Exceptions\DatabaseException;
use App\Http\Controllers\Controller;
use App\Jobs\CreateData;
use App\Models\Data;
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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @throws DatabaseException
     */
    public function store(Request $request): JsonResponse
    {
        $count = $request->input('count');
        return $this->dataService->createData($count);
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
