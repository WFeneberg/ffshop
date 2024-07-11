<?php
$pageTitle = 'Vorhandene Artikel';
$page = 'index';
include './inc/header.inc.php';

$pdo = new PDO('mysql:host=localhost;dbname=warehousedb', 'root', 'root');
// Verbindung zur Datenbank

$artikel = $pdo->query("SELECT lager.*, kategorie.KategorieN FROM lager JOIN kategorie ON lager.KategorieID = kategorie.KategorieID;")->fetchAll();
?>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Preis</th>
        <th>Kategorie</th>
        <th>Aktionen</th>
    </tr>
    <?php foreach ($artikel as $a) : ?>
        <tr>
            <td><?= htmlspecialchars($a['ProduktID']) ?></td>
            <td><?= htmlspecialchars($a['Produkt']) ?></td>
            <td><?= htmlspecialchars($a['Preis']) ?></td>
            <td><?= htmlspecialchars($a['KategorieN']) ?></td>
            <td>
                <form action="cartadded.php" method="post">
                    <input type="hidden" name="aktion" value="order">
                    <input type="hidden" id="kunden_id" name="kunden_id" value="<?= isset($kunden_id) ? htmlspecialchars($kunden_id) : ''; ?>">
                    <input type="hidden" id="pay_id" name="pay_id" value="<?= isset($pay_id) ? htmlspecialchars($pay_id) : ''; ?>">
                    <input type="hidden" name="ProduktID" value="<?= $a['ProduktID'] ?>">
                    <?php if (isset($kunden_id)) : ?>
                        <button type="submit">Bestellen</button>
                    <?php endif; ?>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php include './inc/footer.inc.php'; ?>