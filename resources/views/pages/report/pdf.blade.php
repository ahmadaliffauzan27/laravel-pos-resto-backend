<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan Empal Gentong Mang Medi</title>
    <style>
        @page {
            size: landscape;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Laporan Penjualan Empal Gentong Mang Medi</h1>
    <p>Dari : {{ \Carbon\Carbon::parse($startDate)->isoFormat('D MMMM YYYY') }} - Hingga : {{ \Carbon\Carbon::parse($endDate)->isoFormat('D MMMM YYYY') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pembayaran Pembeli</th>
                <th>Subtotal</th>
                <th>Pajak</th>
                <th>Diskon</th>
                {{-- <th>Biaya Layanan</th> --}}
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
                <th>Total Item</th>
                <th>Nama Kasir</th>
                <th>Waktu Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ 'Rp ' . number_format($order->payment_amount, 0, ',', '.') }}</td>
                    <td>{{ 'Rp ' . number_format($order->sub_total, 0, ',', '.') }}</td>
                    <td>{{ 'Rp ' . number_format($order->tax, 0, ',', '.') }}</td>
                    <td>{{ 'Rp ' . number_format($order->discount, 0, ',', '.') }}</td>
                    {{-- <td>{{ 'Rp ' . number_format($order->service_charge, 0, ',', '.') }}</td> --}}
                    <td>{{ 'Rp ' . number_format($order->total, 0, ',', '.') }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $order->total_item }}</td>
                    <td>{{ $order->nama_kasir }}</td>
                    <td>{{ $order->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Informasi Total Diskon, Pajak, dan Total Harga -->
    <div style="margin-top: 20px;">
        <table>
            <tbody>
                <tr>
                    <th>Total Penjualan Menu</th>
                    <td>{{ 'Rp ' . number_format($totalPriceMenu, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Total Diskon Dipakai</th>
                    <td>{{ 'Rp ' . number_format($totalDiscount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Total Pemasukan Pajak</th>
                    <td>{{ 'Rp ' . number_format($totalTax, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Total Penjualan</th>
                    <td>{{ 'Rp ' . number_format($totalAmount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>
