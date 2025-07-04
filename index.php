<?php
/**
 * Homepage Controller - BBUGTIEK Sustainable Clothing Shop
 * This controller sets up all data and variables for the homepage
 * Includes site information, categories, and featured products
 */

// Site configuration - basic information for homepage display
$site_name = "BBUGTIEK";
$site_tagline = "Duurzame Kleding Webshop";
$opening_date = "8 augustus 2024";
$shop_address = "Kruiskade 88, Rotterdam";

// Product categories array for navigation and organization
// In a more advanced setup, this would come from the database
$product_categories = array(
    "Dames T-shirts",
    "Heren Hoodies", 
    "Jassen",
    "Broeken",
    "Schoenen",
    "Accessoires"
);

// Featured products for homepage showcase
// Static array for demonstration - in production would be database-driven
$featured_products = array(
    array(
        "name" => "Eco T-shirt",
        "price" => "€24.99",
        "image" => "assets/Eco friendly t-shirt.jpeg"
    ),
    array(
        "name" => "Duurzame Hoodie", 
        "price" => "€49.99",
        "image" => "assets/sustainable hoodie.jpeg"
    ),
    array(
        "name" => "Hemp Broek",
        "price" => "€39.99", 
        "image" => "assets/hemp pants.jpg"
    ),
    array(
        "name" => "Vintage Denim Jacket",
        "price" => "€65.99", 
        "image" => "assets/vintage denim jacket.jpg"
    ),
    array(
        "name" => "Cotton Dress",
        "price" => "€45.99", 
        "image" => "assets/cotton dress.webp"
    ),
    array(
        "name" => "Recycled Sneakers",
        "price" => "€89.99", 
        "image" => "assets/recycled sneakers.jpg"
    )
);

// Company info
$company_info = array(
    "email" => "info@bbugtiek.nl",
    "phone" => "+31 10 123 4567",
    "hours" => "Ma-Za: 10:00-18:00"
);

// Include the view file
include 'index_view.php';
?>
