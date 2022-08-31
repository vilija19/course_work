<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @param  bigint  $id
 * @param  bigint  $user_id
 * @param  str     $name
 * @param  int  $currency_id
 * @param  float  $balance
 * @param  date  $created_at
 * @param  date  $updated_at
 */
class Wallet extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class , 'currency_id');
    }

    public function getBalance()
    {
        $balance = 0;
        $transactions = $this->transactions;
        if (!$transactions) {
            return $balance;
        }

        foreach ($transactions as $transaction) {
            if ($transaction->type == config('app.transaction_types')[0]) {
                //Withdraw
                $balance -= $transaction->amount;
            }
            if ($transaction->type == config('app.transaction_types')[1]) {
                //Deposit
                $balance += $transaction->amount;
            }
        }
        return $balance;
    }
    
    static function getTotalBalance(User $user)
    {
        $totalAmount = 0;
        foreach ($user->wallets as $wallet) {
            $totalAmount += Currency::convert2BaseCurrency($wallet->getBalance(), $wallet->currency_id);
        }
        return $totalAmount;
    }    
}
