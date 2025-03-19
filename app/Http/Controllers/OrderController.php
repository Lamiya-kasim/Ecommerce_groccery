<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // Fetch all orders with their items
    public function index()
    {
        return response()->json(Order::with('orderItems')->get(), 200, [], JSON_PRETTY_PRINT);
    }

    // Store new order
    public function store(Request $request)
    {
        Log::info('Incoming Order Request:', $request->all()); // Log request for debugging

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
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'img' => $item['img'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // Bulk insert items
            OrderItem::insert($orderItems);

            // Fetch the order with items
            $order->load('orderItems');

            return response()->json(['message' => 'Order placed successfully!', 'order' => $order], 201);
        } catch (\Exception $e) {
            Log::error('Order Processing Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to place order!'], 500);
        }
    }
}
