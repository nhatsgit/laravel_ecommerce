<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::inRandomOrder()->limit(12)->get(); // Lấy 12 sản phẩm ngẫu nhiên cho danh sách chính
        $sliderProducts = Product::inRandomOrder()->limit(3)->get(); // Lấy 3 sản phẩm ngẫu nhiên cho slider

        return view('home', [
            'products' => $products,
            'sliderProducts' => $sliderProducts
        ]);
    }
}
