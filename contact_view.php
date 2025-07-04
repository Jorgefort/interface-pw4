<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - BBUGTIEK</title>
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
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2>Neem Contact Op</h2>
        <p>Heb je vragen over onze duurzame kleding of winkelopening? Neem contact met ons op!</p>
        
        <?php if (!empty($error_message)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success_message)): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <div class="contact-content">
            <div class="contact-info">
                <h3>Winkelinformatie</h3>
                <p><strong>Adres:</strong> Kruiskade 88, Rotterdam</p>
                <p><strong>Grand Opening:</strong> 8 augustus 2024</p>
                <p><strong>Openingsevenement:</strong> 17:00 - 23:00</p>
                <p><strong>Met:</strong> DJ, Live Muziek, Cocktailbar, Leuke Aanbiedingen</p>
                <p><strong>Gratis cap</strong> voor de eerste 100 bezoekers!</p>
                
                <h3>Vind Ons</h3>
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2460.3658346524486!2d4.476068515770994!3d51.92257267971631!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c433c17d6b0c9b%3A0x6c8e21c9c7b8a8c7!2sKruiskade%2088%2C%203012%20EX%20Rotterdam%2C%20Netherlands!5e0!3m2!1sen!2snl!4v1625851200000!5m2!1sen!2snl" 
                        width="100%" 
                        height="250" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
                
                <h3>Wat We Aanbieden</h3>
                <ul>
                    <li>Duurzame Broeken</li>
                    <li>Eco-vriendelijke Jurken</li>
                    <li>Biologische T-shirts</li>
                    <li>Gerecyclede Jassen</li>
                    <li>Hemp Kleding</li>
                    <li>Vintage Accessoires</li>
                </ul>
            </div>

            <div class="contact-form">
                <h3>Stuur ons een Bericht</h3>
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="voornaam">Voornaam:</label>
                            <input type="text" id="voornaam" name="voornaam" 
                                   value="<?php echo htmlspecialchars($form_data['voornaam']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="achternaam">Achternaam *:</label>
                            <input type="text" id="achternaam" name="achternaam" required
                                   value="<?php echo htmlspecialchars($form_data['achternaam']); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="telefoonnummer">Telefoonnummer *:</label>
                            <input type="tel" id="telefoonnummer" name="telefoonnummer" required
                                   pattern="[0-9+\-\s\(\)]+" title="Voer een geldig telefoonnummer in"
                                   value="<?php echo htmlspecialchars($form_data['telefoonnummer']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mailadres *:</label>
                            <input type="email" id="email" name="email" required
                                   value="<?php echo htmlspecialchars($form_data['email']); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="adres">Adres:</label>
                        <input type="text" id="adres" name="adres" 
                               value="<?php echo htmlspecialchars($form_data['adres']); ?>">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="postcode">Postcode:</label>
                            <input type="text" id="postcode" name="postcode" 
                                   pattern="[1-9][0-9]{3}\s?[A-Za-z]{2}" title="Voer een geldige Nederlandse postcode in (bijv. 1234AB)"
                                   value="<?php echo htmlspecialchars($form_data['postcode']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="woonplaats">Woonplaats:</label>
                            <input type="text" id="woonplaats" name="woonplaats" 
                                   value="<?php echo htmlspecialchars($form_data['woonplaats']); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="vraag">Vraag *:</label>
                        <textarea id="vraag" name="vraag" rows="5" required 
                                  placeholder="Stel hier uw vraag over onze duurzame kleding of winkelopening..."><?php echo htmlspecialchars($form_data['vraag']); ?></textarea>
                    </div>

                    <button type="submit" class="btn-primary">Verstuur Bericht</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
