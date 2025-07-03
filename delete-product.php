<?php
require_once 'config/database.php';

$message = '';
$message_type = 'info';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: products.php');
    exit();
}

$product_id = (int)$_GET['id'];

$database = new Database();
$pdo = $database->getConnection();

try {
    $stmt = $pdo->prepare("SELECT * FROM producten WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    
    if (!$product) {
        header('Location: products.php');
        exit();
    }
} catch (PDOException $e) {
    header('Location: products.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    try {
        if ($product['afbeelding'] && file_exists('uploads/' . $product['afbeelding'])) {
            unlink('uploads/' . $product['afbeelding']);
        }
        
        $stmt = $pdo->prepare("DELETE FROM producten WHERE id = ?");
        $stmt->execute([$product_id]);
        
        header('Location: products.php?deleted=1');
        exit();
    } catch (PDOException $e) {
        $message = 'Error deleting product: ' . $e->getMessage();
        $message_type = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Verwijderen - BBUGTIEK</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

    <!-- Main Content -->
    <main class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Product Verwijderen</h1>
                <p class="text-gray-600">Weet je zeker dat je dit product wilt verwijderen?</p>
            </div>

            <?php if ($message): ?>
                <div class="mb-6 p-4 rounded-md <?php echo $message_type === 'error' ? 'bg-red-50 border border-red-200' : 'bg-blue-50 border border-blue-200'; ?>">
                    <p class="<?php echo $message_type === 'error' ? 'text-red-800' : 'text-blue-800'; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </p>
                </div>
            <?php endif; ?>

            <!-- Product Details -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <div class="flex items-center space-x-4">
                    <?php if ($product['afbeelding'] && file_exists('uploads/' . $product['afbeelding'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($product['afbeelding']); ?>" 
                             alt="<?php echo htmlspecialchars($product['naam']); ?>" 
                             class="w-20 h-20 object-cover rounded-lg">
                    <?php else: ?>
                        <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            <?php echo htmlspecialchars($product['naam']); ?>
                        </h3>
                        <?php if ($product['omschrijving']): ?>
                            <p class="text-gray-600 mt-1">
                                <?php echo htmlspecialchars(substr($product['omschrijving'], 0, 100)); ?>
                                <?php if (strlen($product['omschrijving']) > 100) echo '...'; ?>
                            </p>
                        <?php endif; ?>
                        <div class="flex items-center space-x-4 mt-2">
                            <?php if ($product['maat']): ?>
                                <span class="inline-block bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded-full">
                                    Maat: <?php echo htmlspecialchars($product['maat']); ?>
                                </span>
                            <?php endif; ?>
                            <span class="font-medium text-gray-900">
                                <?php 
                                if ($product['prijs'] === null) {
                                    echo 'Prijs op aanvraag';
                                } else {
                                    echo '€ ' . number_format($product['prijs'] / 100, 2, ',', '.');
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Warning -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-8">
                <div class="flex">
                    <svg class="h-5 w-5 text-yellow-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Let op!</h3>
                        <p class="text-sm text-yellow-700 mt-1">
                            Deze actie kan niet ongedaan worden gemaakt. Het product en eventuele bijbehorende afbeelding worden permanent verwijderd.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-4">
                <form method="POST" class="flex-1">
                    <button type="submit" name="confirm_delete" 
                            class="w-full bg-red-600 text-white px-4 py-3 rounded-md font-medium hover:bg-red-700 transition-colors"
                            onclick="return confirm('Weet je zeker dat je dit product wilt verwijderen?')">
                        Ja, Verwijder Product
                    </button>
                </form>
                <a href="products.php" 
                   class="flex-1 bg-gray-300 text-gray-700 px-4 py-3 rounded-md font-medium text-center hover:bg-gray-400 transition-colors">
                    Annuleren
                </a>
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
