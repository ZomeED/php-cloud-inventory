<?php

/**
 * PROJECT: PHP Cloud Inventory Manager
 * PURPOSE: Main Dashboard to display inventory items from MySQL database.
 * ARCHITECTURE: Built with PHP (PDO) and Bootstrap 5 for professional responsiveness.
 */

// 1. Dependency Injection: Include the Database class to handle connections
require_once 'includes/Database.php';

// Instantiate the database object and establish a secure PDO connection
$database = new Database();
$db = $database->getConnection();

/**
 * 2. DATA RETRIEVAL
 * Fetching all products from the 'products' table.
 * We use 'ORDER BY created_at DESC' so the recruiter sees new additions at the top.
 */
$query = "SELECT * FROM products ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();

// Store results in an associative array for easy iteration in the HTML view
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud Inventory Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-dark">Inventory Management</h2>
            <a href="add-product.php" class="btn btn-primary shadow-sm">+ Add New Product</a>
        </div>

        <!-- When a product is added, show a success message -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'added'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Product added to the cloud database.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- When a product is deleted, show an info message -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Notice:</strong> Product removed from inventory.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- When a product is updated, show an info message -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'updated'): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Product details have been updated.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Ref</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-center">Stock</th>
                            <th>Price</th>
                            <th>Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Check if there are products in the database to display -->
                        <?php if (count($products) > 0): ?>
                            <!-- Loop through each product and create a table row -->
                            <?php foreach ($products as $row): ?>
                                <tr>
                                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($row['ref']); ?></span></td>
                                    <td class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td class="text-muted small"><?php echo htmlspecialchars($row['description']); ?></td>
                                    <td class="text-center"><?php echo $row['quantity']; ?></td>
                                    <td><?php echo number_format($row['price'], 2); ?>€</td>
                                    <td class="text-muted small"><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                                    <!-- Action buttons for editing and deleting products -->
                                    <td class="text-center">
                                        <a href="edit-product.php?id=<?php echo $row['id']; ?>"
                                            class="btn btn-warning btn-sm shadow-sm m-1 me-1">
                                            Edit
                                        </a>

                                        <a href="delete-product.php?id=<?php echo $row['id']; ?>"
                                            class="btn btn-danger btn-sm shadow-sm"
                                            onclick="return confirm('Are you sure you want to delete this item?');">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No products found in the inventory.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <footer class="mt-5 text-center text-muted small">
            <p>PHP Cloud Inventory Manager - Educational Project for Erasmus Internship</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>