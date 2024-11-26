<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\DataGot;
use App\Formatter\Formatter;
use App\Formatter\response\StatusMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Jobs\CreateData;
use App\Service\DataService;
use Illuminate\Http\JsonResponse;

class DataController extends Controller
{
    private Formatter $formatter;

    /**
     * @param Formatter $formatter
     */
    public function __construct(Formatter $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeByCommand(StorePostRequest $request): JsonResponse
    {
        $validated = $request->safe()->only(['count']);
        $dataService = new DataService();
        $response = $dataService->createQueue($validated['count']);
        return $this->formatter->dataResponse($response);
    }

    public function storeByEvent(StorePostRequest $request): JsonResponse
    {
        $validated = $request->safe()->only(['count']);
        event(new DataGot($validated['count']));
        return $this->formatter->dataResponse(
            [
                'status' => StatusMessage::EVENT_SUCCESS,
                'description' => '[event] 資料產生中，將產生' . $validated['count'] . '筆',
            ]
        );
    }

    public function storeByJob(StorePostRequest $request): JsonResponse
    {
        $validated = $request->safe()->only(['count']);
        $this->dispatch(new CreateData($validated['count']));
        return $this->formatter->dataResponse(
            [
                'status' => StatusMessage::JOB_SUCCESS,
                'description' => '[job] 資料產生中，將產生' . $validated['count'] . '筆',
            ]
        );
    }
}
