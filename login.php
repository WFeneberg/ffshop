<?php
// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "db_user";
$password = "db_password";
$dbname = "meine_datenbank";

// Erstellen der Verbindung
$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen der Verbindung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Daten aus dem Post-Request holen
$user = $_POST['username'];
$pass = $_POST['password'];

// SQL zum Überprüfen des Benutzernamens
$sql = "SELECT id, password FROM users WHERE username = ?";

// Vorbereiten des SQL-Statements
$stmt = $conn->prepare($sql);

// Parameter binden
$stmt->bind_param("s", $user);

// Statement ausführen
$stmt->execute();

// Ergebnis holen
$result = $stmt