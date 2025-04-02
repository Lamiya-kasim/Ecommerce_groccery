document.addEventListener("DOMContentLoaded", function () {
    fetchProducts();
    document.getElementById("addProductForm").addEventListener("submit", addProduct);
});

function fetchProducts() {
    fetch("http://127.0.0.1:8000/api/products")
        .then(response => response.json())
        .then(data => {
            let tableBody = document.getElementById("productTable");
            tableBody.innerHTML = "";

            if (!Array.isArray(data) || data.length === 0) {
                tableBody.innerHTML = "<tr><td colspan='4' class='text-center'>No products available</td></tr>";
                return;
            }

            data.forEach(product => {
                let price = parseFloat(product.price);
                price = isNaN(price) ? "N/A" : `$${price.toFixed(2)}`;

                let row = `<tr>
                    <td>${product.id}</td>
                    <td>${product.name}</td>
                    <td>${price}</td>
                    <td>
                        <button class="btn btn-danger" onclick="confirmDelete(${product.id})">Delete</button>
                    </td>
                </tr>`;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error("Error fetching products:", error));
}

function addProduct(event) {
    event.preventDefault();

    const name = document.getElementById("productName").value;
    const price = document.getElementById("productPrice").value;
    const token = localStorage.getItem("adminToken"); // Get stored admin token

    if (!token) {
        alert("Unauthorized: Please log in as admin.");
        return;
    }

    fetch("http://127.0.0.1:8000/api/products", {
        method: "POST",
        headers: {
            "Accept": "application/json",
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}` // Include admin token
        },
        body: JSON.stringify({ name, price })
    })
    .then(response => response.json())
    .then(data => {
        alert("Product added successfully!");
        document.getElementById("addProductForm").reset();
        fetchProducts();
    })
    .catch(error => console.error("Error adding product:", error));
}

function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this product?")) {
        deleteProduct(id);
    }
}

function deleteProduct(id) {
    const token = localStorage.getItem("adminToken");

    fetch(`http://127.0.0.1:8000/api/products/${id}`, {
        method: "DELETE",
        headers: {
            "Accept": "application/json",
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`
        }
    })
    .then(response => response.json())
    .then(() => {
        alert("Product deleted successfully!");
        fetchProducts();
    })
    .catch(error => console.error("Error deleting product:", error));
}
//add product 
document.getElementById("addProductForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    let formData = new FormData();
    formData.append("name", document.getElementById("productName").value);
    formData.append("price", document.getElementById("productPrice").value);
    formData.append("image", document.getElementById("productImage").files[0]);

    try {
        let response = await fetch("http://127.0.0.1:8000/api/products", {
            method: "POST",
            body: formData,
            headers: {
                "Accept": "application/json",
            },
        });

        let result = await response.json();
        console.log("Server Response:", result);

        if (response.ok) {
            alert("Product added successfully!");
            location.reload(); // Refresh to update product list
        } else {
            alert("Error: " + JSON.stringify(result));
        }
    } catch (error) {
        console.error("Error:", error);
        alert("Failed to add product.");
    }
});




