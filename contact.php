<?php
/**
 * Contact Controller - BBUGTIEK Sustainable Clothing Shop
 * This controller handles the contact form with advanced validation
 * Includes Dutch field names and complex validation patterns as required
 */

// Initialize form data array with all Dutch field names from assignment
$form_data = [
    'voornaam' => '',
    'achternaam' => '',
    'telefoonnummer' => '',
    'email' => '',
    'adres' => '',
    'postcode' => '',
    'woonplaats' => '',
    'vraag' => ''
];

// Initialize message variables for user feedback
$error_message = '';
$success_message = '';

// Process form submission using POST method for security
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Safely retrieve and sanitize all form data using null coalescing operator
    // trim() removes whitespace to prevent empty space submissions
    $form_data['voornaam'] = trim($_POST['voornaam'] ?? '');
    $form_data['achternaam'] = trim($_POST['achternaam'] ?? '');
    $form_data['telefoonnummer'] = trim($_POST['telefoonnummer'] ?? '');
    $form_data['email'] = trim($_POST['email'] ?? '');
    $form_data['adres'] = trim($_POST['adres'] ?? '');
    $form_data['postcode'] = trim($_POST['postcode'] ?? '');
    $form_data['woonplaats'] = trim($_POST['woonplaats'] ?? '');
    $form_data['vraag'] = trim($_POST['vraag'] ?? '');
    
    // Advanced server-side validation with multiple criteria
    // Each validation stops at first error for better user experience
    if (empty($form_data['achternaam'])) {
        $error_message = 'Achternaam is verplicht.';
    } elseif (empty($form_data['telefoonnummer'])) {
        $error_message = 'Telefoonnummer is verplicht.';
    } elseif (!preg_match('/^[0-9+\-\s\(\)]+$/', $form_data['telefoonnummer'])) {
        // Regex pattern allows: digits, +, -, spaces, parentheses for international formats
        $error_message = 'Voer een geldig telefoonnummer in.';
    } elseif (empty($form_data['email'])) {
        $error_message = 'E-mailadres is verplicht.';
    } elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
        // PHP built-in email validation filter for RFC compliance
        $error_message = 'Voer een geldig e-mailadres in.';
    } elseif (!empty($form_data['postcode']) && !preg_match('/^[1-9][0-9]{3}\s?[A-Za-z]{2}$/', $form_data['postcode'])) {
        // Dutch postcode pattern: 4 digits (first not 0) + optional space + 2 letters
        $error_message = 'Voer een geldige Nederlandse postcode in (bijv. 1234AB).';
    } elseif (empty($form_data['vraag'])) {
        $error_message = 'Het vraag-veld is verplicht.';
    } else {
        // All validation passed - process form successfully
        // In production: save to database or send email notification
        $success_message = 'Bedankt voor uw bericht! We nemen spoedig contact met u op.';
        
        // Reset form data after successful submission using array_fill_keys for efficiency
        $form_data = array_fill_keys(array_keys($form_data), '');
    }
}

// Include the view
include 'contact_view.php';
