<?php 
$pageTitle = 'Registrieren';
$page = 'register';
include './inc/header.inc.php'; 

$payments = $pdo->query("SELECT * FROM zahlung")->fetchAll();


?>
<form action="registered.php" method="post">
        <!-- Kundeninformationen -->
        <label for="KundenName">Kundenname:</label><br>
        <input type="text" id="KundenName" name="KundenName" required><br>
        <label for="Passwort">Passwort:</label><br>
        <input type="text" id="Passwort" name="Passwort" required><br><br>
        
        <!-- Rechnungsadresse -->
        <h3>Rechnungsadresse</h3>
        <label for="rechnung_strasse">Straße:</label><br>
        <input type="text" id="rechnung_strasse" name="rechnung_strasse" required><br>
        <label for="rechnung_stadt">Stadt:</label><br>
        <input type="text" id="rechnung_stadt" name="rechnung_stadt" required><br>
        <label for="rechnung_plz">PLZ:</label><br>
        <input type="text" id="rechnung_plz" name="rechnung_plz" required><br>
        <label for="rechnung_land">Land:</label><br>
        <input type="text" id="rechnung_land" name="rechnung_land" required><br><br>
        
        <!-- Versandadresse -->
        <h3>Versandadresse</h3>
        <label for="versand_strasse">Straße:</label><br>
        <input type="text" id="versand_strasse" name="versand_strasse" required><br>
        <label for="versand_stadt">Stadt:</label><br>
        <input type="text" id="versand_stadt" name="versand_stadt" required><br>
        <label for="versand_plz">PLZ:</label><br>
        <input type="text" id="versand_plz" name="versand_plz" required><br>
        <label for="versand_land">Land:</label><br>
        <input type="text" id="versand_land" name="versand_land" required><br><br>

        <h3>Zahlungsmethode</h3>
        <label for="paiid">Zahlungsmethode wählen:</label><br>
        <select id="paiid" name="paiid" required>
        <?php foreach ($payments as $payment): ?>
          <option value="<?= htmlspecialchars($payment['PayID']) ?>"><?= htmlspecialchars($payment['ZM']) ?></option>
        <?php endforeach; ?>
        </select><br><br>
        
        <input type="submit" value="Kunden hinzufügen">
    </form>
<?php include './inc/footer.inc.php'; ?>