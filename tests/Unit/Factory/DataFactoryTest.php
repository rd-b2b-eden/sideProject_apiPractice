<?php

namespace Tests\Unit\Factory;

use App\Models\Data;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class DataFactoryTest extends TestCase
{
    public function testDatabaseInsertSuccessfully()
    {
        // Act
        $data = Data::factory()->count(3)->make();

        // Assert
        $this->assertInstanceOf(Collection::class, $data);
        $this->assertEquals(3, $data->count());
    }
}
