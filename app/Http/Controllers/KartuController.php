<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class KartuController extends Controller
{
    public function index($id)
    {   
        $data = Peminjaman::find($id);
        return view('kartu-peminjaman', compact('data'));
    }
}
