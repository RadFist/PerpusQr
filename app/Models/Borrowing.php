<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $table = 'borrowings';

    protected $fillable = [
        'member_id',
        'book_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function scopeWithRelations($query)
    {
        return $query->join('books', 'books.id', '=', 'book_id')
            ->join('members', 'members.id', '=', 'member_id')
            ->select('books.*', 'members.*', 'borrowings.tanggal_pinjam', 'borrowings.tanggal_kembali', 'borrowings.status', 'borrowings.id as borrow_id');
    }
}
