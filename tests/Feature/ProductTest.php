<?php

namespace Tests\Feature;

use App\Models\Products;
use Tests\TestCase;

class ProductTest extends TestCase
{

    public function test_list_products()
    {
        $product_count = Products::count();
        $response = $this->get('/products?' . http_build_query(['per_page' => 1]));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'data' => [[
                    "code",
                    "status",
                    "imported_t",
                    "url",
                    "creator",
                    "created_t",
                    "last_modified_t",
                    "product_name",
                    "quantity",
                    "brands",
                    "categories",
                    "labels",
                    "cities",
                    "purchase_places",
                    "stores",
                    "ingredients_text",
                    "traces",
                    "serving_size",
                    "serving_quantity",
                    "nutriscore_score",
                    "nutriscore_grade",
                    "main_category",
                    "image_url",
                ]]
            ])->assertJsonFragment(['total' => $product_count, 'per_page' => 1]);
    }

    public function test_get_product()
    {
        $product = Products::first();
        $response = $this->get("/products/{$product['code']}");
        $response->assertStatus(200)
            ->assertJsonStructure([
                "code",
                "status",
                "imported_t",
                "url",
                "creator",
                "created_t",
                "last_modified_t",
                "product_name",
                "quantity",
                "brands",
                "categories",
                "labels",
                "cities",
                "purchase_places",
                "stores",
                "ingredients_text",
                "traces",
                "serving_size",
                "serving_quantity",
                "nutriscore_score",
                "nutriscore_grade",
                "main_category",
                "image_url",
            ])->assertJsonCount(23)->assertJsonFragment(['code' => $product['code']]);
    }

    public function test_edit_product()
    {
        $product = Products::first();
        $name = fake()->name();
        $response = $this->put("/products/{$product['code']}", ['product_name' => $name]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'product' => [
                    "code",
                    "status",
                    "imported_t",
                    "url",
                    "creator",
                    "created_t",
                    "last_modified_t",
                    "product_name",
                    "quantity",
                    "brands",
                    "categories",
                    "labels",
                    "cities",
                    "purchase_places",
                    "stores",
                    "ingredients_text",
                    "traces",
                    "serving_size",
                    "serving_quantity",
                    "nutriscore_score",
                    "nutriscore_grade",
                    "main_category",
                    "image_url",
                ]
            ])->assertJsonPath('message', 'product updated')
            ->assertJsonPath('product.code', $product['code'])
            ->assertJsonPath('product.product_name',  $name);
    }
}
