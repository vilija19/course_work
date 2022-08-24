<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Created by
     * php artisan make:model -c -m  Wallet
     *
     * @return void
     */
    public function up()
    {
        /**
         * Create the wallets table.
         * @param  bigint  $id
         * @param  bigint  $user_id
         * @param  str     $name
         * @param  int  $currency_id
         * @param  float  $balance
         * @param  date  $created_at
         * @param  date  $updated_at
         */
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('name');
            $table->integer('currency_id')->unsigned();
            $table->float('balance')->default(0);
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
        Schema::dropIfExists('wallets');
    }
}
