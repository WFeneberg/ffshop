<?php 
$pageTitle = 'Registrieren';
$page = 'register';
include './inc/header.inc.php'; 

$pdo = new PDO('mysql:host=localhost;dbname=warehousedb', 'root', 'root');
// Verbindung zur Datenbank

$payments = $pdo->query("SELECT * FROM zahlung")->fetchAll();

if (isset($_POST['KundenName'], $_POST['Passwort'], $_POST['paiid'])) {

    $stmt = $pdo->prepare("SELECT * FROM kunden WHERE KundenName  = :KundenName");
    $stmt->execute([':KundenName' => $_POST['KundenName']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    var_dump($result);
    if (!$result) {
      $pay_id =  $_POST['paiid'];
        // 	Kunden hinzufügen
        $stmt = $pdo->prepare("INSERT INTO kunden (KundenName, Passwort, PayID) VALUES (:KundenName, :Passwort, :PayID)");
      
        $stmt->execute([':KundenName' => $_POST['KundenName'], ':Passwort' =>$_POST['Passwort'], ':PayID' => $_POST['paiid']]);
      
        $kunden_id = $pdo->lastInsertId();
      
        // 	Rechnungsadresse hinzufügen
        $stmt = $pdo->prepare("INSERT INTO adressen (KundenID, Strasse, Stadt, Plz, Land, AdressTyp) VALUES (:KundenID, :strasse, :stadt, :plz, :land, 'Rechnung')");
      
        $stmt->execute([
        ':KundenID' => $kunden_id,
        ':strasse' => $_POST['rechnung_strasse'],
        ':stadt' => $_POST['rechnung_stadt'],
        ':plz' => $_POST['rechnung_plz'],
        ':land' => $_POST['rechnung_land']
        ]);
      
      
        // 	Versandadresse hinzufügen
        $stmt = $pdo->prepare("INSERT INTO adressen (KundenID, Strasse, Stadt, Plz, Land, AdressTyp) VALUES (:KundenID, :strasse, :stadt, :plz, :land, 'Versand')");
      
        $stmt->execute([
        ':KundenID' => $kunden_id,
        ':strasse' => $_POST['versand_strasse'],
        ':stadt' => $_POST['versand_stadt'],
        ':plz' => $_POST['versand_plz'],
        ':land' => $_POST['versand_land']
        ]);
      
      
        $Meldungen =  "Kunde und Adressen hinzugefügt.";
    } else {
      $Meldungen = "Kunde existiert bereits.";
    }
  }
?>
<form action="" method="post">
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