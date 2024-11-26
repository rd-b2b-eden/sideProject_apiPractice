<?php

namespace App\Exceptions;

use App\Formatter\Formatter;
use App\Formatter\response\StatusMessage;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception): JsonResponse
    {
        $formatter = new Formatter();
        $defaultError = [
            'status' => StatusMessage::ERROR,
            'description' => $exception->getMessage(),
        ];
        if ($exception instanceof ApiException) {
            $defaultError['status'] = StatusMessage::API_ERROR;
            $defaultError['description'] = '[Error] Api錯誤';
        }
        if ($exception instanceof DatabaseException) {
            $defaultError['status'] = StatusMessage::DATABASE_INSERT_ERROR;
            $defaultError['description'] = '[Error] 資料庫匯入錯誤';
        }
        return $formatter->dataResponse($defaultError);
    }
}
