<?php

/**
 * PROJECT: PHP Cloud Inventory Manager
 * PURPOSE: Retrieve existing product data and process updates.
 */

require_once 'includes/Database.php';

$database = new Database();
$db = $database->getConnection();

// 1. DATA RETRIEVAL: Fetch the product by ID to pre-fill the form
if (isset($_GET['id'])) {
    $query = "SELECT * FROM products WHERE id = :id LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // If product doesn't exist, redirect back to dashboard
    if (!$product) {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

// 2. UPDATE LOGIC: Process the form when submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $update_query = "UPDATE products SET 
                    name = :name, 
                    ref = :ref, 
                    description = :description, 
                    quantity = :quantity, 
                    price = :price 
                    WHERE id = :id";

    try {
        $update_stmt = $db->prepare($update_query);

        // Binding parameters (SQL Injection protection)
        $update_stmt->bindParam(':name', $_POST['name']);
        $update_stmt->bindParam(':ref', $_POST['ref']);
        $update_stmt->bindParam(':description', $_POST['description']);
        $update_stmt->bindParam(':quantity', $_POST['quantity']);
        $update_stmt->bindParam(':price', $_POST['price']);
        $update_stmt->bindParam(':id', $_POST['id']);

        if ($update_stmt->execute()) {
            // Success! Redirect to dashboard with update status
            header("Location: index.php?status=updated");
            exit();
        }
    } catch (PDOException $e) {
        $error_message = "Error updating product: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Cloud Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger shadow-sm"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <div class="card shadow border-0">
                    <div class="card-header bg-warning text-dark py-3">
                        <h4 class="mb-0 fw-bold">
                            <i class="bi bi-pencil-square"></i> Edit Product: <?php echo htmlspecialchars($product['name']); ?>
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Reference</label>
                                    <input type="text" name="ref" class="form-control" value="<?php echo htmlspecialchars($product['ref']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Product Name</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Quantity in Stock</label>
                                    <input type="number" name="quantity" class="form-control" value="<?php echo $product['quantity']; ?>" required min="0">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Price (€)</label>
                                    <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <a href="index.php" class="btn btn-outline-secondary px-4">Cancel</a>
                                <button type="submit" class="btn btn-warning px-4 fw-bold">
                                    <i class="bi bi-arrow-clockwise"></i> Update Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>