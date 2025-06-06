<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        /* Green background section */
        .hero-section {
            background: #1c7226; /* Green color */
            color: white;
            text-align: center;
            padding: 50px 20px;
            position: relative;
            min-height: 250px;
            
        }

        /* Navbar inside the green section */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0.1); /* Slight transparent navbar */
            padding: 15px;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }

        .navbar .nav-links a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            margin: 0 5px;
            font-weight: bold;
        }
        .navbar .nav-links a:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        .user-account {
            display: flex;
            gap: 15px;
        }

        /* Hero Section Text */
        .hero-section h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        .hero-section p {
            font-size: 18px;
            max-width: 600px;
            margin: auto;
            line-height: 1.5;
        }

        /* Products Section */
        .products-section {
            background: white;
            padding: 40px 20px;
            text-align: center;
        }

        .products {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .product {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 200px;
        }

        .product img {
            width: 100%;
            height: 150px;
            border-radius: 5px;
        }

        .add-to-cart {
            background:#28a745;;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .add-to-cart:hover {
            background:#218838;
        }

        /* Footer */
        .footer {
            background: #2d6a4f;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .footer-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: auto;
        }

        .footer-section {
            flex: 1;
            min-width: 200px;
            padding: 10px;
        }

        .footer-section h3 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .footer-section a {
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            margin: 5px 0;
            font-size: 16px;
            transition: 0.3s ease-in-out;
        }

        .footer-section a:hover {
            text-decoration: underline;
        }

        .footer-bottom {
    background: #f1f1f1; /* Make sure a color value is provided */
    padding: 10px;
    margin-top: 10px;
    font-size: 14px;
}


    </style>    
</head>
<body>

    <!-- Green Background Section -->
    <div class="hero-section">
        <!-- Navbar -->
        <div class="navbar">
            <div class="nav-links">
                <a href="dashboard.html">Home</a>
                <a href="/cart">Cart (<span id="cart-count">0</span>)</a>

            </div>

            <div class="user-account">
            <a href="{{ url('/orders') }}">View Orders</a>
                <a href="#" id="logoutButton">Logout</a>
            </div>
        </div>

        <h1>Healthy and Fresh Grocery</h1>
        <p>We provide the finest, nutrient-rich products that cater to your health-conscious lifestyle.</p>
    </div>

    <!-- Products Section -->
    <div class="products-section">
        <h2> YOUSTORE</h2>
        <div class="products" id="products-container">
            <!-- Products will be dynamically inserted here -->
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>We provide the freshest grocery items at the best prices. Quality guaranteed!</p>
            </div>
            <div class="footer-section">

                <a href="{{ url('/about') }}">About</a>
<a href="{{ url('/contact') }}">Contact</a>
<a href="{{ url('/privacy') }}">Privacy Policy</a>

            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook"></i> Facebook</a>
                <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i> Twitter</a>
                <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i> Instagram</a>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2025 Grocery Store | All Rights Reserved
        </div>
    </div>

    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
//fetch thidngne
<script>
    async function fetchProducts() {
        try {
            let response = await fetch('http://127.0.0.1:8000/api/products');
            let products = await response.json();
            displayProducts(products);
        } catch (error) {
            console.error('Error fetching products:', error);
        }
    }
    function displayProducts(products) {
        let container = document.getElementById("products-container");
        container.innerHTML = products.map(p => `
            <div class="product" data-id="${p.id}" data-name="${p.name}" data-price="${p.price}" data-image="${p.image}">
                <img src="${p.image}" alt="${p.name}">
                <h3>${p.name}</h3>
                <p>Price: $${p.price}</p>
                <button class="add-to-cart" onclick="addToCart(${p.id})">Add to Cart</button>
            </div>
        `).join('');
    }

    function updateCartCount() {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        document.getElementById("cart-count").textContent = cart.length;
    }

    function addToCart(id) {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];

        // Find product details directly from the DOM
        let productElement = document.querySelector(`.product[data-id="${id}"]`);
        if (!productElement) return;

        let name = productElement.getAttribute("data-name");
        let price = parseFloat(productElement.getAttribute("data-price"));
        let image = productElement.getAttribute("data-image");

        let existing = cart.find(item => item.id === id);
        if (existing) {
            existing.quantity += 1;
        } else {
            cart.push({ id, name, price, image, quantity: 1 });
        }

        localStorage.setItem("cart", JSON.stringify(cart));
        alert(name + " added to cart!");
        updateCartCount();
    }

    // Initialize the page
    document.addEventListener("DOMContentLoaded", function() {
        fetchProducts();
        updateCartCount();
    });

    function displayProducts(products) {
        let container = document.getElementById("products-container");
        container.innerHTML = products.map(p => `
            <div class="product" data-id="${p.id}" data-name="${p.name}" data-price="${p.price}" data-image="${p.image}">
                <img src="${p.image}" alt="${p.name}">
                <h3>${p.name}</h3>
                <p>Price: $${p.price}</p>
                <button class="add-to-cart" onclick="addToCart(${p.id})">Add to Cart</button>
            </div>
        `).join('');
    }

    function updateCartCount() {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        document.getElementById("cart-count").textContent = cart.length;
    }

    function addToCart(id) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Get product details from DOM
    let productElement = document.querySelector(`.product[data-id="${id}"]`);
    if (!productElement) return;

    let name = productElement.getAttribute("data-name");
    let price = parseFloat(productElement.getAttribute("data-price"));
    let image = productElement.getAttribute("data-image");

    let existing = cart.find(item => item.id === id);
    if (existing) {
        existing.quantity += 1;
    } else {
        cart.push({ id, name, price, image, quantity: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();

    // No alert, no redirect – clean and silent
    console.log(`${name} added to cart.`);
}



    fetchProducts();
    updateCartCount();


    //display products
    document.addEventListener("DOMContentLoaded", async function () {
    let response = await fetch("http://127.0.0.1:8000/api/products");
    let products = await response.json();

    let productContainer = document.querySelector(".product-container"); // Update according to your structure
    productContainer.innerHTML = ""; // Clear existing products

    products.forEach((product) => {
        let productHTML = `
            <div class="product-card">
              <img src="storage/products/${product.image}" alt="${product.name}" class="product-img">
                <h3>${product.name}</h3>
                <p>Price: $${product.price}</p>
                <button class="add-to-cart" data-id="${product.id}">Add to Cart</button>
            </div>
        `;
        productContainer.innerHTML += productHTML;
    });
});

  document.getElementById('logoutButton').addEventListener('click', function() {
            window.location.href = 'index.html';
        });

</script>


</body>
</html>