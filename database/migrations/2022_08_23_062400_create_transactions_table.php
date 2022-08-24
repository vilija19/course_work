<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Created by
     * php artisan make:model -c -m Transaction
     * 
     * @return void
     */
    public function up()
    {
        /**
         * Create the transactions table.
         * @param  bigint  $id
         * @param  bigint  $wallet_id
         * @param  tynyint  $type
         * @param  bigint  $amount
         * @param  string  $description
         * @param  date  $created_at
         * @param  date  $updated_at
         */
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('wallet_id')->unsigned();
            $table->tinyInteger('type');
            $table->bigInteger('amount')->unsigned();
            $table->string('description');
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
        Schema::dropIfExists('transactions');
    }
}
