<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Create database table `items`
         *  with column names and column data types
         */
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('barcode');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * Create database table `items_history`
         *  with column names and column data types
         *
         * This will keep track of historical changes from the `items` table
         */
        Schema::create('items_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('_id');
            $table->string('barcode');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /**
         * Remove database tables `items_history`
         */
        Schema::dropIfExists('items_history');

        /**
         * Remove database tables `items`
         */
        Schema::dropIfExists('items');
    }
}
