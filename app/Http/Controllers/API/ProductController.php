<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Fetch all products
    public function index()
    {
        $products = Product::all();
    
        // Ensure correct image path
        foreach ($products as $product) {
            $product->image = asset('storage/' . $product->image);
        }
    
        return response()->json($products);
    }
    
    public function store(Request $request)
{
    $request->validate([
        'name'  => 'required|string|max:255',
        'price' => 'required|numeric',
        'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validate image
    ]);

    // Store Image
    $imagePath = $request->file('image')->store('products', 'public');

    // Save Product
    $product = Product::create([
        'name'  => $request->name,
        'price' => $request->price,
        'image' => $imagePath,
    ]);

    return response()->json(['message' => 'Product added!', 'product' => $product], 201);
}

    public function destroy($id)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        $product->delete();
    
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
    
}

