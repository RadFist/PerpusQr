<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loging extends Model
{

    protected $table = 'logs';

    protected $fillable = [
        'member_id',
        'book_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    //tambah data log buku
    public static function addBook($name, $cond)
    {
        // ditambah, dihapus, diedit
        return self::insert([
            'log' => 'buku ' . $name . ' telah ' . $cond,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    //tambah data log member
    public static function addMember($name, $cond, $status = "member")
    {
        // ditambahkan, dihapus, diedit
        $role =  $status == "member " ? 'anggota, ' : 'admin, ';
        return self::insert([
            'log' =>  $role . $name . ' telah ' . $cond,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public static function addBorrow($book, $name, $cond)
    {
        //pinjam, kembalikan
        return self::insert([
            'log' =>  $book . ' telah ' . $cond . ' oleh ' . $name,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
    /** @use HasFactory<\Database\Factories\LogFactory> */
    use HasFactory;
}
