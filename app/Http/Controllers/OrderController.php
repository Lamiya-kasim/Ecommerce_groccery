<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
{
    try {
        $orders = Order::with('orderItems')->get()->map(function ($order) {
            return [
                'id' => $order->id,
                'customer_name' => $order->customer_name,
                'customer_email' => $order->customer_email,
                'customer_address' => $order->customer_address,
                'payment_method' => $order->payment_method,
                'total_price' => $order->total_price,
                'items' => $order->orderItems->map(function ($item) {
                    return [
                        'product_name' => $item->product_name,
                        'quantity' => $item->quantity
                    ];
                })
            ];
        });

        return response()->json(['orders' => $orders], 200);
    } catch (\Exception $e) {
        \Log::error('Error fetching orders: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to fetch orders'], 500);
    }
}

    
    // Fetch all orders with their items
    public function store(Request $request)
    {
        Log::info('Incoming Order Request:', $request->all());
    
        try {
            // Validate the request
            $request->validate([
                'customer_name' => 'required|string',
                'customer_email' => 'required|email',
                'customer_address' => 'required|string',
                'payment_method' => 'required|string',
                'items' => 'required|array',
                'items.*.name' => 'required|string',
                'items.*.price' => 'required|numeric',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.img' => 'nullable|string',
                'total_price' => 'required|numeric'
            ]);
    
            // Create order
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_address' => $request->customer_address,
                'payment_method' => $request->payment_method,
                'total_price' => $request->total_price
            ]);
    
            // Add order items
            $orderItems = [];
            foreach ($request->items as $item) {
                $orderItems[] = [
                    'order_id' => $order->id,
                    'product_name' => $item['name'],
                    'product_price' => $item['price'],
                    'price' => $item['price'], // ✅ Ensure price is added
                    'quantity' => $item['quantity'],
                    'img' => $item['img'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
    
            // Bulk insert order items
            OrderItem::insert($orderItems);
    
            // Fetch the order with items
            $order->load('orderItems');
    
            return response()->json(['message' => 'Order placed successfully!', 'order' => $order], 201);
        } catch (\Exception $e) {
            Log::error('Order Processing Error: ' . $e->getMessage());
            return response()->json(['error' => 'Order processing failed!', 'details' => $e->getMessage()], 500);
        }
    }
    
    
    // Cancel an order
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $order->delete(); // Delete the order

        return response()->json(['success' => true, 'message' => 'Order cancelled successfully']);
    }
}

