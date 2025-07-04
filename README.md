# Sustainable Clothing Shop - Database Setup

## Database Requirements Met ✅

### Table Structure (producten)
- **id**: INTEGER, NOT NULL, AUTO INCREMENT ✅
- **naam**: TEXT, NOT NULL ✅  
- **omschrijving**: TEXT (nullable) ✅
- **maat**: TEXT with CHECK constraint (XS, S, M, L, XL) ✅
- **afbeelding**: TEXT (nullable) ✅
- **prijs**: INTEGER (stored in cents) ✅

### Database Features
- ✅ SQLite database (`database/producten.db`)
- ✅ Proper constraints and validation
- ✅ Sample data included
- ✅ Price stored in cents (e.g., 7995 = $79.95)
- ✅ Size validation (XS, S, M, L, XL only)
- ✅ Image file name storage

## Quick Start

1. **Start PHP server:**
   ```bash
   php -S localhost:8000
   ```

2. **Access the application:**
   - Home: http://localhost:8000/index.php
   - Products: http://localhost:8000/products.php
   - Add Product: http://localhost:8000/add-product.php
   - Contact: http://localhost:8000/contact.php

The application is now fully functional and ready for use! 🎉
