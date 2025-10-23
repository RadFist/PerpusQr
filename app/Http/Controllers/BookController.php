<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use PhpParser\Node\Stmt\Echo_;

class BookController extends Controller
{

    public function index()
    {
        return view('page.books.index', [
            'title' => 'Daftar Buku',
            'books' => Book::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page.books.form', [
            'title' => 'Tambah Buku',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1901|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            try {

                $path = $request->file('cover_image')->store('img/covers', 'public');
                $filename = basename($path);
                $validated['cover_image'] = $filename;
                Book::create($validated);
                $request->file('cover_image')->move(public_path('img/covers'), $path);
                Loging::addBook($validated['judul'], 'ditambahkan');
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal mengunggah buku: ' . $e->getMessage());
            }
        }

        return redirect('/books')->with('success', 'Buku berhasil ditambahkan!');
    }



    public function show(Book $book)
    {

        return view(
            'page.books.detail',
            [
                'id' => $book->id,
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

        return view(
            'page.books.form',
            [
                'title' => 'Edit Buku',
                'books' => $book
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        // Validasi input
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1901|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cek apakah buku ada
        if (!$book) {
            return redirect('/books')->with('error', 'Buku tidak ditemukan!');
        }

        try {
            // Jika ada file cover baru
            if ($request->hasFile('cover_image')) {
                // Hapus cover lama kalau ada
                if ($book->cover_image && file_exists(public_path('img/covers/' . $book->cover_image))) {
                    unlink(public_path('img/covers/' . $book->cover_image));
                }

                // Simpan cover baru
                $path = $request->file('cover_image')->store('img/covers', 'public');
                $filename = basename($path);
                $request->file('cover_image')->move(public_path('img/covers'), $path);
                $validated['cover_image'] = $filename;
                Loging::addBook($validated['judul'], 'diedit');
            } else {
                // Kalau tidak upload cover baru, pakai yang lama
                $validated['cover_image'] = $book->cover_image;
            }

            // Update data buku
            $book->update($validated);

            return redirect('/books')->with('success', 'Buku berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect('/books')->with('error', 'Gagal memperbarui buku: ' . $e->getMessage());
        }
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

            if ($book->cover_image && file_exists(public_path('img/covers/' . $book->cover_image))) {
                unlink(public_path('img/covers/' . $book->cover_image));
            }

            // Hapus buku
            $book->delete();

            Loging::addBook($book->judul, 'ditambahkan');
            // Berhasil dihapus
            return redirect('/books')->with('success', 'Buku berhasil dihapus!');
        } catch (\Exception $e) {
            // Kalau terjadi error (misal gagal konek DB, foreign key constraint, dll)
            return redirect('/books')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
