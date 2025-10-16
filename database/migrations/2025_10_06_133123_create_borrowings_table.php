<?php

use App\Models\Book;
use App\Models\Member;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel members
            $table->foreignIdFor(Member::class)
                ->constrained('members')
                ->onDelete('cascade');

            // Relasi ke tabel books
            $table->foreignIdFor(Book::class)
                ->constrained('books')
                ->onDelete('cascade');

            // Detail peminjaman
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
