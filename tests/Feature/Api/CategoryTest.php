<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_cotegories()
    {
        Category::factory()->count(6)->create();

        $response = $this->getJson('/categories');

        $response->assertJsonCount(6, 'data');
        $response->assertStatus(200);
    }
}
