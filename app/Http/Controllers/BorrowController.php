<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Log;

use App\Models\Borrowing;
use App\Models\Member;
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
        return view('formBorrow', [
            'title' => 'Tambah Peminjaman',
            'members' => Member::all(),
            'books' => Book::where('stok', '>', 0)->get(),

        ]);
    }

    public function store(Request $request)
    {

        $validate = $request->validate([
            'member_id' => 'required',
            'book_id' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'status' => 'nullable|string',
        ]);

        try {
            Borrowing::create($validate);
            return redirect('/borrow')->with('success', 'Peminjaman berhasil ditambahkan!');
        } catch (\Throwable $th) {
            return redirect('/borrow')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function show($id)
    {
        echo "show";
    }

    public function edit(Borrowing $borrow)
    {
        return view('formBorrow', [
            'title' => 'Tambah Peminjaman',
            'members' => Member::all(),
            'books' => Book::where('stok', '>', 0)->get(),
            'borrow' => $borrow
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'member_id' => 'required',
            'book_id' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'status' => 'nullable|string',
        ]);

        try {
            Borrowing::where('id', $id)->update($validate);
            return redirect('/borrow')->with('success', 'Peminjaman berhasil diupdate!');
        } catch (\Throwable $th) {
            return redirect('/borrow')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
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
