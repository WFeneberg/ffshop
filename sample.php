<?php
// Datenbankverbindung
$pdo = new PDO('mysql:host=localhost;dbname=kundenverwaltung', 'root', 'root');

// CRUD-Operationen hier implementieren
// Beispiel: Kunden hinzufügen
if (isset($_POST['vorname'], $_POST['nachname'])) {
    $stmt = $pdo->prepare("INSERT INTO kunden (vorname, nachname) VALUES (:vorname, :nachname)");
    $stmt->execute([':vorname' => $_POST['vorname'], ':nachname' => $_POST['nachname']]);
    echo "Kunde hinzugefügt.";
}

// Kunden und ihre Adressen anzeigen
$sql = "SELECT * FROM kunden LEFT JOIN adressen ON kunden.kunden_id = adressen.kunden_id";
foreach ($pdo->query($sql) as $row) {
    echo "Name: " . $row['vorname'] . " " . $row['nachname'] . "<br/>";
    echo "Adresse: " . $row['strasse'] . ", " . $row['stadt'] . ", " . $row['plz'] . ", " . $row['land'] . "<br/>";
    echo "Adresstyp: " . $row['adress_typ'] . "<br/><br/>";
}
?>