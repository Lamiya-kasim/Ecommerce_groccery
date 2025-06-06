<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Admin Dashboard</h2>

        <!-- Product Upload Form -->
      <!-- Product Upload Form -->
<div class="mb-4">
    <h4>Add Product</h4>
    <form id="addProductForm" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="productName" class="form-label">Product Name</label>
            <input type="text" id="productName" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="productPrice" class="form-label">Price</label>
            <input type="number" id="productPrice" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="productImage" class="form-label">Product Image</label>
            <input type="file" id="productImage" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-success">Add Product</button>
    </form>
</div>

        <!-- Product Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productTable">
                <!-- Products will be inserted here -->
            </tbody>
        </table>
    </div>

    <script src="admin.js"></script>
</body>
</html>