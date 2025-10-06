<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Nama tabel (opsional karena Laravel otomatis pakai 'books')
    protected $table = 'books';

    // Kolom yang boleh diisi secara mass assignment (fillable)
    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok',
    ];
}
