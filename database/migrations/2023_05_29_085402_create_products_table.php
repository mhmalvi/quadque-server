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
            $table->text('product_name')->nullable();
            $table->string('product_logo')->nullable();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();

            $table->text('problem_solution_title')->nullable();
            $table->text('problem_solution_description')->nullable();
            $table->text('solved_problems')->nullable();
            $table->text('total_users')->nullable();

            $table->longText('using_purpose')->nullable();

            $table->text('key_points_header')->nullable();
            $table->text('key_points_description')->nullable();

            
            $table->text('technologies_used')->nullable();
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
