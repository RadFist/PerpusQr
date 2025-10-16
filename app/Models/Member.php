<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    // Nama tabel (opsional karena Laravel otomatis pakai 'books')
    protected $table = 'members';

    protected $guarded = ['created_at', 'updated_at'];

    // Kolom yang boleh diisi secara mass assignment (fillable)
    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'alamat',
        'tanggal_daftar',
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
