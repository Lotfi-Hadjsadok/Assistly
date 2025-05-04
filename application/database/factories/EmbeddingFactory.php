<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Embedding;

class EmbeddingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Embedding::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'content' => fake()->paragraphs(3, true),
            'source' => fake()->word(),
            'embedding' => fake()->word(),
            'metadata' => '{}',
        ];
    }
}
