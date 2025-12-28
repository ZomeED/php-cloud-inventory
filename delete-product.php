<?php
/**
 * PROJECT: PHP Cloud Inventory Manager
 * PURPOSE: Securely remove a product from the database using its unique ID.
 */

require_once 'includes/Database.php';

// 1. CHECK ID: Ensure an ID is provided via GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    $database = new Database();
    $db = $database->getConnection();

    // SQL query to delete the specific record
    $query = "DELETE FROM products WHERE id = :id";
    
    try {
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $_GET['id']);

        if ($stmt->execute()) {
            // SUCCESS: Redirect to dashboard with the 'deleted' flag
            header("Location: index.php?status=deleted");
            exit();
        } else {
            // FAILURE: Something went wrong during execution
            header("Location: index.php?status=error");
            exit();
        }

    } catch (PDOException $e) {
        // ERROR: Handle database constraints (e.g., product linked to sales)
        // Log the error message in a real environment
        header("Location: index.php?status=error");
        exit();
    }
} else {
    // INVALID REQUEST: No ID found, return to safety
    header("Location: index.php");
    exit();
}