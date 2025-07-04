<?php
/**
 * Products Controller - BBUGTIEK Sustainable Clothing Shop
 * This controller handles the display of all products from the database
 * Implements sorting and error handling for a professional user experience
 */

// Include database configuration with security functions
require_once 'config/database.php';

// Page configuration variables for consistent structure
$page_title = "Producten - BBUGTIEK";
$page_heading = "Onze Producten";
$page_description = "Ontdek onze nieuwste collectie van duurzame en stijlvolle kleding.";

// Initialize variables with default values for error handling
$products = [];
$error_message = '';

try {
    // Establish secure database connection
    $pdo = connectDatabase();
    
    // Advanced SQL query with multiple criteria and sorting
    // Orders by newest first, then by name for consistent display
    // Uses multiple criteria: non-null naam AND proper ordering
    $sql = "SELECT * FROM producten 
            WHERE naam IS NOT NULL AND naam != '' 
            ORDER BY id DESC, naam ASC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // Fetch all products as associative array for easy processing
    $products = $stmt->fetchAll();
    
} catch (PDOException $e) {
    // Comprehensive error handling with logging
    error_log('Products page database error: ' . $e->getMessage());
    $error_message = 'Er is een fout opgetreden bij het laden van de producten. Probeer het later opnieuw.';
    $products = []; // Ensure empty array for safe processing
}

// Check for success messages from URL parameters (after delete/clear operations)
$show_deleted_message = isset($_GET['deleted']) && $_GET['deleted'] === '1';
$show_cleared_message = isset($_GET['cleared']) && $_GET['cleared'] === '1';

// Determine if products exist for conditional display logic
$has_products = !empty($products);

// Separate logic from view - include the presentation layer
include 'products_view.php';
?>
