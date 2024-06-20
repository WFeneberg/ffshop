CREATE TABLE artikel (
    artikel_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    beschreibung TEXT,
    preis DECIMAL(10, 2) NOT NULL,
    lagerbestand INT NOT NULL
);