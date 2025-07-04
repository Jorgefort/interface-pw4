<?php
/**
 * Add Product Controller - BBUGTIEK Sustainable Clothing Shop
 * This controller handles adding new products to the database
 * Includes file upload, validation, and secure database operations
 */

// Include database configuration with security functions
require_once 'config/database.php';

// Initialize form data structure for clean data handling
$form_data = [
    'name' => '',
    'description' => '',
    'size' => '',
    'price' => ''
];

// Initialize message variables for user feedback
$error_message = '';
$success_message = '';

// Process form submission using POST method for security
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Safely retrieve and sanitize form data using null coalescing operator
    // trim() prevents empty space submissions and cleans input
    $form_data['name'] = trim($_POST['name'] ?? '');
    $form_data['description'] = trim($_POST['description'] ?? '');
    $form_data['size'] = $_POST['size'] ?? '';
    $form_data['price'] = trim($_POST['price'] ?? '');
    
    // Multi-criteria validation with specific error messages
    if (empty($form_data['name'])) {
        $error_message = 'Product name is required.';
    } elseif (!empty($form_data['size']) && !in_array($form_data['size'], ['XS', 'S', 'M', 'L', 'XL'])) {
        // Validate size against predefined options to prevent invalid data
        $error_message = 'Invalid size selected.';
    } elseif (!empty($form_data['price']) && (!is_numeric($form_data['price']) || $form_data['price'] < 0)) {
        // Ensure price is numeric and non-negative if provided
        $error_message = 'Price must be a valid amount.';
    } else {
        
        // Handle file upload with security checks
        $image_name = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            
            // Ensure upload directory exists with proper permissions
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Generate unique filename to prevent conflicts and security issues
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image_name = time() . '_' . uniqid() . '.' . $file_extension;
            
            // Attempt to move uploaded file to permanent location
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name)) {
                $error_message = 'Failed to upload image.';
                $image_name = null;
            }
        }
        
        // If validation passes, save to database
        if (empty($error_message)) {
            try {
                // Establish secure database connection
                $pdo = connectDatabase();
                
                // Convert price to cents for precise storage (avoids floating point issues)
                $price_in_cents = !empty($form_data['price']) ? round(floatval($form_data['price']) * 100) : null;
                
                // Prepare statement to prevent SQL injection attacks
                $stmt = $pdo->prepare("INSERT INTO producten (naam, omschrijving, maat, afbeelding, prijs) VALUES (?, ?, ?, ?, ?)");
                
                // Execute with bound parameters for security
                $stmt->execute([
                    $form_data['name'], 
                    $form_data['description'] ?: null,  // Use null for empty descriptions
                    $form_data['size'] ?: null,         // Use null for empty sizes
                    $image_name,                        // May be null if no image uploaded
                    $price_in_cents                     // May be null if no price provided
                ]);
                
                $success_message = 'Product successfully added!';
                
                // Reset form data after successful submission for clean state
                $form_data = ['name' => '', 'description' => '', 'size' => '', 'price' => ''];
                
            } catch (PDOException $e) {
                // Handle database errors with logging and user-friendly message
                error_log('Add product database error: ' . $e->getMessage());
                $error_message = 'Database error occurred. Please try again.';
            }
        }
    }
}

// Include the view
include 'add-product_view.php';
?>
                    console.log('File selected:', file.name);
                };
                reader.readAsDataURL(file);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input, textarea, select');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.classList.contains('error-input') && this.value.trim()) {
                        this.classList.remove('error-input');
                    }
                });
            });
        });
    </script>

<?php include 'includes/footer.php'; ?>
