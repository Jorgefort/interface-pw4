<?php
/**
 * Product Detail Controller - BBUGTIEK Sustainable Clothing Shop
 * This controller displays individual product details from the database
 * Includes security checks and error handling for safe product viewing
 */

// Include database configuration with security functions
require_once 'config/database.php';

// Validate product ID parameter from URL for security
// Check existence and ensure it's numeric to prevent SQL injection
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirect to products page if invalid ID provided
    header('Location: products.php');
    exit;
}

// Cast to integer for type safety and security
$product_id = (int) $_GET['id'];
$error_message = '';

// Retrieve product from database with error handling
try {
    // Establish secure database connection
    $pdo = connectDatabase();
    
    // Use prepared statement to prevent SQL injection
    $stmt = $pdo->prepare("SELECT * FROM producten WHERE id = ?");
    $stmt->execute([$product_id]);
    
    // Fetch single product record
    $product = $stmt->fetch();
    
} catch (PDOException $e) {
    // Handle database errors gracefully
    error_log('Product detail database error: ' . $e->getMessage());
    $product = null;
    $error_message = 'Error loading product details.';
}

// Redirect if product not found in database
// This prevents displaying empty pages for non-existent products
if (!$product) {
    header('Location: products.php');
    exit;
}

// Include the view
include 'product-detail_view.php';
?>

