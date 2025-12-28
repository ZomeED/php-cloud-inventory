<?php

/**
 * PROJECT: PHP Cloud Inventory Manager
 * PURPOSE: Main Dashboard to display inventory items from MySQL database.
 * ARCHITECTURE: Built with PHP (PDO) and Bootstrap 5 for professional responsiveness.
 */

// Include the Database class to handle connections
require_once 'includes/Database.php';

// Instantiate the database object and establish a secure PDO connection
$database = new Database();
$db = $database->getConnection();

// Fetching all products from the 'products' table. Latest entries appear first.
$query = "SELECT * FROM products ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();

// Store results in an associative array for easy iteration in the HTML view
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- STATS LOGIC ---
// 1. Total Products
$total_items = $db->query("SELECT COUNT(*) FROM products")->fetchColumn();

// 2. Total Inventory Value
$total_value = $db->query("SELECT SUM(quantity * price) FROM products")->fetchColumn();
// Si la tabla está vacía, SUM devuelve null. Lo convertimos a 0.
$total_value = $total_value ? $total_value : 0;

// 3. Low Stock Count
$low_stock_count = $db->query("SELECT COUNT(*) FROM products WHERE quantity < 10")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud Inventory Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-dark">Inventory Management</h2>
            <a href="add-product.php" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg"></i> Add New Product
            </a>
        </div>

        <!-- Alert Notifications -->
        <?php if (isset($_GET['status'])): ?>
            <?php
            $alertClass = 'alert-info';
            $message = '';
            if ($_GET['status'] == 'added') {
                $alertClass = 'alert-success';
                $message = 'Product added to the cloud database.';
            }
            if ($_GET['status'] == 'deleted') {
                $alertClass = 'alert-warning';
                $message = 'Product removed from inventory.';
            }
            if ($_GET['status'] == 'updated') {
                $alertClass = 'alert-info';
                $message = 'Product details have been updated.';
            }
            ?>
            <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show shadow-sm" role="alert">
                <strong>Notification:</strong> <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
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
                        <!-- Loop through products if available and display them -->
                        <?php if (count($products) > 0): ?>
                            <?php foreach ($products as $row): ?>
                                <tr>
                                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($row['ref']); ?></span></td>
                                    <td class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td class="text-muted small"><?php echo htmlspecialchars($row['description']); ?></td>

                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <span class="fw-bold"><?php echo $row['quantity']; ?></span>
                                            <!-- Low stock indicator -->
                                            <?php if ($row['quantity'] < 10): ?>
                                                <span class="badge bg-danger mt-1" style="font-size: 0.7rem;">LOW STOCK</span>
                                            <?php else: ?>
                                                <span class="badge bg-success mt-1" style="font-size: 0.7rem;">IN STOCK</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td class="fw-bold"><?php echo number_format($row['price'], 2); ?>€</td>
                                    <td class="text-muted small"><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>

                                    <!-- Product Actions -->
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="edit-product.php?id=<?php echo $row['id']; ?>"
                                                class="btn btn-warning btn-sm shadow-sm d-flex align-items-center justify-content-center"
                                                style="width: 80px;">
                                                <i class="bi bi-pencil me-1"></i> Edit
                                            </a>
                                            <a href="delete-product.php?id=<?php echo $row['id']; ?>"
                                                class="btn btn-danger btn-sm shadow-sm d-flex align-items-center justify-content-center"
                                                style="width: 80px;"
                                                onclick="return confirm('Are you sure you want to delete this item?');">
                                                <i class="bi bi-trash me-1"></i> Delete
                                            </a>
                                        </div>
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

        <div class="row mt-3">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm bg-primary text-white h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase small fw-bold">Total Products References</h6>
                            <h2 class="mb-0"><?php echo $total_items; ?></h2>
                        </div>
                        <i class="bi bi-box-seam fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm bg-success text-white h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase small fw-bold">Inventory Value</h6>
                            <h2 class="mb-0"><?php echo number_format($total_value, 2); ?>€</h2>
                        </div>
                        <i class="bi bi-currency-euro fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-2">
                <div class="card border-0 shadow-sm <?php echo ($low_stock_count > 0) ? 'bg-danger' : 'bg-secondary'; ?> text-white h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase small fw-bold">Low Stock Alerts</h6>
                            <h2 class="mb-0"><?php echo $low_stock_count; ?></h2>
                        </div>
                        <i class="bi bi-exclamation-triangle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-5 text-center text-muted small">
            <p>PHP Cloud Inventory Manager - Educational Project for Erasmus Internship</p>
        </footer>
    </div>

    <!-- JavaScript to clean URL parameters after displaying alerts -->
    <script>
        // Wait for the page to load completely
        window.addEventListener('load', function() {

            // Check if the URL contains "?status=" to clean the address bar
            if (window.location.search.includes('status=')) {

                // Construct a new URL without the search parameters (query string)
                const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;

                // Replace the current URL in the browser history without reloading the page
                window.history.replaceState({
                    path: cleanUrl
                }, '', cleanUrl);
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>