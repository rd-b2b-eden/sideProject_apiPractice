<?php

namespace App\Formatter\response;

use Symfony\Component\HttpFoundation\Response;

final class StatusMessage
{
    public const SUCCESS = '0000';
    public const COMMAND_SUCCESS = '0001';
    public const EVENT_SUCCESS = '0002';
    public const JOB_SUCCESS = '0003';
    public const API_ERROR = 'E001';
    public const DATABASE_INSERT_ERROR = 'E002';
    public const PARAMETER_ERROR = 'E003';
    public const ERROR = 'E999';

    private const CODE_LIST = [
        self::SUCCESS => [
            'statusCode'  => self::SUCCESS,
            'description' => 'Success',
            'httpCode'    => Response::HTTP_OK,
        ],
        self::COMMAND_SUCCESS => [
            'statusCode'  => self::COMMAND_SUCCESS,
            'description' => 'command success',
            'httpCode'    => Response::HTTP_OK,
        ],
        self::EVENT_SUCCESS => [
            'statusCode'  => self::EVENT_SUCCESS,
            'description' => 'event success',
            'httpCode'    => Response::HTTP_OK,
        ],
        self::JOB_SUCCESS => [
            'statusCode'  => self::JOB_SUCCESS,
            'description' => 'job success',
            'httpCode'    => Response::HTTP_OK,
        ],
        self::API_ERROR => [
            'statusCode'  => self::API_ERROR,
            'description' => 'api error',
            'httpCode'    => Response::HTTP_INTERNAL_SERVER_ERROR,
        ],
        self::DATABASE_INSERT_ERROR => [
            'statusCode'  => self::DATABASE_INSERT_ERROR,
            'description' => 'database insert error',
            'httpCode'    => Response::HTTP_INTERNAL_SERVER_ERROR,
        ],
        self::PARAMETER_ERROR => [
            'statusCode'  => self::PARAMETER_ERROR,
            'description' => 'parameter error',
            'httpCode'    => Response::HTTP_BAD_REQUEST,
        ],
        self::ERROR => [
            'statusCode'  => self::ERROR,
            'description' => 'error',
            'httpCode'    => Response::HTTP_INTERNAL_SERVER_ERROR,
        ],
    ];

    public static function getDescription(string $statusCode): string
    {
        return self::CODE_LIST[$statusCode]['description'] ?? '';
    }

    public static function getHttpCode(string $statusCode): string
    {
        return self::CODE_LIST[$statusCode]['httpCode'] ?? '';
    }
}
