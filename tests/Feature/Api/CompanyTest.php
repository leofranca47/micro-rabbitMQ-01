<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    protected $endpoint = "/companies";

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_companies()
    {
        Company::factory()->count(6)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertJsonCount(6, 'data');
        $response->assertStatus(200);
    }

    /**
     * Error single company
     *
     * @return void
     */
    public function test_error_get_single_company()
    {
        $fake_uuid = '/fake-uuid';
        $response = $this->getJson("{$this->endpoint}{$fake_uuid}");
        $response->assertStatus(404);
    }

    /**
     * Get single company
     *
     * @return void
     */
    public function test_get_single_company()
    {
        $category = Company::factory()->create();
        $response = $this->getJson("{$this->endpoint}/{$category->uuid}");
        $response->assertStatus(200);
    }

    /**
     * Validations store company
     *
     * @return void
     */
    public function test_validations_store_company()
    {
        $response = $this->postJson($this->endpoint, [
            "category_id" => '',
            "name" => '',
            "email" => '',
            "whatsapp" => ''
        ]);

        $response->assertStatus(422);
    }

    /**
     * Store company
     *
     * @return void
     */
    public function test_store_company()
    {
        $category = Category::factory()->create();
        $response = $this->postJson($this->endpoint, [
            "category_id" => $category->id,
            "name" => 'Empresa teste feature',
            "email" => 'teste@feture.com',
            "whatsapp" => '38988075954'
        ]);

        $response->assertStatus(201);
    }

    /**
     * Update company
     *
     * @return void
     */
    public function test_update_company()
    {
        $category = Category::factory()->create();
        $company = Company::factory()->create();
        $data = [
            "category_id" => $category->id,
            "name" => 'Empresa teste feature update',
            "email" => 'teste@fetureupdate.com',
            "whatsapp" => '38988075951'
        ];

        $response = $this->putJson("{$this->endpoint}/fake-uuid", $data);
        $response->assertStatus(404);

        $response = $this->putJson("{$this->endpoint}/{$company->uuid}", []);
        $response->assertStatus(422);

        $response = $this->putJson("{$this->endpoint}/{$company->uuid}", $data);
        $response->assertStatus(200);
    }

    /**
     * Delete category
     *
     * @return void
     */
    public function test_delete_category()
    {
        $company = Company::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/fake-uuid");
        $response->assertStatus(404);

        $response = $this->deleteJson("{$this->endpoint}/{$company->uuid}");
        $response->assertStatus(204);
    }
}
