<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clear All Products - Sustainable Clothing</title>
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
        <h2>Clear All Products</h2>
        
        <?php if (!empty($message)): ?>
            <div class="<?php echo $message_type === 'error' ? 'error-message' : 'success-message'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="clear-all-container">
            <div class="product-count">
                <h3>Current Status</h3>
                <p class="count-number"><?php echo $product_count; ?></p>
                <p>products in the database</p>
            </div>

            <?php if ($product_count === 0): ?>
                <div class="no-products">
                    <p>There are no products to delete.</p>
                    <a href="products.php" class="btn-secondary">← Back to Products</a>
                </div>
            <?php else: ?>
                <div class="warning-box">
                    <h3>⚠️ WARNING!</h3>
                    <p>This action will:</p>
                    <ul>
                        <li>Permanently delete all <?php echo $product_count; ?> products</li>
                        <li>Delete all associated images</li>
                        <li>Reset the product ID counter</li>
                    </ul>
                    <p><strong>This action CANNOT be undone!</strong></p>
                </div>

                <div class="clear-all-actions">
                    <form method="POST">
                        <button type="submit" name="confirm_clear_all" class="btn-danger-large" 
                                onclick="return confirm('FINAL WARNING: This will permanently delete all <?php echo $product_count; ?> products. Are you sure?')">
                            Yes, Delete All Products
                        </button>
                    </form>
                    <a href="products.php" class="btn-secondary">Cancel</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
