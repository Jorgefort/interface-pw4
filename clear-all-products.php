<?php
require_once 'config/database.php';

$message = '';
$message_type = 'info';

$database = new Database();
$pdo = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_clear_all'])) {
    try {
        $stmt = $pdo->query("SELECT afbeelding FROM producten WHERE afbeelding IS NOT NULL");
        $products = $stmt->fetchAll();
        
        foreach ($products as $product) {
            if ($product['afbeelding'] && file_exists('uploads/' . $product['afbeelding'])) {
                unlink('uploads/' . $product['afbeelding']);
            }
        }
        
        $pdo->exec("DELETE FROM producten");
        
        $pdo->exec("DELETE FROM sqlite_sequence WHERE name='producten'");
        
        header('Location: products.php?cleared=1');
        exit();
    } catch (PDOException $e) {
        $message = 'Error clearing products: ' . $e->getMessage();
        $message_type = 'error';
    }
}

try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM producten");
    $product_count = $stmt->fetch()['count'];
} catch (PDOException $e) {
    $product_count = 0;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alle Producten Verwijderen - BBUGTIEK</title>
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
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Alle Producten Verwijderen</h1>
                <p class="text-gray-600">Weet je zeker dat je alle producten wilt verwijderen?</p>
            </div>

            <?php if ($message): ?>
                <div class="mb-6 p-4 rounded-md <?php echo $message_type === 'error' ? 'bg-red-50 border-red-200' : 'bg-blue-50 border-blue-200'; ?>">
                    <p class="<?php echo $message_type === 'error' ? 'text-red-800' : 'text-blue-800'; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </p>
                </div>
            <?php endif; ?>

            <!-- Product Count -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8 text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Huidige Status</h3>
                <p class="text-3xl font-bold text-gray-900"><?php echo $product_count; ?></p>
                <p class="text-gray-600">producten in de database</p>
            </div>

            <?php if ($product_count === 0): ?>
                <div class="text-center py-8">
                    <p class="text-gray-600 mb-4">Er zijn geen producten om te verwijderen.</p>
                    <a href="products.php" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-md font-medium hover:bg-gray-400 transition-colors">
                        Terug naar Producten
                    </a>
                </div>
            <?php else: ?>
                <!-- Warning -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-8">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">WAARSCHUWING!</h3>
                            <div class="text-sm text-red-700 mt-1">
                                <p class="mb-2">Deze actie zal:</p>
                                <ul class="list-disc list-inside">
                                    <li>Alle <?php echo $product_count; ?> producten permanent verwijderen</li>
                                    <li>Alle bijbehorende afbeeldingen verwijderen</li>
                                    <li>De product-ID teller opnieuw instellen</li>
                                </ul>
                                <p class="mt-2 font-medium">Deze actie kan NIET ongedaan worden gemaakt!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-4">
                    <form method="POST" class="flex-1">
                        <button type="submit" name="confirm_clear_all" 
                                class="w-full bg-red-600 text-white px-4 py-3 rounded-md font-medium hover:bg-red-700 transition-colors"
                                onclick="return confirm('LAATSTE WAARSCHUWING: Dit zal alle <?php echo $product_count; ?> producten permanent verwijderen. Weet je het zeker?')">
                            Ja, Verwijder Alle Producten
                        </button>
                    </form>
                    <a href="products.php" 
                       class="flex-1 bg-gray-300 text-gray-700 px-4 py-3 rounded-md font-medium text-center hover:bg-gray-400 transition-colors">
                        Annuleren
                    </a>
                </div>
            <?php endif; ?>
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
