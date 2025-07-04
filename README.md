# BBUGTIEK Project - Transfer to PHPStorm

## Instructions voor PHPStorm

### 1. Database Setup
1. In PHPStorm, create a new SQLite database called `Productvoeg.db` in the `database/` folder
2. Run the SQL from `database-schema.sql` to create the table structure
3. Optionally add the sample data from the same file

### 2. Project Structure
```
project/
├── index.html (main landing page)
├── products.php (shows all products)
├── add-product.php (form to add new products)
├── product-detail.php (shows single product)
├── delete-product.php (delete products)
├── config/database.php (database connection)
├── database/Productvoeg.db (create this manually)
├── assets/ (images and media)
└── uploads/ (for uploaded product images)
```

### 3. Requirements
- PHP 7.4+
- SQLite support
- Web server (Apache/Nginx or PHPStorm built-in)

### 4. Database Schema
According to assignment requirements:
- Table name: `producten`
- Fields: id (INTEGER, PRIMARY KEY, AUTOINCREMENT), naam (TEXT, NOT NULL), omschrijving (TEXT), maat (TEXT, XS/S/M/L/XL), afbeelding (TEXT), prijs (INTEGER in cents)

### 5. Features Implemented
- ✅ Product listing page
- ✅ Product detail page
- ✅ Add product form with validation
- ✅ Delete product functionality
- ✅ Price formatting (stored in cents, displayed in euros)
- ✅ Size validation (XS, S, M, L, XL)
- ✅ Server-side validation
- ✅ Beautiful responsive design

### 6. Navigation
- `index.html` - Main landing page with links to `products.php`
- `products.php` - Shows all products from database
- `add-product.php` - Form to add new products
- `product-detail.php?id=X` - Shows details of product with ID X
- `delete-product.php?id=X` - Delete product with ID X

The code has been simplified and is ready for transfer to PHPStorm. All database references now point to `Productvoeg.db` which you'll create manually.
