@extends('layouts.app')
@section('title', 'orders')
@section('page-title', 'orders')
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Orders
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Order Number</th>
                                <th>Customer</th>
                                <th>Total Amount</th>
                                <th>Payment Status</th>
                                <th>Order Status </th>
                                <th>Date</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->order_number }}</td>
                                    <td>
                                        {{ $order->user->name }}
                                    </td>
                                    <td>₹{{ $order->final_amount }}</td>
                                    <td>{{ $order->payment_status }}</td>
                                    <td>{{ $order->order_status }}</td>
                                    <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                                    <td>
                                        <a href="{{ route('orders.view', $order->id) }}"
                                            class="btn btn-warning btn-sm me-1 mb-1">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
