<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BorrowingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggalPinjam = $this->faker->dateTimeBetween('-2 months', 'now');
        $isReturned = $this->faker->boolean(50);

        return [
            'member_id' => Member::inRandomOrder()->value('id'),
            'book_id' => Book::inRandomOrder()->value('id'),
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => $isReturned ? $this->faker->dateTimeBetween($tanggalPinjam, 'now') : null,
            'status' => $isReturned ? 'dikembalikan' : 'dipinjam',
        ];
    }
}
