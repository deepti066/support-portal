<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->integer('stock_type')->nullable();
            $table->integer('stock_quantity')->nullable();
            $table->date('stock_date')->nullable();
            $table->string('used_in')->nullable();
            $table->string('used_by')->nullable();
            $table->unsignedBigInteger('inventory_id');

            $table->foreign('inventory_id', 'inventory_id_fk_583549')->references('id')->on('inventories')->onDelete('cascade');
            
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
        Schema::dropIfExists('inventory_stocks');
    }
}
