<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Create the currencies table.
 * @param  bigint  $id
 * @param  str     $name
 * @param  str     $code
 * @param  float   $value
 * @param  date    $created_at
 * @param  date    $updated_at
 */
class Currency extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    /**
     * Method converts amount from one currency to Base Currency
     * @var  float $amount amount to convert
     * @var  int $currency_id currency id to convert from
     * @return float converted amount
     */
    static function convert2BaseCurrency($amount, $from)
    {
        $to = Auth::user()->default_currency_id ?? Currency::where('value', '1')->first()->id;
        return self::convertCurrency($amount, $from, $to);
    }
    /**
     * Method converts amount from one currency to other currency
     * @var  float $amount amount to convert
     * @var  int $currency_id currency id to convert from
     * @var  int $currency_id currency id to convert to
     * @return float converted amount
     */
    static function convertCurrency($amount, $from, $to)
    {
        $from = Currency::find($from);
        $to = Currency::find($to);
        return $amount * $from->value / $to->value;
    }
}
