<?php

namespace Tests\Unit\Service;

use App\Service\DataService;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class DataServiceTest extends TestCase
{
    private DataService $dataService;

    public function setUp(): void
    {
        parent::setUp();
        $this->dataService = app(DataService::class);
    }

    public function testDataServiceCreateQueueSuccessfully()
    {
        // Act
        // Assert
        Redis::shouldReceive('connection')->andReturnSelf();
        Redis::shouldReceive('set')->once();
        $this->dataService->createQueue(3);
    }
}
