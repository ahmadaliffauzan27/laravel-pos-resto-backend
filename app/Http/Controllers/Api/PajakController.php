<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pajak;

class PajakController extends Controller
{
    //index
    public function index()
    {
        $pajak = \App\Models\Pajak::all();
        return response()->json([
            'status' => 'success',
            'data' => $pajak
        ], 200);
    }

    //store
    public function store(Request $request)
    {
        //validate request
        $request->validate([
            'value' => 'required',
        ]);

        //create pajak
        $pajak = \App\Models\Pajak::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $pajak
        ], 201);

    }

    public function update(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'value' => 'required',
        ]);

        $pajak = Pajak::findOrFail($id);
        $pajak->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $pajak
        ], 200);
    }

    public function destroy($id)
    {
        $pajak = Pajak::findOrFail($id);
        $pajak->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pajak deleted successfully'
        ], 200);
    }
}
