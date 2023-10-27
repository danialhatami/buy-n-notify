<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Enums\OrderStatus;
use App\Notifications\OrderPaid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function __construct(private readonly TransactionService $transactionService)
    {
    }

    public function createOrder(User $user, Product $product): Order
    {
        return DB::transaction(function () use ($user, $product) {
            Product::whereId($product->id)->lockForUpdate()->decrement('quantity');
            return Order::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
            ]);
        }, 3);
    }

    public function getOrders(User $user): Collection
    {
        return Order::whereUserId($user->id)->get();
    }

    public function payOrder(Order $order): void
    {
        if ($order->status !== OrderStatus::CREATED) {
            throw new \Exception();
        }
        $user = $order->user;
        $product = $order->product;
        if ($user->getBalance() < $product->price) {
            throw new \Exception('Your balance is not enough.');
        }
        $this->transactionService->decrease(user: $user, amount: $product->price, model: $order);
        $order->update(['status' => OrderStatus::PAID]);
        $user->notify(new OrderPaid(orderId: $order->id));
    }
}
