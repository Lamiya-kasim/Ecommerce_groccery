<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        tr:hover {
            background: #ddd;
        }
        .cancel-btn {
            background: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .cancel-btn:hover {
            background: darkred;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Payment Method</th>
                    <th>Items</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="orders-list">
                <tr><td colspan="8">Loading orders...</td></tr>
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetchOrders();
        });

        function fetchOrders() {
            fetch("http://127.0.0.1:8000/api/orders") // Laravel API route
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    let ordersList = document.getElementById("orders-list");
                    ordersList.innerHTML = ""; // Clear previous data

                    // Check if data.orders exists and is not empty
                    if (!data.orders || data.orders.length === 0) {
                        ordersList.innerHTML = "<tr><td colspan='8' class='error'>No orders found</td></tr>";
                        return;
                    }

                    data.orders.forEach(order => {
                        let orderedItems = order.items && order.items.length 
    ? order.items.map(item => `${item.product_name} (${item.quantity})`).join(", ")
    : "No items";


                        let row = document.createElement("tr");
                        row.id = `order-${order.id}`; // Unique row ID

                        row.innerHTML = `
                            <td>${order.id}</td>
                            <td>${order.customer_name}</td>
                            <td>${order.customer_email}</td>
                            <td>${order.customer_address}</td>
                            <td>${order.payment_method}</td>
                            <td>${orderedItems}</td>
                            <td>$${parseFloat(order.total_price).toFixed(2)}</td>
                            <td>
                                <button class="cancel-btn" onclick="cancelOrder(${order.id})">Cancel Order</button>
                            </td>
                        `;

                        ordersList.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error("Error fetching orders:", error);
                    document.getElementById("orders-list").innerHTML = "<tr><td colspan='8' class='error'>Failed to load orders</td></tr>";
                });
        }

        function cancelOrder(orderId) {
            if (!confirm("Are you sure you want to cancel this order?")) {
                return;
            }

            fetch(`http://127.0.0.1:8000/api/orders/${orderId}`, { 
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`order-${orderId}`).remove(); // Remove from UI
                    alert("Order cancelled successfully!");
                } else {
                    alert("Failed to cancel order!");
                }
            })
            .catch(error => {
                console.error("Error cancelling order:", error);
                alert("An error occurred while cancelling the order.");
            });
        }
    </script>
</body>
</html>



