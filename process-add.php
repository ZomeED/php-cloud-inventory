<?php
require_once 'includes/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();

    // Adjusted query to match your specific schema: name, ref, description, quantity, price
    $query = "INSERT INTO products (name, ref, description, quantity, price) 
              VALUES (:name, :ref, :description, :quantity, :price)";

    try {
        $stmt = $db->prepare($query);

        // Binding parameters safely to prevent SQL Injection
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':ref', $_POST['ref']);
        $stmt->bindParam(':description', $_POST['description']);
        $stmt->bindParam(':quantity', $_POST['quantity']);
        $stmt->bindParam(':price', $_POST['price']);

        if ($stmt->execute()) {
            // Redirect with a success flag
            header("Location: index.php?status=added");
            exit();
        }
    } catch (PDOException $e) {
        // Handle duplicate 'ref' or other DB errors
        die("Critical Database Error: " . $e->getMessage());
    }
} else {
    header("Location: add-product.php");
    exit();
}
