<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @param  bigint  $id
 * @param  bigint  $wallet_id
 * @param  tynyint  $type
 * @param  bigint  $amount
 * @param  string  $description
 * @param  date  $created_at
 * @param  date  $updated_at
 */
class Transaction extends Model
{
    use HasFactory;

    /**
     * Accesor for the valid attribute.
     * Get validity status.
     *
     * @param  string  $value
     * @return void
     */
    public function getTypeAttribute($value)
    {
        if ($value == 0) {
            return config('app.transaction_types')[0];
        }
        return config('app.transaction_types')[1];
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
