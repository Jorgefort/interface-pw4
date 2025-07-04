<?php
// Simple database connection for manually created database
function connectDatabase() {
    try {
        // Connect to the Productvoeg database that you'll create manually in PHPStorm
        $pdo = new PDO('sqlite:database/Productvoeg.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        die('Database connection failed: ' . $e->getMessage());
    }
}

// Helper function to format price from cents to euros
function formatPrice($priceInCents) {
    if ($priceInCents === null) {
        return 'Prijs op aanvraag';
    }
    return '€ ' . number_format($priceInCents / 100, 2, ',', '.');
}
?>