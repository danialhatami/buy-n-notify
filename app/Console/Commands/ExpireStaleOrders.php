<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Enums\OrderStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireStaleOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:expire-stale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire orders that have not been paid within the last 10 minutes and restock the products';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            $expiredOrders = Order::where('status', OrderStatus::CREATED)
                ->where('updated_at', '<', Carbon::now()->subMinutes(10))
                ->lockForUpdate()
                ->get();
            foreach ($expiredOrders as $order) {
                $order->status = OrderStatus::EXPIRED;
                $order->save();
                Product::whereId($order->product_id)->lockForUpdate()->increment('quantity');
            }
        }, 3);
    }
}
