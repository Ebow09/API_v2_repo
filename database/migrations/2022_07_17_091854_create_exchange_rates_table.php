<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Base currency
            $table->string('from_currency');
            // Destination currency
            $table->string('to_currency');
            // Rate
            $table->decimal('rate');
            // The timestamp when the exchange rate is fetched from the Fixer API
            $table->timestamp('since');
            // The timestamp when a new version of the exchange rate is fetched.
            // The current exchange version will be null as there is not a new ending timestamp.
            $table->timestamp('until')->nullable();
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
        Schema::dropIfExists('exchange_rates');
    }
}
