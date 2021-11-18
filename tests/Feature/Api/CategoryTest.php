<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected $endpoint = "/categories";
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_cotegories()
    {
        Category::factory()->count(6)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertJsonCount(6, 'data');
        $response->assertStatus(200);
    }

    /**
     * Error single category
     *
     * @return void
     */
    public function test_error_get_single_category()
    {
        $fake_url = '/fake-url';
        $response = $this->getJson("{$this->endpoint}{$fake_url}");
        $response->assertStatus(404);
    }

    /**
     * Get single category
     *
     * @return void
     */
    public function test_get_single_category()
    {
        $category = Category::factory()->create();
        $response = $this->getJson("{$this->endpoint}/{$category->url}");
        $response->assertStatus(200);
    }

    /**
     * Validations store category
     *
     * @return void
     */
    public function test_validations_store_category()
    {
        $response = $this->postJson($this->endpoint, [
            "title" => '',
            "description" => ''
        ]);

        $response->assertStatus(422);
    }

    /**
     * Store category
     *
     * @return void
     */
    public function test_store_category()
    {
        $response = $this->postJson($this->endpoint, [
            "title" => 'category test',
            "description" => 'this category to test feature'
        ]);

        $response->assertStatus(201);
    }

    /**
     * Update category
     *
     * @return void
     */
    public function test_update_category()
    {
        $category = Category::factory()->create();
        $data = [
            "title" => "title updated category test",
            "description" => "description updated category test"
        ];

        $response = $this->putJson("{$this->endpoint}/fake-url", $data);
        $response->assertStatus(404);

        $response = $this->putJson("{$this->endpoint}/{$category->url}", []);
        $response->assertStatus(422);

        $response = $this->putJson("{$this->endpoint}/{$category->url}", $data);
        $response->assertStatus(200);
    }

    /**
     * Delete category
     *
     * @return void
     */
    public function test_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/fake-url");
        $response->assertStatus(404);

        $response = $this->deleteJson("{$this->endpoint}/{$category->url}");
        $response->assertStatus(204);
    }
}
