<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInventoryIdToTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('inventory_id')->nullable()->change(); 
            // $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            // $table->dropForeign(['inventory_id']);
            $table->dropColumn('inventory_id');
        });
    }
}
