<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigInteger("code");
            $table->enum('status', ["draft", "published", "trash"]);
            $table->timestamp('imported_t')->useCurrent();
            $table->string("url");
            $table->string("creator");
            $table->bigInteger("created_t");
            $table->bigInteger("last_modified_t");
            $table->string("product_name");
            $table->string("quantity");
            $table->string("brands");
            $table->string("categories");
            $table->string("labels");
            $table->string("cities");
            $table->string("purchase_places");
            $table->string("ingredients_text");
            $table->string("traces");
            $table->string("serving_size");
            $table->float("serving_quantity");
            $table->integer("nutriscore_score");
            $table->string("nutriscore_grade");
            $table->string("main_category");
            $table->string("image_url");

            $table->primary("code");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
