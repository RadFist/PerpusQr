<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Loging;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function index()
    {
        $memberId = auth()->user()->member_id;
        $borrowCount = Borrowing::where('member_id', $memberId)
            ->where('tanggal_pinjam', '>=', now()->subWeek())
            ->count();
        $returnedCount = Borrowing::where('member_id', $memberId)
            ->where('status', 'dikembalikan')
            ->count();
        $lateCount = Borrowing::where('member_id', $memberId)
            ->where('tanggal_pinjam', '<=', now()->subWeek())
            ->count();
        $BoroowedBook = Borrowing::with('member')
            ->where('member_id', $memberId)
            ->where('status', 'dipinjam')
            ->with(['member', 'book'])
            ->get();


        return view('page.users.index', [
            'borrowCount' => $borrowCount,
            'returnedCount' => $returnedCount,
            'lateCount' =>  $lateCount,
            'books' => $BoroowedBook
        ]);
    }
    public function listBook()
    {
        $Books = Book::paginate(10);
        return view('page.users.listBook', ['books' => $Books]);
    }
    public  function detailBook($id)
    {
        $book = Book::find($id);

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
                'level' => "user"
            ]
        );
    }

    public  function memberBorrow($id)
    {
        try {
            // Ambil ID member dari user yang login
            $memberId = auth()->user()->member_id;

            // Ambil data buku
            $book = Book::findOrFail($id);

            // Isi otomatis tanggal pinjam hari ini
            $tanggal_pinjam = now()->toDateString(); // hasilnya '2025-11-05'
            $tanggal_kembali = null;


            // Simpan data peminjaman
            $borrowing = Borrowing::create([
                'member_id' => $memberId,
                'book_id' => $book->id,
                'tanggal_pinjam' => $tanggal_pinjam,
                'tanggal_kembali' => $tanggal_kembali,

            ]);

            // Load relasi agar bisa digunakan di log
            $borrowing->load(['member', 'book']);

            // Tambahkan log aktivitas
            Loging::addBorrow($borrowing->book->judul, $borrowing->member->nama, 'dipinjam');

            return redirect('/list-book')->with('success', "buku " . $book->judul . " berhasil ditambahkan!");
        } catch (\Throwable $th) {
            Log::error('Error saat menambah peminjaman: ' . $th->getMessage());
            return redirect('/list-book')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}
