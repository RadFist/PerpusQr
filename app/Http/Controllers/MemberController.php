<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return view('member', [
            'title' => 'Daftar Anggota',
            'members' => Member::all()
        ]);
    }

    public function create()
    {
        echo "create member";
    }

    public function store(Request $request)
    {
        echo "store member";
    }

    public function edit(Member $member)
    {
        return [
            'nama' => $member->nama,
            'alamat' => $member->alamat,
            'tanggal_lahir' => $member->tanggal_lahir,
            'jenis_kelamin' => $member->jenis_kelamin,
            'nomor_telepon' => $member->nomor_telepon,
            'email' => $member->email,
        ];
    }

    public function destroy(Member $member)
    {
        try {
            // Cek dulu apakah data buku benar-benar ada
            if (!$member) {
                return redirect('/members')->with('error', 'Anggota tidak ditemukan!');
            }

            // Hapus buku
            $member->delete();

            // Berhasil dihapus
            return redirect('/members')->with('success', 'Anggota berhasil dihapus!');
        } catch (\Exception $e) {
            // Kalau terjadi error (misal gagal konek DB, foreign key constraint, dll)
            return redirect('/members')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
