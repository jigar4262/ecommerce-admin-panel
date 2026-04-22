@extends('layouts.app')
@section('title', 'Coupon List')
@section('page-title', 'Coupons')
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Coupon
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Coupon Code</th>
                                <th>Discount</th>
                                <th>Minimum Order Amount</th>
                                <th>Validity</th>
                                <th>Apply On</th>
                                <th>Usage</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ $coupon->id }}</td>
                                    <td>{{ $coupon->coupon_code }}</td>
                                    <td>
                                        @if ($coupon->discount_type == 'percentage')
                                            {{ $coupon->discount_value }}%(Max ₹{{ $coupon->max_discount }})
                                        @else
                                            ₹{{ $coupon->discount_value }}
                                        @endif
                                    </td>
                                    <td>₹{{ $coupon->min_order_amt }}</td>
                                    <td>{{ date('d-m-Y', strtotime($coupon->start_date)) }}<br>
                                        <small>to</small><br>
                                        {{ date('d-m-Y', strtotime($coupon->end_date)) }}
                                    </td>
                                    <td>{{ $coupon->apply_coupon_on}}</td>
                                    <td>{{ empty($coupon->used_count) ? 0 : $coupon->used_count }}/{{ $coupon->total_usage_limit }}
                                    </td>
                                    <td>
                                        @if ($coupon->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('coupons.edit', $coupon->id) }}"
                                            class="btn btn-warning btn-sm me-1 mb-1">Edit</a>
                                        <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mb-1"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
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
