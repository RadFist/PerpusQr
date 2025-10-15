<?php

namespace App\Http\Controllers;

use App\Models\Book;

class TestingController extends Controller
{

    function index()
    {
        $book = Book::first();
        dd($book->created_at);
    }
}
