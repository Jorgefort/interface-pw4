<?php
/**
 * Delete Product Controller - BBUGTIEK Sustainable Clothing Shop
 * This controller handles safe product deletion with confirmation
 * Includes file cleanup and proper error handling
 */

// Include database configuration with security functions
require_once 'config/database.php';

// Initialize message variables for user feedback
$message = '';
$message_type = '';

// Validate product ID parameter from URL for security
// Ensure ID exists and is numeric to prevent manipulation
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirect if invalid ID provided
    header('Location: products.php');
    exit();
}

// Cast to integer for type safety
$product_id = (int)$_GET['id'];

// Retrieve product details and handle deletion process
try {
    // Establish secure database connection
    $pdo = connectDatabase();
    
    // Fetch product details using prepared statement for security
    $stmt = $pdo->prepare("SELECT * FROM producten WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    
    // Redirect if product doesn't exist
    if (!$product) {
        header('Location: products.php');
        exit();
    }
    
    // Process deletion confirmation from POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
        try {
            // Clean up associated image file if it exists
            // Check both database record and actual file existence
            if ($product['afbeelding'] && file_exists('uploads/' . $product['afbeelding'])) {
                unlink('uploads/' . $product['afbeelding']);
            }
            
            // Delete product record from database using prepared statement
            $stmt = $pdo->prepare("DELETE FROM producten WHERE id = ?");
            $stmt->execute([$product_id]);
            
            // Redirect to products page with success message
            header('Location: products.php?deleted=1');
            exit();
            
        } catch (PDOException $e) {
            // Handle deletion errors with user-friendly message
            error_log('Product deletion error: ' . $e->getMessage());
            $message = 'Error deleting product. Please try again.';
            $message_type = 'error';
        }
    }
    
} catch (PDOException $e) {
    // Handle database connection or query errors
    error_log('Delete product database error: ' . $e->getMessage());
    $message = 'Database error occurred. Please try again.';
    $message_type = 'error';
}

// Include the view
include 'delete-product_view.php';
?>

