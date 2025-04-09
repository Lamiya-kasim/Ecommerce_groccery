document.addEventListener("DOMContentLoaded", function () {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let cartItemsContainer = document.getElementById("cart-items");
    let totalPriceElement = document.getElementById("total-price");
    let checkoutButton = document.querySelector(".checkout-btn");

    function updateCartUI() {
        cartItemsContainer.innerHTML = "";
        let totalPrice = 0;

        cart.forEach((item, index) => {
            let row = document.createElement("tr");
            row.innerHTML = `
                <td>${item.name}</td>
                <td>$${item.price.toFixed(2)}</td>
                <td>
                    <input type="number" min="1" value="${item.quantity}" data-index="${index}" class="qty-input">
                </td>
                <td>
                    <button class="remove-btn" data-index="${index}">Remove</button>
                </td>
            `;
            cartItemsContainer.appendChild(row);
            totalPrice += item.price * item.quantity;
        });

        totalPriceElement.innerText = `$${totalPrice.toFixed(2)}`;
        attachEventListeners();
    }

    function attachEventListeners() {
        document.querySelectorAll(".remove-btn").forEach((btn) => {
            btn.addEventListener("click", function () {
                let index = this.getAttribute("data-index");
                cart.splice(index, 1);
                localStorage.setItem("cart", JSON.stringify(cart));
                updateCartUI();
            });
        });

        document.querySelectorAll(".qty-input").forEach((input) => {
            input.addEventListener("input", function () {
                let index = this.getAttribute("data-index");
                let newQty = parseInt(this.value);

                if (isNaN(newQty) || newQty < 1) {
                    alert("Quantity must be at least 1!");
                    this.value = cart[index].quantity;
                    return;
                }

                cart[index].quantity = newQty;
                localStorage.setItem("cart", JSON.stringify(cart));
                updateCartUI();
            });
        });
    }

    updateCartUI();

    if (checkoutButton) {
        checkoutButton.addEventListener("click", function () {
            if (cart.length === 0) {
                alert("Your cart is empty!");
                return;
            }

            let customerName = document.getElementById("customer-name").value.trim();
            let customerEmail = document.getElementById("customer-email").value.trim();
            let customerAddress = document.getElementById("customer-address").value.trim();
            let paymentMethod = document.getElementById("payment-method").value;

            if (!customerName || !customerEmail || !customerAddress || !paymentMethod) {
                alert("All fields are required!");
                return;
            }

            if (!/^\S+@\S+\.\S+$/.test(customerEmail)) {
                alert("Please enter a valid email address!");
                return;
            }

            let totalPrice = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);

            let orderData = {
                customer_name: customerName,
                customer_email: customerEmail,
                customer_address: customerAddress,
                payment_method: paymentMethod,
                items: cart,
                total_price: totalPrice
            };

            fetch("http://127.0.0.1:8000/api/orders", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === "Order placed successfully!") {
                    alert("Order placed successfully!");
                    localStorage.removeItem("cart");
                    updateCartUI();
                    window.location.href = "/orders";

                } else {
                    alert("Checkout failed: " + (data.message || "Unknown error"));
                }
            })
            .catch(error => {
                console.error("Checkout API Error:", error);
                alert("Error processing your order. Please try again.");
            });
        });
    } else {
        console.error("Checkout button not found!");
    }
});


