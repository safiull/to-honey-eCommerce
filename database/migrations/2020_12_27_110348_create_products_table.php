<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('supplier_name');
            $table->integer('alert_stock')->nullable();
            $table->float('price');
            $table->string('brand')->nullable();
            $table->integer('category_id');
            $table->longText('slug')->nullable(false);
            $table->longText('long_description')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('product_photo')->default('default_product_image.png');
            $table->timestamps();
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
}
