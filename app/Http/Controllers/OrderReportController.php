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
        // Ambil nilai default untuk tanggal
        $startDate = Carbon::now()->subMonth()->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // Filter berdasarkan inputan jika tersedia
        if ($request->has('start_date')) {
            try {
                $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
            } catch (\Exception $e) {
                // Handle invalid date format gracefully
                $startDate = Carbon::now()->subMonth()->startOfDay();
            }
        }

        if ($request->has('end_date')) {
            try {
                $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();
            } catch (\Exception $e) {
                // Handle invalid date format gracefully
                $endDate = Carbon::now()->endOfDay();
            }
        }

        // Ubah format untuk tanggal end_date agar memasukkan rentang penuh hari
        $endDate->addDay();

        // Hitung total diskon, pajak, dan total harga selama periode
        $totalPriceMenu = Order::whereBetween('created_at', [$startDate, $endDate])->sum('sub_total');
        $totalDiscount = Order::whereBetween('created_at', [$startDate, $endDate])->sum('discount');
        $totalTax = Order::whereBetween('created_at', [$startDate, $endDate])->sum('tax');
        $totalAmount = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total');

         // Query data menggunakan whereBetween untuk filter tanggal
         $orders = Order::whereBetween('created_at', [$startDate, $endDate])->paginate(10);

        // return view('pages.report.index', compact('orders', 'startDate', 'endDate'));
        return view('pages.report.index', compact('orders', 'startDate', 'endDate', 'totalPriceMenu','totalDiscount', 'totalTax', 'totalAmount'));
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

