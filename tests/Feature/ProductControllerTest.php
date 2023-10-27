<?php


use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_get_all_products(): void
    {
         $this->getJson(route('api.product.index.get'))->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }
}
