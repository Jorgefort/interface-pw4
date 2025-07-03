<?php
require_once 'config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: products.php');
    exit;
}

$product_id = (int) $_GET['id'];

$database = new Database();
$pdo = $database->getConnection();

try {
    $stmt = $pdo->prepare("SELECT * FROM producten WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
} catch (PDOException $e) {
    $product = null;
    $error_message = 'Error fetching product: ' . $e->getMessage();
}

if (!$product) {
    header('Location: products.php');
    exit;
}

function formatPrice($priceInCents) {
    if ($priceInCents === null) return 'Prijs op aanvraag';
    return '€ ' . number_format($priceInCents / 100, 2, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['naam']); ?> - BBUGTIEK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .product-image {
            max-height: 600px;
            object-fit: contain;
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
                    <a href="products.php" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Producten</a>
                    <a href="add-product.php" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Product Toevoegen</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
                <li>
                    <a href="index.html" class="text-gray-400 hover:text-gray-500">Home</a>
                </li>
                <li>
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </li>
                <li>
                    <a href="products.php" class="text-gray-400 hover:text-gray-500">Producten</a>
                </li>
                <li>
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </li>
                <li>
                    <span class="text-gray-500"><?php echo htmlspecialchars($product['naam']); ?></span>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
            <!-- Product Image -->
            <div class="flex flex-col-reverse">
                <div class="w-full aspect-w-1 aspect-h-1">
                    <?php if ($product['afbeelding'] && file_exists('uploads/' . $product['afbeelding'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($product['afbeelding']); ?>" 
                             alt="<?php echo htmlspecialchars($product['naam']); ?>" 
                             class="w-full h-auto product-image bg-white rounded-lg shadow-lg">
                    <?php else: ?>
                        <div class="w-full h-96 bg-gray-200 rounded-lg shadow-lg flex items-center justify-center">
                            <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Product Details -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                    <?php echo htmlspecialchars($product['naam']); ?>
                </h1>

                <div class="mt-3">
                    <p class="text-3xl tracking-tight text-gray-900 font-semibold">
                        <?php echo formatPrice($product['prijs']); ?>
                    </p>
                </div>

                <?php if ($product['maat']): ?>
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-900">Maat</h3>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <?php echo htmlspecialchars($product['maat']); ?>
                            </span>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($product['omschrijving']): ?>
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-900">Productbeschrijving</h3>
                        <div class="mt-2 prose prose-sm text-gray-500">
                            <p><?php echo nl2br(htmlspecialchars($product['omschrijving'])); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Product Details -->
                <div class="mt-8 border-t border-gray-200 pt-8">
                    <h3 class="text-sm font-medium text-gray-900">Product Details</h3>
                    <div class="mt-4 space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Product ID</span>
                            <span class="text-sm font-medium text-gray-900">#<?php echo $product['id']; ?></span>
                        </div>
                        <?php if ($product['maat']): ?>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Beschikbare maat</span>
                                <span class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($product['maat']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-10 flex flex-col sm:flex-row gap-4">
                    <a href="products.php" 
                       class="flex-1 bg-gray-100 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Terug naar producten
                    </a>
                    <button type="button" 
                            class="flex-1 bg-gray-900 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                            onclick="alert('Bestel functionaliteit wordt binnenkort toegevoegd!')">
                        In winkelwagen
                    </button>
                </div>

                <!-- Share -->
                <div class="mt-6 border-t border-gray-200 pt-6">
                    <h3 class="text-sm font-medium text-gray-900">Delen</h3>
                    <div class="mt-2 flex space-x-4">
                        <button type="button" 
                                class="text-gray-400 hover:text-gray-500"
                                onclick="navigator.share ? navigator.share({title: '<?php echo htmlspecialchars($product['naam']); ?>', url: window.location.href}) : alert('Link gekopieerd naar klembord!')">
                            <span class="sr-only">Delen</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
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
