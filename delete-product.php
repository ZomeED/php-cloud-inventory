<?php
require_once 'includes/Database.php';

if (isset($_GET['id'])) {
    $database = new Database();
    $db = $database->getConnection();

    $query = "DELETE FROM products WHERE id = :id";
    
    try {
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $_GET['id']);

        if ($stmt->execute()) {
            header("Location: index.php?status=deleted");
            exit();
        }
    } catch (PDOException $e) {
        die("Error deleting product: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit();
}
