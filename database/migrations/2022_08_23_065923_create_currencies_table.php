<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Created by 
     * php artisan make:model -m  Currency
     *
     * @return void
     */
    public function up()
    {
        /**
         * Create the currencies table.
         * @param  bigint  $id
         * @param  str     $name
         * @param  str     $code
         * @param  float   $value
         * @param  date    $created_at
         * @param  date    $updated_at
         */
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->unique();
            $table->float('value',6,4);
            $table->timestamps();
        });

        /**
         * Insert the default currencies.
         */
        DB::table('currencies')->insert([
            'name' => 'Euro',
            'code' => 'EUR',
            'value' => 1.1,
        ]);
        DB::table('currencies')->insert([
            'name' => 'Dollar',
            'code' => 'USD',
            'value' => 1,
        ]);
        DB::table('currencies')->insert([
            'name' => 'Pound',
            'code' => 'GBP',
            'value' => 1.3,
        ]);
        DB::table('currencies')->insert([
            'name' => 'Hryvnia',
            'code' => 'UAH',
            'value' => 0.027,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
