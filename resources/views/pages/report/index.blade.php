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

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="{{ route('report.index') }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="start_date">Start Date</label>
                                                <input type="text" class="form-control datepicker" name="start_date" id="start_date" value="{{ request('start_date', $startDate->format('Y-m-d')) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="end_date">End Date</label>
                                                <input type="text" class="form-control datepicker" name="end_date" id="end_date" value="{{ request('end_date', $endDate->format('Y-m-d')) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mt-4">
                                                <button type="submit" class="btn btn-primary mt-2">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <table class="table-striped table" border="1">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Payment Amount</th>
                                                <th>Subtotal</th>
                                                <th>Tax</th>
                                                <th>Discount</th>
                                                <th>Service Charge</th>
                                                <th>Total</th>
                                                <th>Payment Method</th>
                                                <th>Total Item</th>
                                                <th>Kasir ID</th>
                                                <th>Nama Kasir</th>
                                                <th>Transaction Time</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->payment_amount }}</td>
                                                    <td>{{ $order->sub_total }}</td>
                                                    <td>{{ $order->tax }}</td>
                                                    <td>{{ $order->discount }}</td>
                                                    <td>{{ $order->service_charge }}</td>
                                                    <td>{{ $order->total }}</td>
                                                    <td>{{ $order->payment_method }}</td>
                                                    <td>{{ $order->total_item }}</td>
                                                    <td>{{ $order->id_kasir }}</td>
                                                    <td>{{ $order->nama_kasir }}</td>
                                                    <td>{{ $order->transaction_time }}</td>
                                                    <td>{{ $order->created_at }}</td>
                                                    <td>{{ $order->updated_at }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $orders->withQueryString()->links() }}
                                </div>
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
