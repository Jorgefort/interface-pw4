<?php
/**
 * Clear All Products Controller - BBUGTIEK Sustainable Clothing Shop
 * This controller handles bulk deletion of all products with confirmation
 * Includes file cleanup and database maintenance operations
 */

// Include database configuration with security functions
require_once 'config/database.php';

// Initialize message variables for user feedback
$message = '';
$message_type = 'info';

// Process clear all products confirmation from POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_clear_all'])) {
    try {
        // Establish secure database connection
        $pdo = connectDatabase();
        
        // Retrieve all product images for file cleanup
        // Only select products that have image files to optimize performance
        $stmt = $pdo->query("SELECT afbeelding FROM producten WHERE afbeelding IS NOT NULL");
        $products = $stmt->fetchAll();
        
        // Clean up all associated image files before database deletion
        // This prevents orphaned files remaining after database cleanup
        foreach ($products as $product) {
            if ($product['afbeelding'] && file_exists('uploads/' . $product['afbeelding'])) {
                unlink('uploads/' . $product['afbeelding']);
            }
        }
        
        // Delete all product records from database
        $pdo->exec("DELETE FROM producten");
        
        // Reset auto-increment counter for clean ID numbering
        // This ensures new products start from ID 1 again
        $pdo->exec("DELETE FROM sqlite_sequence WHERE name='producten'");
        
        // Redirect to products page with success message
        header('Location: products.php?cleared=1');
        exit();
        
    } catch (PDOException $e) {
        // Handle bulk deletion errors with logging and user-friendly message
        error_log('Clear all products error: ' . $e->getMessage());
        $message = 'Error clearing products. Please try again.';
        $message_type = 'error';
    }
}

// Get current product count for display purposes
try {
    $pdo = connectDatabase();
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM producten");
    $product_count = $stmt->fetch()['count'];
} catch (PDOException $e) {
    $product_count = 0;
}

// Include the view
include 'clear-all-products_view.php';
?>

