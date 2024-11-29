<?php

namespace Tests\Feature\Http\Controllers\Api\v1;

use App\Events\DataGot;
use App\Jobs\CreateData;
use App\Listeners\InsertData;
use Event;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Redis;
use Queue;
use Tests\TestCase;

class DataControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCommandApiRequestSuccessfully()
    {
        // Act
        // Assert
        Redis::shouldReceive('connection')->andReturnSelf();
        Redis::shouldReceive('set')->once();
        $this->postJson('api/v1/command/data', [
            'count' => 1,
            'uuid' => 'asdf',
        ])->assertExactJson([
            "metadata" => [
                "status" => "0001",
                "description" => "[command] 資料產生中，將產生1筆"
            ]
        ])->assertOK();
    }

    public function testCommandApiRequestNoParameter()
    {
        // Act
        // Assert
        $this->postJson('api/v1/command/data', [
            'uuid' => 'asdf',
        ])->assertExactJson([
            "metadata" => [
                "status" => "E999",
                "description" => "The given data was invalid."
            ]
        ])->assertStatus(500);
    }

    public function testCommandApiRequestInvalidParameter()
    {
        // Act
        // Assert
        $this->postJson('api/v1/command/data', [
            'count' => 'test',
            'uuid' => 'asdf',
        ])->assertExactJson([
            "metadata" => [
                "status" => "E999",
                "description" => "The given data was invalid."
            ]
        ])->assertStatus(500);
    }

    public function testEventApiRequestSuccessfully()
    {
        // Act
        // Assert
        $this->postJson('api/v1/event/data', [
            'count' => 3,
            'uuid' => 'asdf',
        ])->assertExactJson([
            "metadata" => [
                "status" => "0002",
                "description" => "[event] 資料產生中，將產生3筆"
            ]
        ])->assertOK();
        $this->assertDatabaseCount('data', 3);
    }

    public function testEventApiRequestTriggerEventSuccessfully()
    {
        // Arrange
        Event::fake();

        // Act
        // Assert
        $this->postJson('api/v1/event/data', [
            'count' => 1,
            'uuid' => 'asdf',
        ])->assertExactJson([
            "metadata" => [
                "status" => "0002",
                "description" => "[event] 資料產生中，將產生1筆"
            ]
        ])->assertOK();
        Event::assertDispatched(DataGot::class);
        Event::assertListening(DataGot::class, InsertData::class);
    }
    public function testEventApiRequestPutQueueSuccessfully()
    {
        // Arrange
        Queue::fake();
        // Act
        // Assert
        $this->postJson('api/v1/event/data', [
            'count' => 1,
            'uuid' => 'asdf',
        ])->assertExactJson([
            "metadata" => [
                "status" => "0002",
                "description" => "[event] 資料產生中，將產生1筆"
            ]
        ])->assertOK();
        Queue::assertPushed(CallQueuedListener::class, function ($job) {
            return $job->class === InsertData::class;
        });
    }

    public function testEventApiRequestNoParameter()
    {
        // Arrange
        Event::fake();

        // Act
        // Assert
        $this->postJson('api/v1/event/data', [
            'uuid' => 'asdf',
        ])->assertExactJson([
            "metadata" => [
                "status" => "E999",
                "description" => "The given data was invalid."
            ]
        ])->assertStatus(500);
        Event::assertNotDispatched(DataGot::class);
    }

    public function testEventApiRequestInvalidParameter()
    {
        // Arrange
        Event::fake();

        // Act
        // Assert
        $this->postJson('api/v1/event/data', [
            'count' => 'test',
            'uuid' => 'asdf',
        ])->assertExactJson([
            "metadata" => [
                "status" => "E999",
                "description" => "The given data was invalid."
            ]
        ])->assertStatus(500);
        Event::assertNotDispatched(DataGot::class);
    }

    public function testJobApiRequestSuccessfully()
    {
        // Act
        // Assert
        $this->postJson('api/v1/job/data', [
            'count' => 5,
            'uuid' => 'asdf',
        ])->assertExactJson([
            "metadata" => [
                "status" => "0003",
                "description" => "[job] 資料產生中，將產生5筆"
            ]
        ])->assertOK();
        $this->assertDatabaseCount('data', 5);
    }

    public function testJobApiRequestPutQueueSuccessfully()
    {
        // Arrange
        Bus::fake();

        // Act
        // Assert
        $this->postJson('api/v1/job/data', [
            'count' => 5,
            'uuid' => 'asdf',
        ])->assertExactJson([
            "metadata" => [
                "status" => "0003",
                "description" => "[job] 資料產生中，將產生5筆"
            ]
        ])->assertOK();
        Bus::assertDispatched(CreateData::class);
    }

    public function testJobApiRequestNoParameter()
    {
        // Arrange
        Bus::fake();

        // Act
        // Assert
        $this->postJson('api/v1/job/data', [
            'uuid' => 'asdf',
        ])->assertExactJson([
            "metadata" => [
                "status" => "E999",
                "description" => "The given data was invalid."
            ]
        ])->assertStatus(500);
        Bus::assertNotDispatched(CreateData::class);
    }

    public function testJobApiRequestInvalidParameter()
    {
        // Arrange
        Bus::fake();

        // Act
        // Assert
        $this->postJson('api/v1/job/data', [
            'count' => 'test',
            'uuid' => 'asdf',
        ])->assertExactJson([
            "metadata" => [
                "status" => "E999",
                "description" => "The given data was invalid."
            ]
        ])->assertStatus(500);
        Bus::assertNotDispatched(CreateData::class);
    }
}
