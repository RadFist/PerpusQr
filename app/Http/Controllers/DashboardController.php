<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        Log::info("Dashboard accessed by user : " .  Auth::user()->name);

        return view('dashboard', [
            'title' => 'Dashboard',
            'countMembers' => Member::count(),
            'countBooks' => Book::count(),
            'countBorrowing' => Borrowing::where('status', 'dipinjam')->count()
        ]);
    }
}
