<?php
$pdo = new PDO('mysql:host=localhost;dbname=warehousedb', 'root', 'root'); // Verbindung zur Datenbank

$artikel = $pdo->query("SELECT * FROM lager")->fetchAll();
?>