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
        return [
            'name' => $this->faker->text(20),
            'slug' => uniqid(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(20, 500),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(Product $product) {
            $product->update([
                'slug' => Str::slug($product->name . uniqid())
            ]);
        });
    }
}
