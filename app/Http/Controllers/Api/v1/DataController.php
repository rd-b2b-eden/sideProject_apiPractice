<?php

namespace App\Http\Controllers\Api\v1;

use App\Common\StatusMessage;
use App\Events\DataGot;
use App\Http\Controllers\Controller;
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
    public function storeByCommand(Request $request): JsonResponse
    {
        $invalid = $this->checkRequest($request);
        if ($invalid) {
            $description = implode(',', $invalid);
            return response()->json(['status' => StatusMessage::PARAMETER_ERROR, 'detail' => $description], Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);
        }
        $count = $request->input('count');
        $dataService = new DataService();
        $dataService->createQueue($count);
        return response()->json(['status' => StatusMessage::COMMAND_SUCCESS, 'detail' => '[command] 資料產生中，將產生'.$count.'筆'], Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }

    public function storeByEvent(Request $request): JsonResponse
    {
        $invalid = $this->checkRequest($request);
        if ($invalid) {
            $description = implode(',', $invalid);
            return response()->json(['status' => StatusMessage::PARAMETER_ERROR, 'detail' => $description], Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);
        }
        $count = $request->input('count');
        event(new DataGot($count));
        return response()->json(['status' => StatusMessage::EVENT_SUCCESS, 'detail' => '[event] 資料產生中，將產生'.$count.'筆'], Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }

    public function storeByJob(Request $request): JsonResponse
    {
        $invalid = $this->checkRequest($request);
        if ($invalid) {
            $description = implode(',', $invalid);
            return response()->json(['status' => StatusMessage::PARAMETER_ERROR, 'detail' => $description], Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);
        }
        $count = $request->input('count');
        $this->dispatch(new CreateData($count));
        return response()->json(['status' => StatusMessage::JOB_SUCCESS, 'detail' => '[job] 資料產生中，將產生'.$count.'筆'], Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }

    private function checkRequest(Request $request): array
    {
        $description = [];
        $validation = Validator::make($request->all(), [
            'count' => 'required|integer',
            'uuid' => 'required',
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();
            foreach ($errors->all() as $message) {
                $description[] = $message;
            }
        }

        return $description;
    }
}
