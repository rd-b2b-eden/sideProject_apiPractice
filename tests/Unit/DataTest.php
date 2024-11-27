<?php

namespace Tests\Unit;

use App\Models\Data;
use App\Service\DataService;
use Illuminate\Database\Eloquent\Collection;
use Mockery\MockInterface;
use Tests\TestCase;

class DataTest extends TestCase
{
    private MockInterface $dataServiceMock;

    private object $dataService;

    public function setUp(): void
    {
        parent::setUp();
        $this->dataServiceMock = $this->mock(DataService::class);
        $this->dataService = $this->instance(DataService::class, $this->dataServiceMock);
    }

    public function testDatabaseInsertSuccessfully()
    {
        // Act
        $data = Data::factory()->count(3)->make();

        // Assert
        $this->assertInstanceOf(Collection::class, $data);
        $this->assertEquals(3, $data->count());
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