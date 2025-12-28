<?php
require_once 'includes/Database.php';

// 1. Obtener el producto por ID para rellenar el formulario
if (isset($_GET['id'])) {
    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT * FROM products WHERE id = :id LIMIT 0,1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

// 2. Procesar la actualización cuando se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $update_query = "UPDATE products SET 
                    name = :name, 
                    ref = :ref, 
                    description = :description, 
                    quantity = :quantity, 
                    price = :price 
                    WHERE id = :id";
    
    $update_stmt = $db->prepare($update_query);

    // Bind de parámetros (Seguridad contra Inyección SQL)
    $update_stmt->bindParam(':name', $_POST['name']);
    $update_stmt->bindParam(':ref', $_POST['ref']);
    $update_stmt->bindParam(':description', $_POST['description']);
    $update_stmt->bindParam(':quantity', $_POST['quantity']);
    $update_stmt->bindParam(':price', $_POST['price']);
    $update_stmt->bindParam(':id', $_POST['id']);

    if ($update_stmt->execute()) {
        header("Location: index.php?status=updated");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - Inventory Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-header bg-warning text-dark fw-bold">Edit Product: <?php echo htmlspecialchars($product['name']); ?></div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

                            <div class="mb-3">
                                <label class="form-label">Reference</label>
                                <input type="text" name="ref" class="form-control" value="<?php echo htmlspecialchars($product['ref']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control"><?php echo htmlspecialchars($product['description']); ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" name="quantity" class="form-control" value="<?php echo $product['quantity']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price (€)</label>
                                    <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-warning">Update Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
