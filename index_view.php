<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?> - <?php echo $site_tagline; ?></title>
    <link rel="stylesheet" href="css/simple-style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <h1><?php echo $site_name; ?></h1>
            <p class="subtitle"><?php echo $site_tagline; ?></p>
        </div>
    </header>

    <!-- Navigation -->
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

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="hero-content">
                <h2>Welkom bij <?php echo $site_name; ?></h2>
                <p>Duurzame mode voor een betere wereld. Ontdek onze collectie van milieuvriendelijke kleding.</p>
                <p><strong>Grand Opening: <?php echo $opening_date; ?> • 17:00-23:00</strong></p>
                <p>🎵 <strong>DJ & Live Muziek</strong> • 🍹 <strong>Cocktailbar</strong> • 🎁 <strong>Leuke Aanbiedingen</strong></p>
                <p>🧢 <strong>Gratis cap voor de eerste 100 bezoekers!</strong></p>
                <a href="products.php" class="btn">Bekijk Producten</a>
            </div>
            <div class="hero-image">
                <img src="assets/vintage denim jacket.jpg" alt="<?php echo $site_name; ?> kleding">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2>Waarom Kiezen Voor <?php echo $site_name; ?>?</h2>
            <div class="features-grid">
                <div class="feature">
                    <h3>🌱 Duurzaam</h3>
                    <p>Al onze kleding is gemaakt van milieuvriendelijke materialen</p>
                </div>
                <div class="feature">
                    <h3>👕 Kwaliteit</h3>
                    <p>Hoogwaardige kleding die lang meegaat</p>
                </div>
                <div class="feature">
                    <h3>💚 Eerlijk</h3>
                    <p>Faire prijzen en ethische productie</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="products">
        <div class="container">
            <h2>Onze Categorieën</h2>
            <div class="categories-grid">
                <?php foreach($product_categories as $category): ?>
                <div class="category">
                    <h3><?php echo $category; ?></h3>
                    <a href="products.php" class="btn-small">Bekijk</a>
                </div>
                <?php endforeach; ?>
            </div>

            <h2>Uitgelichte Producten</h2>
            <div class="featured-products-grid">
                <?php foreach($featured_products as $product): ?>
                <div class="product-card">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    <h3><?php echo $product['name']; ?></h3>
                    <p class="price"><?php echo $product['price']; ?></p>
                    <a href="product-detail.php" class="btn-small">Bekijk Details</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <h2>Over <?php echo $site_name; ?></h2>
            <div class="about-content">
                <div class="about-text">
                    <p>
                        <?php echo $site_name; ?> is een duurzame kledingwinkel gevestigd in Rotterdam. 
                        Wij geloven in mode die goed is voor zowel de planeet als de mensen.
                    </p>
                    <p>
                        Onze kleding wordt gemaakt van biologische en gerecyclede materialen. 
                        Alle leveranciers worden eerlijk betaald en werken onder goede omstandigheden.
                    </p>
                    <p><strong>Bezoek onze winkel:</strong><br>
                    <?php echo $shop_address; ?><br>
                    <?php echo $company_info['hours']; ?></p>
                </div>
                <div class="about-image">
                    <img src="assets/sustainable hoodie.jpeg" alt="Duurzame kleding">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <h2>Contact</h2>
            <div class="contact-content">
                <div class="contact-info">
                    <h3>Contactgegevens</h3>
                    <p><strong>Adres:</strong> <?php echo $shop_address; ?></p>
                    <p><strong>Telefoon:</strong> <?php echo $company_info['phone']; ?></p>
                    <p><strong>Email:</strong> <?php echo $company_info['email']; ?></p>
                    <p><strong>Openingstijden:</strong> <?php echo $company_info['hours']; ?></p>
                    
                    <h3>Locatie</h3>
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2460.3658346524486!2d4.476068515770994!3d51.92257267971631!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c433c17d6b0c9b%3A0x6c8e21c9c7b8a8c7!2sKruiskade%2088%2C%203012%20EX%20Rotterdam%2C%20Netherlands!5e0!3m2!1sen!2snl!4v1625851200000!5m2!1sen!2snl" 
                            width="100%" 
                            height="200" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
                <div class="contact-form">
                    <h3>Stuur ons een bericht</h3>
                    <form>
                        <input type="text" placeholder="Uw naam" required>
                        <input type="email" placeholder="Uw email" required>
                        <textarea placeholder="Uw bericht" required></textarea>
                        <button type="submit" class="btn">Verstuur</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2024 <?php echo $site_name; ?>. Alle rechten voorbehouden.</p>
            <p>Duurzame mode • <?php echo $shop_address; ?> • <?php echo $company_info['phone']; ?></p>
        </div>
    </footer>

    <!-- Simple JavaScript for smooth scrolling -->
    <script>
        // Simple smooth scrolling - beginner level
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Simple hover effect for product cards
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>
