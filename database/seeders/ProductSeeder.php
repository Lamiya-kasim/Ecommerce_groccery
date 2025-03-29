<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'Apple', 'price' => 2.99, 'image' => 'images/apple.jpg'],
            ['name' => 'Banana', 'price' => 1.49, 'image' => 'images/banana.jpg'],
            ['name' => 'Milk', 'price' => 3.49, 'image' => 'images/milk.jpg'],
            ['name' => 'Eggs', 'price' => 4.99, 'image' => 'images/eggs.jpg'],
            ['name' => 'Bread', 'price' => 2.49, 'image' => 'images/bread.jpg'],
            ['name' => 'Tomato', 'price' => 1.89, 'image' => 'images/tomato.jpg'],
            ['name' => 'Potato', 'price' => 6.99, 'image' => 'images/potato.jpg'],
            ['name' => 'Cheese', 'price' => 5.49, 'image' => 'images/cheese.jpg'],
            ['name' => 'Chicken', 'price' => 12.99, 'image' => 'images/chicken.jpg'],
            ['name' => 'Rice', 'price' => 11.49, 'image' => 'images/rice.jpg'],
            ['name' => 'Grapes', 'price' => 4.00, 'image' => 'images/grapes.jpg'],
            ['name' => 'Kale', 'price' => 3.99, 'image' => 'images/kale.jpg'],
            ['name' => 'Mango', 'price' => 4.67, 'image' => 'images/mango.jpg'],
            ['name' => 'Meat', 'price' => 6.00, 'image' => 'images/meat.jpg'],
            ['name' => 'Oats', 'price' => 10.00, 'image' => 'images/oats.jpg'],
            ['name' => 'Sardine', 'price' => 5.65, 'image' => 'images/sardine.jpg'],
            ['name' => 'Strawberry', 'price' => 2.45, 'image' => 'images/strawberry.jpg'],
            ['name' => 'Yogurt', 'price' => 4.00, 'image' => 'images/yogurt.jpg'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

