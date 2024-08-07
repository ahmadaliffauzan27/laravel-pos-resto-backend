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
            'transaction_time' => $request->transaction_time,
            'customer_name' => $request->customer_name,
            'table_number' => $request->table_number
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

    public function index(Request $request)
    {
        $start_date = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : now()->subMonth()->startOfDay();
        $end_date = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : now()->endOfDay();

        if ($start_date && $end_date) {
            $orders = Order::whereBetween('created_at', [$start_date, $end_date])->get();
        } else {
            $orders = Order::all();
        }
        return response()->json([
            'status' => 'success',
            'data' => $orders
        ], 200);
    }

    public function summary(Request $request)
{
    $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : now()->subMonth()->startOfDay();
    $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : now()->endOfDay();
    $query = Order::query();
    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    }
    $totalRevenue = (int)$query->sum('total');
    $totalDiscount = (int)$query->sum('discount');
    $totalTax = (int)$query->sum('tax');
    $totalServiceCharge = (int)$query->sum('service_charge');
    $totalSubtotal = (int)$query->sum('sub_total');
    return response()->json([
        'status' => 'success',
        'data' => [
            'total_revenue' => $totalRevenue,
            'total_discount' => $totalDiscount,
            'total_tax' => $totalTax,
            'total_subtotal' => $totalSubtotal,
            'total_service_charge' => $totalServiceCharge,
        ]
    ], 200);
}

}
