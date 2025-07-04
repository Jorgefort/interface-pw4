<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product - Sustainable Clothing</title>
    <link rel="stylesheet" href="css/simple-style.css">
</head>
<body>
    <nav>
        <div class="nav-container">
            <h1><a href="index.php">Sustainable Clothing</a></h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="add-product.php">Add Product</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2>Delete Product</h2>
        
        <?php if (!empty($message)): ?>
            <div class="<?php echo $message_type === 'error' ? 'error-message' : 'success-message'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="delete-confirmation">
            <p><strong>Are you sure you want to delete this product?</strong></p>
            
            <div class="product-preview">
                <div class="preview-image">
                    <?php if ($product['afbeelding'] && file_exists('uploads/' . $product['afbeelding'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($product['afbeelding']); ?>" 
                             alt="<?php echo htmlspecialchars($product['naam']); ?>">
                    <?php else: ?>
                        <div class="no-image-small">No Image</div>
                    <?php endif; ?>
                </div>
                
                <div class="preview-details">
                    <h3><?php echo htmlspecialchars($product['naam']); ?></h3>
                    <p class="price"><?php echo formatPrice($product['prijs']); ?></p>
                    
                    <?php if ($product['omschrijving']): ?>
                        <p class="description">
                            <?php echo htmlspecialchars(substr($product['omschrijving'], 0, 100)); ?>
                            <?php if (strlen($product['omschrijving']) > 100) echo '...'; ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php if ($product['maat']): ?>
                        <p class="size">Size: <?php echo htmlspecialchars($product['maat']); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="warning-box">
                <p><strong>Warning:</strong> This action cannot be undone. The product and its image will be permanently deleted.</p>
            </div>

            <div class="delete-actions">
                <form method="POST">
                    <button type="submit" name="confirm_delete" class="btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this product?')">
                        Yes, Delete Product
                    </button>
                </form>
                <a href="products.php" class="btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
</body>
</html>
