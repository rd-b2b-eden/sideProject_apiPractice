<?php

namespace App\Common;

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
}
