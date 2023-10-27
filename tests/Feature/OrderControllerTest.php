<?php


use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Enums\OrderStatus;
use App\Notifications\OrderPaid;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_create_order(): void
    {
        $user = User::first();
        $product = Product::first();

        $this->actingAs($user, 'sanctum')
            ->postJson(route('api.order.create.post'), ['product_id' => $product->id])
            ->assertStatus(201);
        $this->assertDatabaseHas('orders', [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'status' => OrderStatus::CREATED
        ]);
    }

    public function test_user_pay_order(): void
    {
        Notification::fake();
        $user = User::first();
        $order = Order::factory()->for($user)->create();

        $this->actingAs($user, 'sanctum')
            ->postJson(route('api.order.pay.post', $order))
            ->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => OrderStatus::PAID
        ]);
        $this->assertDatabaseHas('transactions', [
            'model_type' => get_class($order),
            'model_id' => $order->id,
            'user_id' => $user->id,
        ]);
        Notification::assertSentTo(
            [$user],
            OrderPaid::class
        );
    }

    public function test_exception_thrown_when_paying_for_someone_else_order(): void
    {
        $this->withoutExceptionHandling();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $order = Order::factory()->for($user2)->create();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unauthorized to pay this order.');
        $response = $this->actingAs($user1, 'sanctum')
            ->postJson(route('api.order.pay.post', $order->id));
        $response->assertStatus(500);
    }

    public function test_user_insufficient_balance_exception(): void
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->hasCredit(50_000)->create();
        $product = Product::factory(['price' => 10_000])->create();
        $orderService = app(\App\Services\OrderService::class);
        for ($i = 0; $i < 5; $i++) {
            $order = Order::factory()->for($user)->for($product)->create(['status' => OrderStatus::CREATED]);
            $orderService->payOrder(order: $order);
        }

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Your balance is not enough.');

        $anotherOrder = Order::factory()->for($user)->for($product)->create(['status' => OrderStatus::CREATED]);
        $orderService->payOrder(order: $anotherOrder);
    }

}
