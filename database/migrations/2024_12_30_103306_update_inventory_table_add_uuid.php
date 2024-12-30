<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class UpdateInventoryTableAddUuid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            // Ensure the id column exists before dropping it
            $table->dropForeign(['brand']); // Drop the foreign key first
            $table->dropColumn('id'); // Drop the old id column

            // Add the new UUID column
            $table->string('id', 50)->primary()->default(Str::uuid());
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
            // Drop the custom UUID id column
            $table->dropColumn('id');

            // Re-add the auto-incrementing id column
            $table->id(); 

            // Add foreign key back to the original id
            $table->foreign('brand')->references('id')->on('brands')->onDelete('cascade');
        });
    }
}
