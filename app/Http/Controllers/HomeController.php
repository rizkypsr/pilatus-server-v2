<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::all();
        $products = Product::all();
        $categories = Category::all();
        $orders = Order::all();

        $data = [
            "users" => count($users),
            "products" => count($products),
            "categories" => count($categories),
            "orders" => count($orders),
        ];

        return view('pages.home', $data);
    }
}
