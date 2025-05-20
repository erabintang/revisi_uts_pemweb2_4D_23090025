<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    //fungsi untuk menampilkan halaman homepage
    public function index()
    {
        $categories = Categories::all();
        $title = "Homepage";
        return view('components.web.homepage', ['categories' => $categories, 'title' => $title]);
    }
    //fungsi untuk menampilkan halaman products
    public function products()
    {
        $categories = Categories::all();
        $title = "Products";
        return view('components.web.products', ['title' => $title, 'categories' => $categories]);
    }
    //fungsi untuk menampilkan halaman single product
    public function single_product($slug)
    {
        $title = "Single Product";
        return view('components.web.single_product', ['title' => $title, 'slug' => $slug]);
    }
    //fungsi untuk menampilkan halaman categories
    public function categories()
    {
        $title = "Categories";
        return view('components.web.categories', ['title' => $title]);
    }
    //fungsi untuk menampilkan halaman single category
    public function single_category($slug)
    {
        $category = Categories::findBySlug($slug);
        $title = "Single Category";
        return view('components.web.single_category', ['title' => $title, 'slug' => $slug, 'category' => $category]);
    }
    //fungsi untuk menampilkan halaman cart
    public function cart()
    {
        $title = "Cart";
        return view('components.web.cart', ['title' => $title]);
    }
    //fungsi untuk menampilkan halaman checkout
    public function checkout()
    {
        $title = "Checkout";
        return view('components.web.checkout', ['title' => $title]);
    }
    //fungsi untuk menampilkan navbar categories
    public function navbarCategories()
    {
        $categories = Categories::all();
        return view('components.navbar', compact('categories'));
    }
}
