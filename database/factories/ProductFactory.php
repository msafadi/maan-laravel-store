<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->words(5, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentences(2, true),
            'image' => $this->faker->imageUrl,
            'price' => $this->faker->randomFloat(2, 0, 500),
            'sale_price' => $this->faker->randomFloat(2, 0, 500),
            'quantity' => $this->faker->randomNumber(3),
            'sku' => Str::slug($name),
        ];
    }
}
