<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Http\Resources\PaidOrderResource;
use App\Http\Resources\CreatedOrderResource;
use App\Http\Requests\PurchaseProductRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService   $orderService,
        private readonly ProductService $productService
    )
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $user = $request->user();
        $order = $this->orderService->getOrders(user: $user);
        return CreatedOrderResource::collection($order);
    }

    public function create(PurchaseProductRequest $request): CreatedOrderResource
    {
        $user = $request->user();
        $product = $this->productService->getProduct($request->input('product_id'));
        $order = $this->orderService->createOrder(user: $user, product: $product);
        return CreatedOrderResource::make($order);
    }

    /**
     * @throws \Exception
     */
    public function payOrder(Order $order, Request $request): PaidOrderResource
    {
        if ($request->user()->id !== $order->user_id) {
            throw new \Exception('Unauthorized to pay this order.');
        }
        $this->orderService->payOrder(order: $order);
        return PaidOrderResource::make($order);
    }
}
