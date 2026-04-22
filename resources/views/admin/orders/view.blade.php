@extends('layouts.app')

@section('title', 'Order Details')

@section('content')

    <div class="page-heading">
        <h3>Order #{{ $order->order_number }}</h3>
    </div>

    <div class="row">


        <div class="col-md-6 d-flex flex-column">


            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Order Information</h5>

                    <p><strong>Customer:</strong> {{ $order->user->name ?? 'Guest' }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email ?? '-' }}</p>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y h:i A') }}</p>
                    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>

                    <p>
                        <strong>Payment Status:</strong>
                        <span
                            class="badge 
                        @if ($order->payment_status == 'paid') bg-success
                        @elseif($order->payment_status == 'failed') bg-danger
                        @else bg-warning @endif">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>

                    <p><strong>Address:</strong><br>{{ $order->address }}</p>
                </div>
            </div>

            <!-- STATUS UPDATE -->
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="mb-3">Update Status</h5>

                    <form>

                        @csrf
                        @method('PATCH')

                        @php
                            $allowed = [
                                'pending' => ['confirmed', 'cancelled'],
                                'confirmed' => ['packed', 'cancelled'],
                                'packed' => ['shipped'],
                                'shipped' => ['delivered'],
                                'delivered' => [],
                                'cancelled' => [],
                            ];
                        @endphp

                        <select name="order_status" class="form-select" id="order_status"
                            {{ in_array($order->order_status, ['delivered', 'cancelled']) ? 'disabled' : '' }}>

                            @foreach ($allowed[$order->order_status] as $status)
                                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>

                        @if (!in_array($order->order_status, ['delivered', 'cancelled']))
                            <button type="button" class="btn btn-primary mt-3" id="update_status_btn">
                                Update Status
                            </button>
                        @endif
                    </form>
                </div>
            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="col-md-6">

            <!-- ORDER TIMELINE -->
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Order Timeline</h5>

                    @php
                        $allStatuses = ['pending', 'confirmed', 'packed', 'shipped', 'delivered', 'cancelled'];
                        $historyMap = $order->histories->keyBy('status');

                        $icons = [
                            'pending' => 'bi-hourglass-split',
                            'confirmed' => 'bi-check-circle',
                            'packed' => 'bi-box-seam',
                            'shipped' => 'bi-truck',
                            'delivered' => 'bi-bag-check',
                            'cancelled' => 'bi-x-circle',
                        ];

                        $colors = [
                            'pending' => 'secondary',
                            'confirmed' => 'info',
                            'packed' => 'warning',
                            'shipped' => 'primary',
                            'cancelled' => 'danger',
                            'delivered' => 'success',
                        ];
                    @endphp

                    <ul class="list-group list-group-flush">

                        @foreach ($allStatuses as $status)
                            @php
                                if ($status === $order->order_status) {
                                    $state = 'current';
                                    $text = 'In Progress';
                                } elseif ($historyMap->has($status)) {
                                    $state = 'done';
                                    $h = $historyMap[$status];
                                    $text =
                                        ($h->admin->name ?? 'System') . ' · ' . $h->created_at->format('d M Y h:i A');
                                } else {
                                    $state = 'pending';
                                    $text = 'Waiting';
                                }
                            @endphp

                            <li class="list-group-item d-flex align-items-center gap-3">

                                <i class="bi {{ $icons[$status] }} text-{{ $colors[$status] }} fs-5"></i>

                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ ucfirst($status) }}</div>
                                    <small class="text-muted">{{ $text }}</small>
                                </div>

                                @if ($state === 'current')
                                    <span class="badge bg-primary">Current</span>
                                @elseif($state === 'done')
                                    <span class="badge bg-success">Done</span>
                                @endif

                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>

        </div>
    </div>

    <!-- ORDER ITEMS -->
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="mb-3">Order Items</h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th width="120">Price</th>
                        <th width="100">Qty</th>
                        <th width="150">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? '-' }}</td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->item_total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- PRICE SUMMARY -->
    <div class="card mt-3">
        <div class="card-body text-end">
            <p><strong>Subtotal:</strong> ₹{{ number_format($order->sub_amount, 2) }}</p>

            @if ($order->coupon)
                <p>
                    <strong>Coupon ({{ $order->coupon->coupon_code }}):</strong>
                    -₹{{ number_format($order->discount_amount, 2) }}
                </p>
            @else
                <p>
                    <strong>Discount:</strong>
                    ₹{{ number_format($order->discount_amount, 2) }}
                </p>
            @endif

            <p><strong>Shipping:</strong> ₹{{ number_format($order->shipping_amount, 2) }}</p>

            <h5 class="mt-2">
                <strong>Final Total:</strong>
                ₹{{ number_format($order->final_amount, 2) }}
            </h5>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 d-flex justify-content-end">
            
            <a href="{{ route('orders.index') }}" class="btn btn-secondary mb-1">Back</a>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#update_status_btn').click(function() {
                let status = $('#order_status').val();
                alert(status);
                $.ajax({
                    url: "{{ route('orders.updateStatus', $order->id) }}",
                    type: "PATCH",
                    data: {
                        _token: "{{ csrf_token() }}",
                        order_status: status
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: res.message
                        }).then(() => {
                            location.reload(); 
                        });
                    },
                    error: function(xhr) {

                        let msg = "Something went wrong";

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: msg
                        });
                    }
                })
            });
        });
    </script>

@endsection
