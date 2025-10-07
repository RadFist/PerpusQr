<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(2),
            'penulis' => fake()->name(10),
            'penerbit' => fake()->name(10),
            'tahun_terbit' => fake()->year(),
            'cover_image' => fake()->imageUrl(640, 640),
            'stok' => fake()->randomNumber(2)
        ];
    }
}
