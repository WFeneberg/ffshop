<?php
$pdo = new PDO('mysql:host=localhost;dbname=ffshop', 'root', 'root'); // Verbindung zur Datenbank

// Artikel hinzufügen
if (isset($_POST['aktion']) && $_POST['aktion'] == 'hinzufuegen') {
    $stmt = $pdo->prepare("INSERT INTO artikel (name, beschreibung, preis, lagerbestand) VALUES (:name, :beschreibung, :preis, :lagerbestand)");
    $stmt->execute([
        ':name' => $_POST['name'],
        ':beschreibung' => $_POST['beschreibung'],
        ':preis' => $_POST['preis'],
        ':lagerbestand' => $_POST['lagerbestand']
    ]);
}

// Artikel bearbeiten
if (isset($_POST['aktion']) && $_POST['aktion'] == 'bearbeiten') {
    $stmt = $pdo->prepare("UPDATE artikel SET name = :name, beschreibung = :beschreibung, preis = :preis, lagerbestand = :lagerbestand WHERE artikel_id = :artikel_id");
    $stmt->execute([
        ':name' => $_POST['name'],
        ':beschreibung' => $_POST['beschreibung'],
        ':preis' => $_POST['preis'],
        ':lagerbestand' => $_POST['lagerbestand'],
        ':artikel_id' => $_POST['artikel_id']
    ]);
}

// Artikel löschen
if (isset($_POST['aktion']) && $_POST['aktion'] == 'loeschen') {
    $stmt = $pdo->prepare("DELETE FROM artikel WHERE artikel_id = :artikel_id");
    $stmt->execute([':artikel_id' => $_POST['artikel_id']]);
}

// Artikel auslesen
$artikel = $pdo->query("SELECT * FROM artikel")->fetchAll();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Artikelverwaltung</title>
</head>
<body>
    <h1>Artikelverwaltung</h1>
    <form action="" method="post">
        <input type="hidden" name="aktion" value="hinzufuegen">
        Name: <input type="text" name="name" required><br>
        Beschreibung: <textarea name="beschreibung"></textarea><br>
        Preis: <input type="number" name="preis" step="0.01" required><br>
        Lagerbestand: <input type="number" name="lagerbestand" required><br>
        <button type="submit">Artikel hinzufügen</button>
    </form>
    <h2>Vorhandene Artikel</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Beschreibung</th>
            <th>Preis</th>
            <th>Lagerbestand</th>
            <th>Aktionen</th>
        </tr>
        <?php foreach ($artikel as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a['name']) ?></td>
            <td><?= htmlspecialchars($a['beschreibung']) ?></td>
            <td><?= htmlspecialchars($a['preis']) ?></td>
            <td><?= htmlspecialchars($a['lagerbestand']) ?></td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="aktion" value="bearbeiten">
                    <input type="hidden" name="artikel_id" value="<?= $a['artikel_id'] ?>">
                    <button type="submit">Bearbeiten</button>
                </form>
                <form action="" method="post">
                    <input type="hidden" name="aktion" value="loeschen">
                    <input type="hidden" name="artikel_id" value="<?= $a['artikel_id'] ?>">
                    <button type="submit">Löschen</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>