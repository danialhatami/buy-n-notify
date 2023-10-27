<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionService
{

    public function getTransactions(User $user): Collection
    {
        return Transaction::query()
            ->where('user_id', $user->id)
            ->get();
    }
    public function increase(User $user, int $amount): void
    {
        $transaction = new Transaction([
            'amount' => $amount,
            'user_id' => $user->id,
            'model_id' => $user->id,
            'model_type' => User::class
        ]);
        $transaction->save();
    }

    public function decrease(User $user, int $amount, object $model): void
    {
        $transaction = new Transaction([
            'amount' => -1 * $amount,
            'user_id' => $user->id,
            'model_type' => get_class($model),
            'model_id' => $model->id,
        ]);
        $transaction->save();
    }


}
