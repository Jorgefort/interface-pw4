<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Sustainable Clothing</title>
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
        <h2>Add New Product</h2>
        
        <?php if (!empty($error_message)): ?>
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success_message)): ?>
            <div class="success-message">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="product-form">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" required value="<?php echo $form_data['name'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label for="price">Price ($):</label>
                <input type="number" id="price" name="price" step="0.01" required value="<?php echo $form_data['price'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4"><?php echo $form_data['description'] ?? ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="size">Size:</label>
                <select id="size" name="size">
                    <option value="">Select a size (optional)</option>
                    <option value="XS" <?php echo ($form_data['size'] ?? '') === 'XS' ? 'selected' : ''; ?>>XS</option>
                    <option value="S" <?php echo ($form_data['size'] ?? '') === 'S' ? 'selected' : ''; ?>>S</option>
                    <option value="M" <?php echo ($form_data['size'] ?? '') === 'M' ? 'selected' : ''; ?>>M</option>
                    <option value="L" <?php echo ($form_data['size'] ?? '') === 'L' ? 'selected' : ''; ?>>L</option>
                    <option value="XL" <?php echo ($form_data['size'] ?? '') === 'XL' ? 'selected' : ''; ?>>XL</option>
                </select>
            </div>

            <div class="form-group">
                <label for="image">Product Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>

            <button type="submit" class="btn-primary">Add Product</button>
        </form>

        <div class="back-link">
            <a href="products.php">← Back to Products</a>
        </div>
    </div>
</body>
</html>
