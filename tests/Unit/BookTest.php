<?php

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class Booktest extends TestCase
{
    use RefreshDatabase;

    public function test_insert_books()
    {

        $book = new Book([
            'judul' => "udin udin",
            'penulis' => "nurdin",
            'penerbit' => "pt budiono",
            'tahun_terbit' => now(),
            'cover_image' => "",
            'stok' => 3,
        ]);


        expect($book->judul)->toBe('udin udin');
        expect($book->penulis)->toBe('nurdin');
        expect($book->stok)->toBe(3);
    }

    public function test_books_index_view_displays_books()
    {

        $mockUser = new User([
            'id' => 1,
            'name' => 'Fake User',
            'email' => 'fake@example.com',
            'role' => 'admin',
        ]);

        $this->actingAs($mockUser);

        Book::factory()->create([
            'judul' => 'Udin Udin',
            'penulis' => 'Nurdin',
        ]);

        $response = $this->get('/books');


        $response->assertStatus(200);                        // halaman sukses
        $response->assertViewIs('page.books.index');         // view benar
        $response->assertViewHas('books');                   // variabel dikirim
        $response->assertSee('Nurdin');                   // teks tampil
    }
}
