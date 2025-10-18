<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Log;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

use function Pest\Laravel\json;

class BorrowController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['member', 'book'])->paginate(10); // eager load relationships
        // $borrowings = Borrowing::all();      // lazy load relationships (ini yang lama quernya banyak)
        return view(
            'borrow',
            [
                'title' => 'Peminjaman Buku',
                'borrowings' => $borrowings
            ]
        );
    }

    public function create()
    {
        echo "create";
    }

    public function store(Request $request)
    {
        echo "store";
    }

    public function show($id)
    {
        echo "show";
    }

    public function edit($id)
    {
        echo "edit";
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Borrowing $borrow)
    {
        try {
            // Cek dulu apakah data buku benar-benar ada
            if (!$borrow) {
                return redirect('/borrow')->with('error', 'Peminjaman tidak ditemukan!');
            }

            $book = Book::findOrFail($borrow->book_id);


            // Hapus buku
            $borrow->delete();


            $book->increaseStock();

            // Berhasil dihapus
            return redirect('/borrow')->with('success', 'Peminjaman berhasil dihapus!');
        } catch (\Exception $e) {
            // Kalau terjadi error (misal gagal konek DB, foreign key constraint, dll)
            return redirect('/borrow')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function Scanning(Request $request, Borrowing $borrow)
    {

        try {

            $data = $request->validate([
                'anggota_id' => 'required',
                'buku_id' => 'required',
            ]);


            $borrow = Borrowing::create([
                'member_id' => $data['anggota_id'],
                'book_id' => $data['buku_id'],
                'tanggal_pinjam' => now(),
                'status' => 'dipinjam',
            ]);


            $borrow->load(['member', 'book']);
            $book = Book::findOrFail($data['buku_id']);

            $book->decreaseStock();

            return response()->json([
                'status' => 'success',
                'message' => 'Scan berhasil',
                'data' => [
                    'id' => $borrow->id,
                    'nama' => $borrow->member->nama,
                    'judul' => $borrow->book->judul,
                    'tanggal_pinjam' => $borrow->tanggal_pinjam,
                    'status' => $borrow->status,
                ],
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Scan gagal: ' . $th->getMessage(),
            ], 500);
        }
    }
}
