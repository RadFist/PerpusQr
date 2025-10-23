<?php

namespace App\Http\Controllers;

use App\Models\Loging;
use App\Models\Member;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class MemberController extends Controller
{
    public function index()
    {
        return view('page.members.index', [
            'title' => 'Daftar Anggota',
            'members' => Member::paginate(10)
        ]);
    }

    public function create()
    {
        return view('page.members.formMembers', [
            'title' => 'Tambah Anggota',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:members,email,',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'tanggal_daftar' => 'nullable|date',
        ]);
        Member::create($validated);
        Loging::addMember($request->nama, 'ditambahkan');
        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function edit(Member $member)
    {
        return view('page.members.formMembers', [
            'title' => 'Edit Anggota',
            'members' => $member
        ]);
    }

    public function update(Request $request, Member $member)
    {
        // Validasi input
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:members,email,' . $member->id,
                'telepon' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                'tanggal_daftar' => 'required|date',
            ]);

            // Cek apakah member ada
            if (!$member) {
                return redirect('/members')->with('error', 'Anggota tidak ditemukan!');
            }

            // Update data
            Loging::addMember($request->nama, 'diedit');
            //code...
            $member->update($validated);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal edit Anggota: ' . $e->getMessage());
        }

        // Redirect dengan pesan sukses
        return redirect()->route('members.index')->with('success', 'Anggota berhasil diperbarui!');
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
            Loging::addMember($member->nama, 'dihapus');

            // Berhasil dihapus
            return redirect('/members')->with('success', 'Anggota berhasil dihapus!');
        } catch (\Exception $e) {
            // Kalau terjadi error (misal gagal konek DB, foreign key constraint, dll)
            return redirect('/members')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
