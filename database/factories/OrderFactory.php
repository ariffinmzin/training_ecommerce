<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $int = mt_rand(1673313988, 1702171588);

        return [
            'user_id' => mt_rand(1,12),
            'product_id' => mt_rand(3,5),
            'quantity' => mt_rand(1,20),
            'total' => mt_rand(0,100),
            'status' => mt_rand(0,2),
            'proof' => $this->faker->imageUrl(640,480),
            'note' => $this->faker->sentence(), //Str::random(40),
            'created_at' => date("Y-m-d H:i:s", $int),
        ];
    }
}
