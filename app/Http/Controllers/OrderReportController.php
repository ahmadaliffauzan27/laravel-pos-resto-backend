<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use PDF;

class OrderReportController extends Controller
{
    public function index(Request $request)
{
    $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : now()->subMonth()->startOfDay();
    $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : now()->endOfDay();

    $orders = Order::whereBetween('created_at', [$startDate, $endDate])->paginate(10);

    // Calculate totals
    $totalPriceMenu = Order::whereBetween('created_at', [$startDate, $endDate])->sum('sub_total');
    $totalDiscount = Order::whereBetween('created_at', [$startDate, $endDate])->sum('discount');
    $totalTax = Order::whereBetween('created_at', [$startDate, $endDate])->sum('tax');
    $totalAmount = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total');

    return view('pages.report.index', compact('orders', 'totalPriceMenu', 'totalDiscount', 'totalTax', 'totalAmount', 'startDate', 'endDate'));
}


    public function download(Request $request)
{
    $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date'))->startOfDay() : Carbon::now()->startOfMonth();
    $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date'))->endOfDay() : Carbon::now()->endOfMonth();

    $ordersQuery = Order::whereBetween('created_at', [$startDate, $endDate]);

    $totalPriceMenu = $ordersQuery->sum('sub_total');
    $totalDiscount = $ordersQuery->sum('discount');
    $totalTax = $ordersQuery->sum('tax');
    $totalAmount = $ordersQuery->sum('total');

    $orders = $ordersQuery->get();

    $pdf = PDF::loadView('pages.report.pdf', compact('orders', 'startDate', 'endDate', 'totalPriceMenu','totalDiscount', 'totalTax', 'totalAmount'));

    return $pdf->download('orders_report_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.pdf');
}


    public function show($id)
{
     // Cari order berdasarkan ID
     $order = Order::findOrFail($id);

     // Tampilkan view dengan data order
     return view('orders.show', compact('order'));
}

}

