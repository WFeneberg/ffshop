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
$email = $_POST['email'];
$pass = $_POST['password'];

// Passwort verschlüsseln
$hashed_password = password_hash($pass, PASSWORD_DEFAULT);

// SQL zum Einfügen des neuen Benutzers
$sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";

// Vorbereiten des SQL-Statements
$stmt = $conn->prepare($sql);

// Parameter binden
$stmt->bind_param("sss", $user, $hashed_password, $email);

// Statement ausführen
if ($stmt->execute()) {
    echo "Registrierung erfolgreich!";
} else {
    echo "Fehler: " . $sql . "<br>" . $conn->error;
}

// Verbindung schließen
$stmt->close();
$conn->close();
?>