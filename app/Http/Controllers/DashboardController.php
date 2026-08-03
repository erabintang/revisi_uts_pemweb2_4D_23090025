<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user->isAdmin();

        $stats = [
            'products' => Product::count(),
            'categories' => Categories::count(),
            'users' => User::count(),
            'lowStock' => Product::where('stock', '<=', 5)->count(),
        ];

        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentProducts', 'isAdmin'));
    }
}
