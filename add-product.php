<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Product - Cloud Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Create New Inventory Item</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="process-add.php" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="e.g. Air Heater" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Reference (Ref/Barcode)</label>
                                    <input type="text" name="ref" class="form-control" placeholder="e.g. 50383" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Enter product details..."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Initial Quantity</label>
                                    <input type="number" name="quantity" class="form-control" value="0" min="0">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price (€)</label>
                                    <input type="number" step="0.01" name="price" class="form-control" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                <a href="index.php" class="btn btn-outline-secondary me-md-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save to Inventory</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
