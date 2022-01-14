<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('price_id');
            $table->string('SKU')->unique();
            $table->double('itemBQuantity')->default(0);
            $table->double('itemSQuantity')->default(0);
            $table->double('counter')->default(0);
            $table->double('itemBPrice')->default(0);
            $table->double('itemTBPrice')->default(0);
            $table->double('itemTSBPrice')->default(0);
            $table->double('itemRevenue')->default(0);
            $table->boolean('past')->default(false);
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
        Schema::dropIfExists('stocks');
    }
}
