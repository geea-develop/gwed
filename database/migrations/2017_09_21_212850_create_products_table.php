<?php

use Illuminate\Support\Facades\Schema;
use Moloquent\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('products', function (Blueprint $collection) {

            $collection->string('uname')->index();
            
            $collection->string('title');
            
            $collection->string('description');

            $collection->float('price')->index();
            
            $collection->string('permalink')->index();
            
            $collection->string('userId')->index();
            
            $collection->string('imagePath');

            $collection->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
