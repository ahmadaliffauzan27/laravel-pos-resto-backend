@extends('layouts.app')

@section('title', 'Orders Report')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Orders Report</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Reports</a></div>
                    <div class="breadcrumb-item">Orders Report</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <p>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </p>
                    </div>
                @endif

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="{{ route('report.index') }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="start_date">Start Date</label>
                                                <input type="date" class="form-control datepicker" name="start_date" id="start_date" value="{{ old('start_date', $startDate->format('Y-m-d')) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="end_date">End Date</label>
                                                <input type="date" class="form-control datepicker" name="end_date" id="end_date" value="{{ old('end_date', $endDate->format('Y-m-d')) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mt-4">
                                                <button type="submit" class="btn btn-primary mt-2">Filter</button>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-3">
                                            <div class="form-group mt-4">
                                                <a href="{{ route('report.pdf', ['start_date' => request('start_date', $startDate->format('Y-m-d')), 'end_date' => request('end_date', $endDate->format('Y-m-d'))]) }}" class="btn btn-success mt-2">Download PDF</a>
                                            </div>
                                        </div> --}}
                                        @if(!$errors->any())
                                            <div class="col-md-3">
                                                <div class="form-group mt-4">
                                                    <a href="{{ route('report.pdf', ['start_date' => request('start_date', $startDate->format('Y-m-d')), 'end_date' => request('end_date', $endDate->format('Y-m-d'))]) }}" class="btn btn-success mt-2">Download PDF</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </form>

                                @if(!$errors->any())
                                    <div class="table-responsive">
                                        @if($orders->isEmpty())
                                            <p class="text-center">Tidak ada transaksi yang terjadi</p>
                                        @else
                                            <table class="table-striped table">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Pembayaran Pembeli</th>
                                                        <th>Subtotal</th>
                                                        <th>Pajak</th>
                                                        <th>Diskon</th>
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
                                                            <td>{{ 'Rp ' . number_format($order->total, 0, ',', '.') }}</td>
                                                            <td>{{ $order->payment_method }}</td>
                                                            <td>{{ $order->total_item }}</td>
                                                            <td>{{ $order->nama_kasir }}</td>
                                                            <td>{{ $order->created_at }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>

                                    @if(!$orders->isEmpty())
                                        <div class="float-right">
                                            {{ $orders->withQueryString()->links() }}
                                        </div>

                                        <div class="mt-4">
                                            <h6>Summary</h6>
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th>Total Penjualan Menu</th>
                                                        <td>{{ 'Rp ' . number_format($totalPriceMenu, 0, ',', '.') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Diskon Digunakan</th>
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
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('styles')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endpush

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>

    <!-- Datepicker Initialization -->
    <script>
        $(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
                orientation: 'bottom'
            });
        });
    </script>
@endpush
