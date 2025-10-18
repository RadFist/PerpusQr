<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Dotenv\Repository\Adapter\GuardedWriter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Pest\Laravel\get;

class Book extends Model
{
    use HasFactory;

    // Nama tabel (opsional karena Laravel otomatis pakai 'books')
    protected $table = 'books';

    protected $guarded = ['created_at', 'updated_at'];

    // Kolom yang boleh diisi secara mass assignment (fillable)
    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'cover_image',
        'stok',
    ];


    // testing getterAndSetter
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            //getter or accessor
            get: fn(string $value) => "Tahun " . Carbon::parse($value)->format('d-m-Y'),
            //setter or mutator
            set: fn(string $value) => Carbon::parse($value)->format('Y-m-d')
        );
    }

    // function to decrease book stock
    public function decreaseStock($amount = 1)
    {
        if ($this->stok < $amount) {
            throw new \Exception("Stok buku tidak cukup");
        }

        $this->stok -= $amount;
        $this->save();
    }

    // function to increase book stock
    public function increaseStock($amount = 1)
    {
        $this->stok += $amount;
        $this->save();
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
