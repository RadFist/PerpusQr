<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function index()
    {
        return view(
            'borrow',
            [
                'title' => 'Peminjaman Buku',
                'borrows' => [],
                'borrowings' => []
            ]
        );
    }

    public function create()
    {
        echo "create";
    }

    public function store(Request $request)
    {
        echo "store";
    }

    public function show($id)
    {
        echo "show";
    }

    public function edit($id)
    {
        echo "edit";
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
