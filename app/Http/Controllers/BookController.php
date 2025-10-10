<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use PhpParser\Node\Stmt\Echo_;

class BookController extends Controller
{

    public function index()
    {
        return view('books', [
            'title' => 'Daftar Buku',
            'books' => Book::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        echo "create book";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {

        return view(
            'detailBook',
            [
                'judul' => $book->judul,
                'penulis' => $book->penulis,
                'penerbit' => $book->penerbit,
                'tahun_terbit' => $book->tahun_terbit,
                'stok' => $book->stok,
                'cover_image' => $book->cover_image,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return [
            'judul' => $book->judul,
            'pengarang' => $book->pengarang,
            'penerbit' => $book->penerbit,
            'tahun_terbit' => $book->tahun_terbit,
            'stok' => $book->stok,
            'cover_image' => $book->cover_image,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        try {
            // Cek dulu apakah data buku benar-benar ada
            if (!$book) {
                return redirect('/books')->with('error', 'Buku tidak ditemukan!');
            }

            // Hapus buku
            $book->delete();

            // Berhasil dihapus
            return redirect('/books')->with('success', 'Buku berhasil dihapus!');
        } catch (\Exception $e) {
            // Kalau terjadi error (misal gagal konek DB, foreign key constraint, dll)
            return redirect('/books')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
