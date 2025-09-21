<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    // contoh halaman home
    public function home()
    {
        return response()->json([
            'message' => 'Welcome to Public Module',
            'status' => 'success'
        ]);
    }

    // contoh daftar produk publik
    public function products()
    {
        $products = [
            ['id' => 1, 'name' => 'Product A'],
            ['id' => 2, 'name' => 'Product B'],
        ];

        return response()->json($products);
    }
}
