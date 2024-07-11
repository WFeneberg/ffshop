-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 11. Jul 2024 um 23:14
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `warehousedb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adressen`
--

CREATE TABLE `adressen` (
  `AdressID` int(11) NOT NULL,
  `KundenID` int(11) DEFAULT NULL,
  `Strasse` varchar(255) NOT NULL,
  `Stadt` varchar(255) NOT NULL,
  `Plz` varchar(10) NOT NULL,
  `Land` varchar(255) NOT NULL,
  `AdressTyp` enum('Rechnung','Versand') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kategorie`
--

CREATE TABLE `kategorie` (
  `KategorieID` int(11) NOT NULL,
  `KategorieN` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `kategorie`
--

INSERT INTO `kategorie` (`KategorieID`, `KategorieN`) VALUES
(1, 'Mainboard'),
(2, 'Grafikkarte'),
(3, 'RAM'),
(4, 'Netzteil'),
(5, 'Monitor');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kunden`
--

CREATE TABLE `kunden` (
  `KundenID` int(11) NOT NULL,
  `KundenName` varchar(50) DEFAULT NULL,
  `Passwort` varchar(50) DEFAULT NULL,
  `PayID` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lager`
--

CREATE TABLE `lager` (
  `ProduktID` int(11) NOT NULL,
  `Produkt` varchar(50) DEFAULT NULL,
  `Preis` float(5,2) DEFAULT NULL,
  `KategorieID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `lager`
--

INSERT INTO `lager` (`ProduktID`, `Produkt`, `Preis`, `KategorieID`) VALUES
(1, 'MSI MPG B550 GAMING PLUS', 119.00, 1),
(2, 'ASUS ROG STRIX B650E-E', 338.00, 1),
(3, 'GIGABYTE X670 GAMING X AX V2', 252.00, 1),
(4, 'MSI GeForce RTX 3060', 309.00, 2),
(5, 'GIGABYTE GeForce RTX 4070 SUPER', 659.00, 2),
(6, 'GIGABYTE Radeon RX 7800 XT', 559.00, 2),
(7, 'Corsair DIMM 32GB DDR5-6000 (2x 16GB) Dual-Kit', 119.90, 3),
(8, 'Mushkin DIMM 16GB DDR3-1600 (2x 8GB) Dual-Kit', 22.29, 3),
(9, 'be quiet! STRAIGHT POWER 11 CM 850W', 149.90, 4),
(10, 'Corsair CV650 650W', 69.90, 4),
(11, 'Corsair RM1000X (2021) 1000W', 189.90, 4),
(12, '24 LG LCD 24BN65YP-B', 164.90, 5),
(13, 'ASUS ROG Swift PG27AQDM', 969.00, 5),
(14, 'GIGABYTE G34WQC A', 379.00, 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `warenkorb`
--

CREATE TABLE `warenkorb` (
  `KundenID` int(11) NOT NULL,
  `ProduktID` int(11) NOT NULL,
  `PayID` int(11) DEFAULT NULL,
  `Anzahl` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zahlung`
--

CREATE TABLE `zahlung` (
  `PayID` int(11) NOT NULL,
  `ZM` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `zahlung`
--

INSERT INTO `zahlung` (`PayID`, `ZM`) VALUES
(1, 'PayPal'),
(2, 'Kreditkarte'),
(3, 'Klarna'),
(4, 'Sofort Überweisung');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `adressen`
--
ALTER TABLE `adressen`
  ADD PRIMARY KEY (`AdressID`),
  ADD KEY `KundenID` (`KundenID`);

--
-- Indizes für die Tabelle `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`KategorieID`);

--
-- Indizes für die Tabelle `kunden`
--
ALTER TABLE `kunden`
  ADD PRIMARY KEY (`KundenID`);

--
-- Indizes für die Tabelle `lager`
--
ALTER TABLE `lager`
  ADD PRIMARY KEY (`ProduktID`),
  ADD KEY `fk_kategorie` (`KategorieID`);

--
-- Indizes für die Tabelle `warenkorb`
--
ALTER TABLE `warenkorb`
  ADD PRIMARY KEY (`ProduktID`),
  ADD KEY `KundenID` (`KundenID`),
  ADD KEY `warenkorb_ibfk_3` (`PayID`);

--
-- Indizes für die Tabelle `zahlung`
--
ALTER TABLE `zahlung`
  ADD PRIMARY KEY (`PayID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `adressen`
--
ALTER TABLE `adressen`
  MODIFY `AdressID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT für Tabelle `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `KategorieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `kunden`
--
ALTER TABLE `kunden`
  MODIFY `KundenID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT für Tabelle `lager`
--
ALTER TABLE `lager`
  MODIFY `ProduktID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT für Tabelle `zahlung`
--
ALTER TABLE `zahlung`
  MODIFY `PayID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `adressen`
--
ALTER TABLE `adressen`
  ADD CONSTRAINT `adressen_ibfk_1` FOREIGN KEY (`KundenID`) REFERENCES `kunden` (`KundenID`);

--
-- Constraints der Tabelle `lager`
--
ALTER TABLE `lager`
  ADD CONSTRAINT `fk_kategorie` FOREIGN KEY (`KategorieID`) REFERENCES `kategorie` (`KategorieID`);

--
-- Constraints der Tabelle `warenkorb`
--
ALTER TABLE `warenkorb`
  ADD CONSTRAINT `warenkorb_ibfk_1` FOREIGN KEY (`KundenID`) REFERENCES `kunden` (`KundenID`),
  ADD CONSTRAINT `warenkorb_ibfk_2` FOREIGN KEY (`ProduktID`) REFERENCES `kategorie` (`KategorieID`),
  ADD CONSTRAINT `warenkorb_ibfk_3` FOREIGN KEY (`PayID`) REFERENCES `zahlung` (`PayID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
