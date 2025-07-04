-- Database schema for BBUGTIEK project
-- Create this database manually in PHPStorm as "Productvoeg.db"

CREATE TABLE IF NOT EXISTS producten (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    naam TEXT NOT NULL,
    omschrijving TEXT,
    maat TEXT CHECK(maat IN ('XS', 'S', 'M', 'L', 'XL')),
    afbeelding TEXT,
    prijs INTEGER
);

-- Sample data (optional)
INSERT INTO producten (naam, omschrijving, maat, afbeelding, prijs) VALUES 
('Vintage Denim Jacket', 'Klassieke vintage denim jasje gemaakt van 100% biologisch katoen.', 'M', 'vintage denim jacket.jpg', 7995),
('Eco T-Shirt', 'Zachte biologische katoenen t-shirt met minimalistisch design.', 'L', 'Eco friendly t-shirt.jpeg', 2995),
('Sustainable Hoodie', 'Comfortabele hoodie gemaakt van gerecyclede materialen.', 'S', 'sustainable hoodie.jpeg', 5995),
('Cotton Dress', 'Elegante jurk van 100% biologisch katoen.', 'M', 'cotton dress.webp', 8995),
('Sneakers', 'Comfortabele sneakers van gerecyclede materialen.', NULL, 'recycled sneakers.jpg', 12995),
('Hemp Pants', 'Natuurlijke hennep broek met moderne pasvorm.', 'XL', 'hemp pants.jpg', 4995);
