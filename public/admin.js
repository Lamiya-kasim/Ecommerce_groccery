document.addEventListener("DOMContentLoaded", function () {
    fetchProducts();
});

function fetchProducts() {
    fetch("http://127.0.0.1:8000/api/products")
        .then(response => {
            if (!response.ok) {
                throw new Error("Failed to fetch products");
            }
            return response.json();
        })
        .then(data => {
            let tableBody = document.getElementById("productTable");
            tableBody.innerHTML = ""; // Clear table before inserting new data

            if (!Array.isArray(data) || data.length === 0) {
                tableBody.innerHTML = "<tr><td colspan='4' class='text-center'>No products available</td></tr>";
                return;
            }

            data.forEach(product => {
                let price = parseFloat(product.price); // Convert to number

                // Handle invalid price (e.g., null, undefined, or non-numeric values)
                if (isNaN(price)) {
                    price = "N/A";
                } else {
                    price = `$${price.toFixed(2)}`; // Format as currency
                }

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

function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this product?")) {
        deleteProduct(id);
    }
}

function deleteProduct(id) {
    fetch(`http://127.0.0.1:8000/api/products/${id}`, {
        method: "DELETE",
        headers: {
            "Accept": "application/json",
            "Content-Type": "application/json"
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Failed to delete product");
        }
        return response.json();
    })
    .then(() => {
        alert("Product deleted successfully!");
        fetchProducts(); // Refresh the product list
    })
    .catch(error => console.error("Error deleting product:", error));
}



