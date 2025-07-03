CREATE TABLE IF NOT EXISTS producten (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    naam TEXT NOT NULL,
    omschrijving TEXT,
    maat TEXT CHECK(maat IN ('XS', 'S', 'M', 'L', 'XL')),
    afbeelding TEXT,
    prijs INTEGER
);


INSERT INTO producten (naam, omschrijving, maat, afbeelding, prijs) VALUES 
('Vintage Denim Jacket', 'Klassieke vintage denim jasje gemaakt van 100% biologisch katoen.', 'M', NULL, 7995),
('Eco T-Shirt', 'Zachte biologische katoenen t-shirt met minimalistisch design.', 'L', NULL, 2995),
('Sustainable Hoodie', 'Comfortabele hoodie gemaakt van gerecyclede materialen.', 'S', NULL, 5995),
('Cotton Dress', 'Elegante jurk van 100% biologisch katoen.', 'M', NULL, 8995),
('Sneakers', 'Comfortabele sneakers van gerecyclede materialen.', NULL, NULL, 12995),
('Hemp Pants', 'Natuurlijke hennep broek met moderne pasvorm.', 'XL', NULL, NULL);
