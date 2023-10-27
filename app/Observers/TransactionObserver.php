<?php

namespace App\Observers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Cache;

class TransactionObserver
{
    public function created(Transaction $transaction): void
    {
        Cache::forget("user_{$transaction->user_id}_balance");
    }

}
