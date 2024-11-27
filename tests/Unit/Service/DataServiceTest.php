<?php

namespace Tests\Unit\Service;

use App\Service\DataService;
use Mockery\MockInterface;
use Tests\TestCase;

class DataServiceTest extends TestCase
{
    private MockInterface $dataServiceMock;

    private object $dataService;

    public function setUp(): void
    {
        parent::setUp();
        $this->dataServiceMock = $this->mock(DataService::class);
        $this->dataService = $this->instance(DataService::class, $this->dataServiceMock);
    }

    public function testDataServiceCreateDataSuccessfully()
    {
        // Act
        // Assert
        $this->dataServiceMock->shouldReceive('createData')
            ->once()
            ->with(3)
            ->andReturnNull();
        $this->dataService->createData(3);
    }

    public function testDataServiceCreateQueueSuccessfully()
    {
        // Act
        // Assert
        $this->dataServiceMock->shouldReceive('createQueue')
            ->once()
            ->with(3)->andReturn([
                [
                    'status' => '0001',
                    'description' => '[command] 資料產生中，將產生3筆',
                ]
            ]);
        $this->dataService->createQueue(3);
    }
}
