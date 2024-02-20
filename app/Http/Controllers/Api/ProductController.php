<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //index api
    public function index()
    {
        //get all products
        $product = Product::all();
        //load category
        $product->load('category');
        // $product = Product::paginate(10);
        return response()->json([
            'status' => 'success',
            'data' => $product
        ], 200);
    }
}
