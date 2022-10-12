<?php

namespace Database\Factories;

use App\Models\Link;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        $quantity = $this->faker->numberBetween(1, 5);
        $admin_revenue = 0.9 * $product->price * $quantity;
        $ambassador_revenue = 0.1 * $product->price * $quantity;

        return [
            'order_id' => Order::inRandomOrder()->first(),
            'product_title' => $product->title,
            'price' => $product->price,
            'quantity' => $quantity,
            'admin_revenue' => $admin_revenue,
            'ambassador_revenue' => $ambassador_revenue
        ];
    }
}
