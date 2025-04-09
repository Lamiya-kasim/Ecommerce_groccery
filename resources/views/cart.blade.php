<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="cart.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        .checkout-form {
            margin-top: 30px;
        }

        .checkout-form input,
        .checkout-form select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .checkout-btn {
            width: 100%;
            padding: 14px;
            background-color: #28a745;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .checkout-btn:hover {
            background-color: #218838;
        }

        .remove-btn {
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .remove-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="cart-items"></tbody>
        </table>
        <h2>Total: <span id="total-price">$0.00</span></h2>

        <div class="checkout-form">
            <input type="text" id="customer-name" placeholder="Full Name" required>
            <input type="email" id="customer-email" placeholder="Email" required>
            <input type="text" id="customer-address" placeholder="Address" required>
            <select id="payment-method" required>
                <option value="">Select Payment Method</option>
                <option value="cash">Cash</option>
                <option value="card">Card</option>
            </select>
        </div>

        <button class="checkout-btn">Checkout</button>
    </div>

    <script src="cart.js"></script>
</body>
</html>
