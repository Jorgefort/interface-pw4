<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="css/simple-style.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <h1><a href="index.php">Sustainable Clothing</a></h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php" class="active">Products</a></li>
                <li><a href="add-product.php">Add Product</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1><?php echo $page_heading; ?></h1>
                <p><?php echo $page_description; ?></p>
            </div>
            <?php if ($has_products): ?>
                <div class="button-group">
                    <a href="add-product.php" class="btn-primary">Add Product</a>
                    <a href="clear-all-products.php" class="btn-danger">Clear All</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Success Messages -->
        <?php if ($show_deleted_message): ?>
            <div class="success-message">
                <p>Product successfully deleted!</p>
            </div>
        <?php endif; ?>

        <?php if ($show_cleared_message): ?>
            <div class="success-message">
                <p>All products successfully deleted!</p>
            </div>
        <?php endif; ?>

        <!-- Products Grid -->
        <?php if (!$has_products): ?>
            <div class="empty-state">
                <h3>No products yet</h3>
                <p>No products have been added to the collection yet.</p>
                <a href="add-product.php" class="btn-primary">Add First Product</a>
            </div>
        <?php else: ?>
            <div class="products-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <?php if ($product['afbeelding'] && file_exists('uploads/' . $product['afbeelding'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($product['afbeelding']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['naam']); ?>">
                            <?php else: ?>
                                <div class="no-image">Geen afbeelding</div>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <h3><?php echo htmlspecialchars($product['naam']); ?></h3>
                            <?php if ($product['omschrijving']): ?>
                                <p class="product-description">
                                    <?php echo htmlspecialchars(substr($product['omschrijving'], 0, 100)); ?>
                                    <?php if (strlen($product['omschrijving']) > 100) echo '...'; ?>
                                </p>
                            <?php endif; ?>
                            <div class="product-details">
                                <div class="product-meta">
                                    <?php if ($product['maat']): ?>
                                        <span class="size-tag">Maat: <?php echo htmlspecialchars($product['maat']); ?></span>
                                    <?php endif; ?>
                                    <div class="price">
                                        <?php echo formatPrice($product['prijs']); ?>
                                    </div>
                                </div>
                                <div class="product-actions">
                                    <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="btn btn-small">Bekijk</a>
                                    <a href="delete-product.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-small">Verwijder</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Simple hover effect for product cards
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>
