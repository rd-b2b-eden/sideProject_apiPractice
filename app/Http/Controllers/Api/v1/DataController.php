<?php

namespace App\Http\Controllers\Api\v1;

use App\Common\StatusMessage;
use App\Exceptions\ApiException;
use App\Exceptions\DatabaseException;
use App\Http\Controllers\Controller;
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
