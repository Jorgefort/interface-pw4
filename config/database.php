<?php
/**
 * Database configuration for BBUGTIEK sustainable clothing shop
 * This file contains database connection logic and helper functions
 */

/**
 * Establishes a connection to the SQLite database
 * Uses PDO for secure database operations with prepared statements
 * @return PDO Database connection object
 * @throws PDOException if connection fails
 */
function connectDatabase() {
    try {
        // Create PDO connection to SQLite database with proper configuration
        $pdo = new PDO('sqlite:database/producten.db');
        
        // Set error mode to exception for better error handling
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Set default fetch mode to associative array for easier data handling
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        return $pdo;
    } catch (PDOException $e) {
        // Log error and display user-friendly message
        error_log('Database connection error: ' . $e->getMessage());
        die('Database connection failed. Please try again later.');
    }
}

/**
 * Formats price from cents (integer) to euros with proper formatting
 * Prevents division by zero and handles null values
 * @param int|null $priceInCents Price stored as integer in cents
 * @return string Formatted price string (e.g., "€24.99")
 */
function formatPrice($priceInCents) {
    // Handle null or empty price values
    if ($priceInCents === null || $priceInCents === '') {
        return 'Prijs op aanvraag';
    }
    
    // Convert cents to euros and format with 2 decimal places
    return '€' . number_format($priceInCents / 100, 2, ',', '.');
}
?>