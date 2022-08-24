<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            return 'Debit';
        }
        return 'Credit';
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
