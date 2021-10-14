<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->char('currency', 3)->default('nzd');
            $table->decimal('amount', 19, 4);
            $table->timestamps();
        });

        Schema::create('prices_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('_id');
            $table->unsignedBigInteger('item_id');
            $table->char('currency', 3)->default('nzd');
            $table->decimal('amount', 19, 4);
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
        Schema::dropIfExists('prices_history');
        Schema::dropIfExists('prices');
    }
}
