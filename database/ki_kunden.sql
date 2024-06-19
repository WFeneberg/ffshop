CREATE DATABASE IF NOT EXISTS kundenverwaltung;
USE kundenverwaltung;

CREATE TABLE kunden (
    kunden_id INT AUTO_INCREMENT PRIMARY KEY,
    vorname VARCHAR(255) NOT NULL,
    nachname VARCHAR(255) NOT NULL
);

CREATE TABLE adressen (
    adress_id INT AUTO_INCREMENT PRIMARY KEY,
    kunden_id INT,
    strasse VARCHAR(255) NOT NULL,
    stadt VARCHAR(255) NOT NULL,
    plz VARCHAR(10) NOT NULL,
    land VARCHAR(255) NOT NULL,
    adress_typ ENUM('Rechnung', 'Versand') NOT NULL,
    FOREIGN KEY (kunden_id) REFERENCES kunden(kunden_id)
);