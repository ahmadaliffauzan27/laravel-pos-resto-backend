<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //index
    public function index()
    {
        $products = \App\Models\Product::paginate(5);
        return view('pages.product.index', compact('products'));
    }

    //create
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('pages.product.create', compact('categories'));
    }

    //store
    public function store(Request $request)
    {

        //validate request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|max:2048', //max 2mb
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'status' => 'required|boolean',
            'is_favourite' => 'required|boolean',
            'category_id' => 'required',
        ]);

        //store data
        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = (int) $request->price;
        $product->category_id = $request->category_id;
        $product->stock = (int) $request->stock;
        $product->status = (bool) $request->status;
        $product->is_favourite = (bool) $request->is_favourite;
        $product->save();

        //save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
            $product->save();
        }

        //redirect
        return redirect()->route('product.index')->with('success', 'Product created successfully');
    }

    //show
    public function show($id)
    {
        return view('pages.dashboard');
    }

    //edit
    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('pages.product.edit', compact('product', 'categories'));
    }

    //update
    public function update(Request $request, $id)
    {

        //validate request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'status' => 'required|boolean',
            'is_favourite' => 'required|boolean',
            'category_id' => 'required',
        ]);

        //store data
        $product = \App\Models\Product::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = (int) $request->price;
        $product->category_id = $request->category_id;
        $product->stock = (int) $request->stock;
        $product->status = (bool) $request->status;
        $product->is_favourite = (bool) $request->is_favourite;
        $product->save();

        //save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
            $product->save();
        }

        //redirect
        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    //destroy
    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }

}
