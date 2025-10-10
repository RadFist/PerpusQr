<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        return view('dashboard', [
            'title' => 'Dashboard',
            'countMembers' => Member::count(),
            'countBooks' => Book::count(),
        ]);
    }
}
