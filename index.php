<?php
// 1. Incluimos la conexión a la base de datos
require_once 'includes/Database.php';

$database = new Database();
$db = $database->getConnection();

// 2. Consultamos todos los artículos de la base de datos
// Usamos ORDER BY created_at DESC para que los nuevos aparezcan arriba
$query = "SELECT * FROM products ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();
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

        <?php if(isset($_GET['status']) && $_GET['status'] == 'added'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Product added successfully to the cloud database!
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($products) > 0): ?>
                            <?php foreach($products as $row): ?>
                            <tr>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($row['ref']); ?></span></td>
                                <td class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td class="text-muted small"><?php echo htmlspecialchars($row['description']); ?></td>
                                <td class="text-center"><?php echo $row['quantity']; ?></td>
                                <td><?php echo number_format($row['price'], 2); ?>€</td>
                                <td class="text-muted small"><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No products found in the inventory.</td>
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
