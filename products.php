<?php
require_once 'config/database.php';

// Connect to database
$pdo = connectDatabase();

// Get all products from database
try {
    $stmt = $pdo->query("SELECT * FROM producten ORDER BY id DESC");
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $products = [];
    $error_message = 'Error loading products: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producten - BBUGTIEK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="index.html" class="text-2xl font-bold text-gray-900">BBUGTIEK</a>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="index.html" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <a href="products.php" class="text-gray-900 px-3 py-2 rounded-md text-sm font-medium border-b-2 border-gray-900">Producten</a>
                    <a href="add-product.php" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Product Toevoegen</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Onze Producten</h1>
                <p class="text-gray-600">Ontdek onze nieuwste collectie van duurzame en stijlvolle kleding.</p>
            </div>
            <?php if (!empty($products)): ?>
                <div class="flex space-x-3">
                    <a href="add-product.php" 
                       class="bg-gray-900 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-800 transition-colors">
                        Product Toevoegen
                    </a>
                    <a href="clear-all-products.php" 
                       class="bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-700 transition-colors">
                        Alles Verwijderen
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == '1'): ?>
            <div class="mb-6 p-4 rounded-md bg-green-50 border border-green-200">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="ml-3 text-sm text-green-800 font-medium">Product succesvol verwijderd!</p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['cleared']) && $_GET['cleared'] == '1'): ?>
            <div class="mb-6 p-4 rounded-md bg-green-50 border border-green-200">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="ml-3 text-sm text-green-800 font-medium">Alle producten succesvol verwijderd!</p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (empty($products)): ?>
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5a1 1 0 011-1h4a1 1 0 011 1z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Nog geen producten</h3>
                <p class="text-gray-500 mb-4">Er zijn nog geen producten toegevoegd aan de collectie.</p>
                <a href="add-product.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-900 hover:bg-gray-800">
                    Eerste product toevoegen
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($products as $product): ?>
                    <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                            <?php if ($product['afbeelding'] && file_exists('uploads/' . $product['afbeelding'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($product['afbeelding']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['naam']); ?>" 
                                     class="w-full h-64 object-cover">
                            <?php else: ?>
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                    <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-gray-900 mb-2">
                                <?php echo htmlspecialchars($product['naam']); ?>
                            </h3>
                            <?php if ($product['omschrijving']): ?>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                    <?php echo htmlspecialchars(substr($product['omschrijving'], 0, 100)); ?>
                                    <?php if (strlen($product['omschrijving']) > 100) echo '...'; ?>
                                </p>
                            <?php endif; ?>
                            <div class="flex justify-between items-center">
                                <div>
                                    <?php if ($product['maat']): ?>
                                        <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full mb-2">
                                            Maat: <?php echo htmlspecialchars($product['maat']); ?>
                                        </span>
                                    <?php endif; ?>
                                    <div class="font-bold text-lg text-gray-900">
                                        <?php echo formatPrice($product['prijs']); ?>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="product-detail.php?id=<?php echo $product['id']; ?>" 
                                       class="bg-gray-900 text-white px-3 py-2 rounded-md text-xs font-medium hover:bg-gray-800 transition-colors">
                                        Bekijk
                                    </a>
                                    <a href="delete-product.php?id=<?php echo $product['id']; ?>" 
                                       class="bg-red-600 text-white px-3 py-2 rounded-md text-xs font-medium hover:bg-red-700 transition-colors"
                                       title="Product verwijderen">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-gray-600">&copy; 2024 BBUGTIEK. Alle rechten voorbehouden.</p>
            </div>
        </div>
    </footer>
</body>
</html>
