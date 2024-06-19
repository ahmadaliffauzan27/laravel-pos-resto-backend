<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    //index
    public function index()
    {
        $discounts = \App\Models\Discount::all();
        return response()->json([
            'status' => 'success',
            'data' => $discounts
        ], 200);
    }

    //store
    public function store(Request $request)
    {
        //validate request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'value' => 'required',
        ]);

        //create discount
        $discount = \App\Models\Discount::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $discount
        ], 201);

    }

    public function update(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'value' => 'required',
        ]);

        $discount = Discount::findOrFail($id);
        $discount->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $discount
        ], 200);
    }

    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Discount deleted successfully'
        ], 200);
    }
}
