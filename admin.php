<?php 
$pageTitle = 'Administration';
$page = 'admin';
include './inc/header.inc.php'; 

$pdo = new PDO('mysql:host=localhost;dbname=warehousedb', 'root', 'root');
// Verbindung zur Datenbank

$alleKunden = $pdo->query("SELECT * FROM kunden")->fetchAll();
?>
<table>
        <tr>
            <th>KundenID</th>
            <th>Kundenname</th>
        </tr>
        <?php foreach ($alleKunden as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a['KundenID']) ?></td>
            <td><?= htmlspecialchars($a['KundenName']) ?></td>
            <td>
                <form action="admindeleted.php" method="post">
                    <input type="hidden" name="aktion" value="custdelete">
                    <input type="hidden" id="kunden_id" name="kunden_id" value="<?= isset($a['KundenID']) ? htmlspecialchars($a['KundenID']) : ''; ?>">
                    <button type="submit">Löschen</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php
include './inc/footer.inc.php'; 
?>