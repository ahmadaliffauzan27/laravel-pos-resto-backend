<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

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

        // Query data menggunakan whereBetween untuk filter tanggal
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->paginate(10);

        return view('pages.report.index', compact('orders', 'startDate', 'endDate'));
    }
}

