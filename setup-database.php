<?php
require_once 'config/database.php';

$message = '';
$message_type = 'info';

try {
    $database = new Database();
    $pdo = $database->getConnection();
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM producten");
    $count = $stmt->fetch()['count'];
    
    if ($count > 0) {
        $message = "Database already contains {$count} products. Skipping sample data insertion.";
        $message_type = 'warning';
    } else {
        $sample_products = [
            [
                'naam' => 'Vintage Denim Jacket',
                'omschrijving' => 'Klassieke vintage denim jasje gemaakt van 100% biologisch katoen. Perfect voor een casual look in elke seizoen.',
                'maat' => 'M',
                'afbeelding' => 'vintage denim jacket.jpg',
                'prijs' => 7995
            ],
            [
                'naam' => 'Eco-Friendly T-Shirt',
                'omschrijving' => 'Zachte biologische katoenen t-shirt met minimalistisch design. Gemaakt onder eerlijke arbeidsomstandigheden.',
                'maat' => 'L',
                'afbeelding' => 'Eco friendly t-shirt.jpeg',
                'prijs' => 2995
            ],
            [
                'naam' => 'Sustainable Hoodie',
                'omschrijving' => 'Comfortabele hoodie gemaakt van gerecyclede materialen. Warm, stijlvol en goed voor het milieu.',
                'maat' => 'S',
                'afbeelding' => 'sustainable hoodie.jpeg',
                'prijs' => 5995
            ],
            [
                'naam' => 'Organic Cotton Dress',
                'omschrijving' => 'Elegante jurk van 100% biologisch katoen. Tijdloos design dat perfect is voor zowel kantoor als casual gelegenheden.',
                'maat' => 'M',
                'afbeelding' => 'cotton dress.webp',
                'prijs' => 8995
            ],
            [
                'naam' => 'Recycled Sneakers',
                'omschrijving' => 'Comfortabele sneakers gemaakt van gerecyclede oceaanplastics. Stijlvol, duurzaam en goed voor je voeten.',
                'maat' => null,
                'afbeelding' => 'recycled sneakers.jpg',
                'prijs' => 12995
            ],
            [
                'naam' => 'Hemp Pants',
                'omschrijving' => 'Natuurlijke hennep broek met moderne pasvorm. Ademend, duurzaam en ideaal voor de moderne consument.',
                'maat' => 'XL',
                'afbeelding' => 'hemp pants.jpg',
                'prijs' => null
            ]
        ];
        
        $stmt = $pdo->prepare("INSERT INTO producten (naam, omschrijving, maat, afbeelding, prijs) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($sample_products as $product) {
            $stmt->execute([
                $product['naam'],
                $product['omschrijving'],
                $product['maat'],
                $product['afbeelding'],
                $product['prijs']
            ]);
        }
        
        $message = 'Successfully inserted ' . count($sample_products) . ' sample products';
        $message_type = 'success';
    }
} catch (Exception $e) {
    $message = 'Error: ' . $e->getMessage();
    $message_type = 'error';
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - BBUGTIEK</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">BBUGTIEK Database Setup</h1>
            <p class="text-gray-600">Initialize the database with sample products</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <?php if ($message_type === 'success'): ?>
                <div class="bg-green-50 border border-green-200 rounded-md p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">Success!</h3>
                            <div class="mt-2 text-sm text-green-700">
                                <p><?php echo htmlspecialchars($message); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif ($message_type === 'warning'): ?>
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Notice</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p><?php echo htmlspecialchars($message); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif ($message_type === 'error'): ?>
                <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Error</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p><?php echo htmlspecialchars($message); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="products.php" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    View Products
                </a>
                <a href="add-product.php" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Add Product
                </a>
                <a href="index.html" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
