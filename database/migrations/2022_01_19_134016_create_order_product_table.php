<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('order_id')
                ->constrained()
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table
                ->foreignId('product_id')
                ->constrained()
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->integer('quantity');
            $table->float('price');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE orders AUTO_INCREMENT = 10000");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product');
    }
}