<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Products;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Products::create([
            "code" => random_int(1,9999999999),
            "status" => "published",
            "imported_t" => "2020-02-07T16:00:00Z",
            "url" => "https://world.openfoodfacts.org/product/20221126",
            "creator" => "securita",
            "created_t" => strtotime('now'),
            "last_modified_t" => strtotime('now'),
            "product_name" => "Madalenas quadradas",
            "quantity" => "380 g (6 x 2 u.)",
            "brands" => "La Cestera",
            "categories" => "Lanches comida, Lanches doces, Biscoitos e Bolos, Bolos, Madalenas",
            "labels" => "Contem gluten, Contém derivados de ovos, Contém ovos",
            "cities" => "",
            "purchase_places" => "Braga,Portugal",
            "stores" => "Lidl",
            "ingredients_text" => "farinha de trigo, açúcar, óleo vegetal de girassol, clara de ovo, ovo, humidificante (sorbitol), levedantes químicos (difosfato dissódico, hidrogenocarbonato de sódio), xarope de glucose-frutose, sal, aroma",
            "traces" => "Frutos de casca rija,Leite,Soja,Sementes de sésamo,Produtos à base de sementes de sésamo",
            "serving_size" => "madalena 31.7 g",
            "serving_quantity" => 31.7,
            "nutriscore_score" => 17,
            "nutriscore_grade" => "d",
            "main_category" => "en:madeleines",
            "image_url" => "https://static.openfoodfacts.org/images/products/20221126/front_pt.5.400.jpg"
        ]);
    }
}
