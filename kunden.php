<?php
// Datenbankverbindung
$pdo = new PDO('mysql:host=localhost;dbname=ffshop', 'root', 'root');

if (isset($_POST['vorname'], $_POST['nachname'])) {
    // Kunden hinzufügen
    $stmt = $pdo->prepare("INSERT INTO kunden (vorname, nachname) VALUES (:vorname, :nachname)");
    $stmt->execute([':vorname' => $_POST['vorname'], ':nachname' => $_POST['nachname']]);
    $kunden_id = $pdo->lastInsertId(); // Zuletzt eingefügte Kunden-ID abrufen
    
    // Rechnungsadresse hinzufügen
    $stmt = $pdo->prepare("INSERT INTO adressen (kunden_id, strasse, stadt, plz, land, adress_typ) VALUES (:kunden_id, :strasse, :stadt, :plz, :land, 'Rechnung')");
    $stmt->execute([
        ':kunden_id' => $kunden_id,
        ':strasse' => $_POST['rechnung_strasse'],
        ':stadt' => $_POST['rechnung_stadt'],
        ':plz' => $_POST['rechnung_plz'],
        ':land' => $_POST['rechnung_land']
    ]);
    
    // Versandadresse hinzufügen
    $stmt = $pdo->prepare("INSERT INTO adressen (kunden_id, strasse, stadt, plz, land, adress_typ) VALUES (:kunden_id, :strasse, :stadt, :plz, :land, 'Versand')");
    $stmt->execute([
        ':kunden_id' => $kunden_id,
        ':strasse' => $_POST['versand_strasse'],
        ':stadt' => $_POST['versand_stadt'],
        ':plz' => $_POST['versand_plz'],
        ':land' => $_POST['versand_land']
    ]);
    
    echo "Kunde und Adressen hinzugefügt.";
}
?>