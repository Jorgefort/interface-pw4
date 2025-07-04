<?php
require_once 'config/database.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = trim($_POST['naam'] ?? '');
    $omschrijving = trim($_POST['omschrijving'] ?? '');
    $maat = $_POST['maat'] ?? '';
    $prijs = trim($_POST['prijs'] ?? '');
    
    // Simple validation
    if (empty($naam)) {
        $errors[] = 'Productnaam is verplicht.';
    }
    
    if (!empty($maat) && !in_array($maat, ['XS', 'S', 'M', 'L', 'XL'])) {
        $errors[] = 'Ongeldige maat geselecteerd.';
    }
    
    if (!empty($prijs) && (!is_numeric($prijs) || $prijs < 0)) {
        $errors[] = 'Prijs moet een geldig bedrag zijn.';
    }
    
    // If no errors, save to database
    if (empty($errors)) {
        try {
            $pdo = connectDatabase();
            $prijs_in_centen = !empty($prijs) ? round(floatval($prijs) * 100) : null;
            
            $stmt = $pdo->prepare("INSERT INTO producten (naam, omschrijving, maat, prijs) VALUES (?, ?, ?, ?)");
            $stmt->execute([$naam, $omschrijving, $maat ?: null, $prijs_in_centen]);
            
            $success = true;
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
            
            if (!in_array($file_type, $allowed_types)) {
                $errors['afbeelding'] = 'Alleen JPEG, PNG, GIF en WebP afbeeldingen zijn toegestaan.';
            } elseif ($file['size'] > 5 * 1024 * 1024) {
                $errors['afbeelding'] = 'Afbeelding mag maximaal 5MB groot zijn.';
            } else {
                $upload_dir = 'uploads';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $uploaded_filename = uniqid('product_') . '.' . $file_extension;
                $upload_path = $upload_dir . '/' . $uploaded_filename;
                
                if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
                    $errors['afbeelding'] = 'Er is een fout opgetreden bij het opslaan van de afbeelding.';
                    $uploaded_filename = null;
                }
            }
        }
    }
    
    if (empty($errors)) {
        try {
            $database = new Database();
            $pdo = $database->getConnection();
            
            $price_in_cents = null;
            if (!empty($form_data['prijs'])) {
                $price_in_cents = (int) round(floatval($form_data['prijs']) * 100);
            }
            
            $stmt = $pdo->prepare("INSERT INTO producten (naam, omschrijving, maat, afbeelding, prijs) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $form_data['naam'],
                !empty($form_data['omschrijving']) ? $form_data['omschrijving'] : null,
                !empty($form_data['maat']) ? $form_data['maat'] : null,
                $uploaded_filename,
                $price_in_cents
            ]);
            
            $success = true;
            
            $form_data = [
                'naam' => '',
                'omschrijving' => '',
                'maat' => '',
                'prijs' => ''
            ];
            
        } catch (PDOException $e) {
            $errors['database'] = 'Er is een fout opgetreden bij het opslaan van het product.';
            error_log('Database error: ' . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Toevoegen - BBUGTIEK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .form-input {
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-input:focus {
            outline: none;
            border-color: #374151;
            box-shadow: 0 0 0 3px rgba(55, 65, 81, 0.1);
        }
        .error-input {
            border-color: #ef4444;
        }
        .error-input:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
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
                    <a href="add-product.php" class="text-gray-900 px-3 py-2 rounded-md text-sm font-medium border-b-2 border-gray-900">Product Toevoegen</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Nieuw Product Toevoegen</h1>
            <p class="text-gray-600">Voeg een nieuw product toe aan de BBUGTIEK collectie.</p>
        </div>

        <?php if ($success): ?>
            <div class="bg-green-50 border border-green-200 rounded-md p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Product succesvol toegevoegd!</h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p>Het product is opgeslagen in de database. <a href="products.php" class="font-medium underline">Bekijk alle producten</a></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($errors['database'])): ?>
            <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Fout bij opslaan</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p><?php echo htmlspecialchars($errors['database']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Product Form -->
        <div class="bg-white shadow-lg rounded-lg">
            <form method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
                <!-- Product Name -->
                <div>
                    <label for="naam" class="block text-sm font-medium text-gray-700 mb-2">
                        Productnaam *
                    </label>
                    <input type="text" 
                           id="naam" 
                           name="naam" 
                           value="<?php echo htmlspecialchars($form_data['naam']); ?>"
                           class="form-input block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm <?php echo isset($errors['naam']) ? 'error-input' : ''; ?>"
                           placeholder="Bijv. Vintage T-shirt"
                           maxlength="100"
                           required>
                    <?php if (isset($errors['naam'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo htmlspecialchars($errors['naam']); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <div>
                    <label for="omschrijving" class="block text-sm font-medium text-gray-700 mb-2">
                        Omschrijving
                    </label>
                    <textarea id="omschrijving" 
                              name="omschrijving" 
                              rows="4"
                              class="form-input block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm <?php echo isset($errors['omschrijving']) ? 'error-input' : ''; ?>"
                              placeholder="Beschrijf het product, materiaal, kenmerken, etc."
                              maxlength="500"><?php echo htmlspecialchars($form_data['omschrijving']); ?></textarea>
                    <?php if (isset($errors['omschrijving'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo htmlspecialchars($errors['omschrijving']); ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Maximaal 500 karakters</p>
                </div>

                <!-- Size -->
                <div>
                    <label for="maat" class="block text-sm font-medium text-gray-700 mb-2">
                        Maat
                    </label>
                    <select id="maat" 
                            name="maat"
                            class="form-input block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm <?php echo isset($errors['maat']) ? 'error-input' : ''; ?>">
                        <option value="">Selecteer een maat (optioneel)</option>
                        <option value="XS" <?php echo $form_data['maat'] === 'XS' ? 'selected' : ''; ?>>XS</option>
                        <option value="S" <?php echo $form_data['maat'] === 'S' ? 'selected' : ''; ?>>S</option>
                        <option value="M" <?php echo $form_data['maat'] === 'M' ? 'selected' : ''; ?>>M</option>
                        <option value="L" <?php echo $form_data['maat'] === 'L' ? 'selected' : ''; ?>>L</option>
                        <option value="XL" <?php echo $form_data['maat'] === 'XL' ? 'selected' : ''; ?>>XL</option>
                    </select>
                    <?php if (isset($errors['maat'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo htmlspecialchars($errors['maat']); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Price -->
                <div>
                    <label for="prijs" class="block text-sm font-medium text-gray-700 mb-2">
                        Prijs (€)
                    </label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">€</span>
                        </div>
                        <input type="number" 
                               id="prijs" 
                               name="prijs" 
                               value="<?php echo htmlspecialchars($form_data['prijs']); ?>"
                               step="0.01"
                               min="0"
                               max="9999.99"
                               class="form-input block w-full pl-7 pr-12 py-2 border border-gray-300 rounded-md <?php echo isset($errors['prijs']) ? 'error-input' : ''; ?>"
                               placeholder="29.99">
                    </div>
                    <?php if (isset($errors['prijs'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo htmlspecialchars($errors['prijs']); ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Laat leeg voor "Prijs op aanvraag"</p>
                </div>

                <!-- Image Upload -->
                <div>
                    <label for="afbeelding" class="block text-sm font-medium text-gray-700 mb-2">
                        Productafbeelding
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="afbeelding" class="relative cursor-pointer bg-white rounded-md font-medium text-gray-900 hover:text-gray-800 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-gray-500">
                                    <span>Upload een afbeelding</span>
                                    <input id="afbeelding" 
                                           name="afbeelding" 
                                           type="file" 
                                           accept="image/jpeg,image/png,image/gif,image/webp"
                                           class="sr-only">
                                </label>
                                <p class="pl-1">of sleep en zet neer</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF, WebP tot 5MB</p>
                        </div>
                    </div>
                    <?php if (isset($errors['afbeelding'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo htmlspecialchars($errors['afbeelding']); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
                    <button type="submit" 
                            class="flex-1 bg-gray-900 text-white py-3 px-6 rounded-md font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        Product Opslaan
                    </button>
                    <a href="products.php" 
                       class="flex-1 bg-gray-100 text-gray-900 py-3 px-6 rounded-md font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors text-center">
                        Annuleren
                    </a>
                </div>
            </form>
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

    <script>
        document.getElementById('afbeelding').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    console.log('File selected:', file.name);
                };
                reader.readAsDataURL(file);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input, textarea, select');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.classList.contains('error-input') && this.value.trim()) {
                        this.classList.remove('error-input');
                    }
                });
            });
        });
    </script>
</body>
</html>
