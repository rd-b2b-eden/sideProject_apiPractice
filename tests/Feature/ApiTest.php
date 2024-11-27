<?php

namespace Tests\Feature;

use App\Events\DataGot;
use App\Jobs\CreateData;
use Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_api_request_successfully()
    {
        // Arrange
        $redisSpy = Redis::spy();

        // Act
        // Assert
        $redisSpy->shouldReceive('connection')->andReturnSelf();
        $this->postJson('api/v1/command/data', [
            'count' => 1,
            'uuid' => 'asdf',
        ])->assertExactJson([
            "metadata" => [
                "status" => "0001",
                "description" => "[command] 資料產生中，將產生1筆"
            ]
        ])->assertStatus(200);
        $redisSpy->shouldHaveReceived('set')->once();
    }

    public function test_command_api_request_no_parameter()
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

    public function test_command_api_request_invalid_parameter()
    {
        // Act
        // Assert
        $this->withExceptionHandling()->postJson('api/v1/command/data', [
            'count' => 'test',
            'uuid' => 'asdf',
        ])->assertExactJson([
            "metadata" => [
                "status" => "E999",
                "description" => "The given data was invalid."
            ]
        ])->assertStatus(500);
    }

    public function test_event_api_request_successfully()
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
        ])->assertStatus(200);
        Event::assertDispatched(DataGot::class);
    }

    public function test_event_api_request_no_parameter()
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

    public function test_event_api_request_invalid_parameter()
    {
        // Arrange
        Event::fake();

        // Act
        // Assert
        $this->withExceptionHandling()->postJson('api/v1/event/data', [
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

    public function test_job_api_request_successfully()
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
        ])->assertStatus(200);
        Bus::assertDispatched(CreateData::class);
    }

    public function test_job_api_request_no_parameter()
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

    public function test_job_api_request_invalid_parameter()
    {
        // Arrange
        Bus::fake();

        // Act
        // Assert
        $this->withExceptionHandling()->postJson('api/v1/job/data', [
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
