<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class Product extends Controller
{
    public function list_products(Request $request)
    {
        $validate = $this->validate($request, [
            'page' => 'integer',
            'per_page' => 'integer'
        ]);

        $products = Products::paginate(page: $validate['page'] ?? 1, perPage: $validate['per_page'] ?? 10,);

        return response()->json($products);
    }


    public function get_product(mixed $code)
    {
        $product = Products::where('code', '=', intval($code))->first();

        return response()->json($product, $product !== null ? 200 : 404);
    }

    public function update_product(Request $request, mixed $code)
    {
        $values = $this->validate($request, [
            'status' => 'in:draft,published,trash',
            'url' => 'url',
            'product_name' => 'string',
            'quantity' => 'string',
            'brands' => 'string',
            'categories' => 'string',
            'labels' => 'string',
            'cities' => 'string',
            'purchase_places' => 'string',
            'ingredients_text' => 'string',
            'traces' => 'string',
            'serving_size' => 'string',
            'serving_quantity' => 'numeric|min:0',
            'nutriscore_score' => 'numeric|min:0',
            'nutriscore_grade' => 'string',
            'main_category' => 'string',
            'image_url' => 'url'
        ]);

        $product = Products::where('code', '=', intval($code))->first();

        if ($product !== null) {
            $values["last_modified_t"] = strtotime('now');
            $product->update($values);
            return response()->json(['message' => 'product updated', 'product' => Products::where('code', '=', intval($code))->first()]);
        } else {
            return response()->json(['message' => 'product not found'], 404);
        }
    }

    public function delete_product(mixed $code)
    {
        $product = Products::where('code', '=', intval($code))->first();

        if ($product !== null) {
            $product->update(['status' => "trash"]);
            return response()->json(['message' => 'product deleted', 'product' => Products::where('code', '=', intval($code))->first()]);
        } else {
            return response()->json(['message' => 'product not found'], 404);
        }
    }
}
