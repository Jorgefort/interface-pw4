<?php
/**
 * Database Setup Script - BBUGTIEK Sustainable Clothing Shop
 * This script initializes the SQLite database with proper schema and sample data
 * Run this once to set up the complete database structure
 */

echo "Setting up the sustainable clothing database...\n";

// Ensure database directory exists with proper permissions
if (!is_dir('database')) {
    mkdir('database', 0777, true);
    echo "Created database directory.\n";
}

// Define database file path for consistent access
$dbPath = 'database/producten.db';

try {
    // Create SQLite database connection with error handling
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create the products table with proper constraints and data types
    // Uses INTEGER for price (stored in cents) to avoid floating point issues
    // Includes CHECK constraint for size validation at database level
    $createTable = "
    CREATE TABLE IF NOT EXISTS producten (
        id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
        naam TEXT NOT NULL,
        omschrijving TEXT,
        maat TEXT CHECK(maat IN ('XS', 'S', 'M', 'L', 'XL')),
        afbeelding TEXT,
        prijs INTEGER
    )";
    
    $pdo->exec($createTable);
    echo "Created producten table.\n";
    
    // Check if table is empty before adding sample data
    // Prevents duplicate data on multiple script runs
    $stmt = $pdo->query("SELECT COUNT(*) FROM producten");
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        // Sample products array with realistic sustainable clothing items
        // Prices stored in cents (e.g., 7995 = €79.95) for precise calculations
        $sampleProducts = [
            ['Vintage Denim Jacket', 'Classic vintage denim jacket made from 100% organic cotton.', 'M', 'vintage denim jacket.jpg', 7995],
            ['Eco T-Shirt', 'Soft organic cotton t-shirt with minimalist design.', 'L', 'Eco friendly t-shirt.jpeg', 2995],
            ['Sustainable Hoodie', 'Comfortable hoodie made from recycled materials.', 'S', 'sustainable hoodie.jpeg', 5995],
            ['Cotton Dress', 'Elegant dress made from 100% organic cotton.', 'M', 'cotton dress.webp', 8995],
            ['Recycled Sneakers', 'Comfortable sneakers made from recycled materials.', NULL, 'recycled sneakers.jpg', 12995],
            ['Hemp Pants', 'Natural hemp pants with modern fit.', 'XL', 'hemp pants.jpg', 4995]
        ];
        
        // Use prepared statement for secure bulk insertion
        $stmt = $pdo->prepare("INSERT INTO producten (naam, omschrijving, maat, afbeelding, prijs) VALUES (?, ?, ?, ?, ?)");
        
        // Insert each sample product with bound parameters
        foreach ($sampleProducts as $product) {
            $stmt->execute($product);
        }
        
        echo "Added " . count($sampleProducts) . " sample products.\n";
    } else {
        echo "Database already contains $count products.\n";
    }
    
    // Create uploads directory
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
        echo "Created uploads directory.\n";
    }
    
    echo "Database setup complete!\n";
    echo "You can now use the application at: http://localhost:8000/\n";
    
} catch (PDOException $e) {
    echo "Error setting up database: " . $e->getMessage() . "\n";
}
?>
