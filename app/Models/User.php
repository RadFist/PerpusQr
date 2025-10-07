<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nama tabel yang digunakan
    protected $table = 'users';

    // Kolom yang bisa diisi secara mass assignment
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting otomatis untuk kolom tertentu
    protected $casts = [
        'password' => 'hashed',
    ];
}
