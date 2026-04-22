<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function view($id)
    {
        $order = Order::with('user', 'coupon', 'items.product', 'histories.admin')->findOrFail($id);
        return view('admin.orders.view', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {

        $order = Order::findOrFail($id);

        $allowed = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['packed', 'cancelled'],
            'packed' => ['shipped'],
            'shipped' => ['delivered'],
            'delivered' => [],
            'cancelled' => [],
        ];

        $request->validate([
            'order_status' => 'required|string'
        ]);

        $new_status = $request->order_status;
        $current_status = $order->order_status;

        if (!in_array($new_status, $allowed[$current_status])) {
            return response()->json([
            'status' => false,
            'message' => 'Invalid status transition'
        ], 422);
        }

        DB::transaction(function () use ($order, $new_status) {

            $order->update([
                'order_status' => $new_status
            ]);

            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => $new_status,
                'changed_by' => session('admin_id')
            ]);
            return response()->json([
        'status'=>true,
        'message'=>'Order status updated Successfully',
        'new_status'=>$new_status
            ]);
        });
    }
}
