<?php 
$pageTitle = 'Warenkorb';
$page = 'shopping';
include './inc/header.inc.php'; 

$warenkorb = $pdo->query("SELECT warenkorb.*, lager.Produkt, kategorie.KategorieN, lager.Preis, warenkorb.Anzahl * lager.Preis AS Gesamtpreis FROM warenkorb JOIN lager ON warenkorb.ProduktID = lager.ProduktID JOIN kategorie ON lager.KategorieID = kategorie.KategorieID;")->fetchAll();
?>
 <table>
        <tr>
            <th>Kunde</th>
            <th>ProduktID</th>
            <th>Produkt</th>
            <th>Kategorie</th>
            <th>Anzahl</th>
            <th>Preis</th>
            <th>Gesamtpreis</th>
        </tr>
        <?php foreach ($warenkorb as $a): ?>
          <?php if ($a['KundenID'] == $kunden_id): ?>
        <tr>
            <td><?= htmlspecialchars($a['KundenID']) ?></td>
            <td><?= htmlspecialchars($a['ProduktID']) ?></td>
            <td><?= htmlspecialchars($a['Produkt']) ?></td>
            <td><?= htmlspecialchars($a['KategorieN']) ?></td>
            <td><?= htmlspecialchars($a['Anzahl']) ?></td>
            <td><?= htmlspecialchars($a['Preis']) ?></td>
            <td><?= htmlspecialchars($a['Gesamtpreis']) ?></td>
            <td>
                <form action="cartdelete.php" method="post">
                    <input type="hidden" name="aktion" value="delete">
                    <input type="hidden" id="kunden_id" name="kunden_id" value="<?= isset($kunden_id) ? htmlspecialchars($kunden_id) : ''; ?>">
                    <input type="hidden" id="pay_id" name="pay_id" value="<?= isset($pay_id) ? htmlspecialchars($pay_id) : ''; ?>">
                    <input type="hidden" name="ProduktID" value="<?= $a['ProduktID'] ?>">
                    <button type="submit">Löschen</button>
                </form>
            </td>
        </tr>
        <?php endif; ?>
        <?php endforeach; ?>
    </table>
<?php 
include './inc/footer.inc.php'; 
?>