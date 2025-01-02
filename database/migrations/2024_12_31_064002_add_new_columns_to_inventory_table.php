<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->text('asset_description')->nullable();
            $table->integer('stock_in_quantity')->nullable();
            $table->date('stock_in_date')->nullable();
            $table->integer('stock_out_quantity')->nullable();
            $table->date('stock_out_date')->nullable();
            $table->integer('balance_quantity')->nullable();
            $table->string('used_in')->nullable();
            $table->string('used_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn([
                'asset_description',
                'stock_in_quantity',
                'stock_in_date',
                'stock_out_quantity',
                'stock_out_date',
                'balance_quantity',
                'used_in',
                'used_by'
            ]);
        });
    }
}
