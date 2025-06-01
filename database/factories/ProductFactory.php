<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Product;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'name' => fake()->word(),
            // 'description' => fake()->sentence(),
            // 'price' => fake()->randomFloat(2, 5, 500),
            // 'stock' => fake()->numberBetween(1, 100),
            // 'image' => 'default.jpg', // Or generate fake image path
            // 'user_id' => User::where('user_type', 'admin')->first()->id ?? 1, // link to admin
        ];
    }
}