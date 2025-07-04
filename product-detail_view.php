<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['naam']); ?> - Sustainable Clothing</title>
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
        <div class="breadcrumb">
            <a href="index.php">Home</a> > 
            <a href="products.php">Products</a> > 
            <?php echo htmlspecialchars($product['naam']); ?>
        </div>

        <div class="product-detail">
            <div class="product-image">
                <?php if ($product['afbeelding'] && file_exists('uploads/' . $product['afbeelding'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($product['afbeelding']); ?>" 
                         alt="<?php echo htmlspecialchars($product['naam']); ?>">
                <?php else: ?>
                    <div class="no-image">No Image Available</div>
                <?php endif; ?>
            </div>

            <div class="product-info">
                <h1><?php echo htmlspecialchars($product['naam']); ?></h1>
                
                <p class="price"><?php echo formatPrice($product['prijs']); ?></p>

                <?php if ($product['omschrijving']): ?>
                    <div class="description">
                        <h3>Description</h3>
                        <p><?php echo nl2br(htmlspecialchars($product['omschrijving'])); ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($product['maat']): ?>
                    <div class="size">
                        <strong>Size:</strong> <?php echo htmlspecialchars($product['maat']); ?>
                    </div>
                <?php endif; ?>

                <div class="product-actions">
                    <a href="products.php" class="btn-secondary">← Back to Products</a>
                    <a href="delete-product.php?id=<?php echo $product['id']; ?>" class="btn-danger">Delete Product</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
