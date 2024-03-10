<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class OrderController extends Controller
{
    //save order
    public function saveOrder(Request $request)
    {
        //validate request
        $request->validate([
            'payment_amount' => 'required',
            'sub_total' => 'required',
            'tax' => 'required',
            'discount' => 'required',
            'service_charge' => 'required',
            'total' => 'required',
            'payment_method' => 'required',
            'total_item' => 'required',
            'id_kasir' => 'required',
            'nama_kasir' => 'required',
            'transaction_time' => 'required'
        ]);

        //create order
        $order = Order::create([
            'payment_amount' => $request->payment_amount,
            'sub_total' => $request->sub_total,
            'tax' => $request->tax,
            'discount' => $request->discount,
            'service_charge' => $request->service_charge,
            'total' => $request->total,
            'payment_method' => $request->payment_method,
            'total_item' => $request->total_item,
            'id_kasir' => $request->id_kasir,
            'nama_kasir' => $request->nama_kasir,
            'transaction_time' => $request->transaction_time
        ]);

        //create order items
        foreach ($request->order_items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id_product'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $order
        ], 200);
    }

     // Mendapatkan transaksi dalam rentang waktu satu bulan
    public function getTransactionsInLastMonth()
    {
        // Mendapatkan tanggal awal bulan lalu
    $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();

    // Mendapatkan tanggal akhir bulan ini
    $endOfCurrentMonth = Carbon::now()->endOfMonth();

    // Mengambil transaksi dalam rentang waktu satu bulan dari tanggal 7 bulan lalu hingga tanggal 7 bulan saat ini
    $transactions = Order::whereBetween('transaction_time', [
        $startOfLastMonth->subDays(30)->format('Y-m-d'), // 30 hari sebelum tanggal awal bulan lalu
        $endOfCurrentMonth->subDays(30)->format('Y-m-d') // 30 hari sebelum tanggal akhir bulan saat ini
    ])->get();

    return response()->json([
        'status' => 'success',
        'data' => $transactions
    ], 200);
    }
}
