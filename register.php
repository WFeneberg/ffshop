<?php
$pdo = new PDO('mysql:host=localhost;dbname=ffshop', 'root', 'root'); // Verbindung zur Datenbank

if (isset($_POST['username'], $_POST['password'], $_POST['email'])) {

$stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
$stmt->execute([
    ':username' => $_POST['username'],
    ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
    ':email' => $_POST['email']
    ]);

    echo "User hinzugefügt.";
}

?>