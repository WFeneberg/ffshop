<?php
global $kunden_id;
global $pay_id;
global $Meldungen;


$pdo = new PDO('mysql:host=localhost;dbname=warehousedb', 'root', 'root');
// Verbindung zur Datenbank

$artikel = $pdo->query("SELECT lager.*, kategorie.KategorieN FROM lager JOIN kategorie ON lager.KategorieID = kategorie.KategorieID;")->fetchAll();

$warenkorb = $pdo->query("SELECT warenkorb.*, lager.Produkt, kategorie.KategorieN, lager.Preis, warenkorb.Anzahl * lager.Preis AS Gesamtpreis FROM warenkorb JOIN lager ON warenkorb.ProduktID = lager.ProduktID JOIN kategorie ON lager.KategorieID = kategorie.KategorieID;")->fetchAll();

$payments = $pdo->query("SELECT * FROM zahlung")->fetchAll();

$alleKunden = $pdo->query("SELECT * FROM kunden")->fetchAll();


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


if (isset($_POST['LoginKundenName'], $_POST['LoginPasswort'])) {
	
	// 	Beim Anmelden
	$eingegebenesPasswort = $_POST['LoginPasswort'];
	// 	Das vom Benutzer beim Anmelden eingegebene Passwort
	$stmt = $pdo->prepare("Select KundenID, Passwort, PayID FROM kunden WHERE KundenName = :LoginKundenName");
	
	$stmt->execute(['LoginKundenName' => $_POST['LoginKundenName']]);
	
	$user = $stmt->fetch();
  if ($user === false) {
    $Meldungen = "Benutzername nicht gefunden oder falsches Passwort.";
} else {
	// 	Benutzerdaten aus der Datenbank abrufen
	$gespeichertesPasswort = $user['Passwort'];
	// 	Das in der Datenbank gespeicherte Passwort
	$kunden_id = $user['KundenID'];
  $pay_id = $user['PayID'];
	// 	Die Kunden-ID des Benutzers
	if ($eingegebenesPasswort === $gespeichertesPasswort) {
		$Meldungen = "Anmeldung erfolgreich.";
	}
	else {
		
		$Meldungen =  "Anmeldung fehlgeschlagen.";
		
	}
}

}

function saveToCart($kundenID, $produktID, $pay_id) {
  $pdo = new PDO('mysql:host=localhost;dbname=warehousedb', 'root', 'root');
// Verbindung zur Datenbank
  // Überprüfen, ob das Produkt bereits im Warenkorb des Benutzers ist
  $stmt = $pdo->prepare("SELECT * FROM warenkorb WHERE KundenID  = :KundenID  AND ProduktID = :produktID");
  $stmt->execute(['KundenID' => $kundenID, 'produktID' => $produktID]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
 
  //$Meldungen = $result;
  if ($result) {
    // Wenn das Produkt bereits vorhanden ist, erhöhe die Anzahl
    $neueAnzahl = $result['Anzahl'] + 1;
    $updateStmt = $pdo->prepare("UPDATE warenkorb SET anzahl = :anzahl WHERE KundenID  = :KundenID AND ProduktID = :produktID");
    $updateStmt->execute(['anzahl' => $neueAnzahl, 'KundenID' => $kundenID, 'produktID' => $produktID]);
  } else {
    // Wenn das Produkt noch nicht im Warenkorb ist, füge es hinzu
    $insertStmt = $pdo->prepare("INSERT INTO warenkorb (KundenID , ProduktID, anzahl, PayID) VALUES (:KundenID, :produktID, 1, :pay_id)");
    $insertStmt->execute(['KundenID' => $kundenID, 'produktID' => $produktID, 'pay_id' => $pay_id]);
  }
}

if (isset($_POST['aktion']) && $_POST['aktion'] === 'order') {
  
  $produktID = $_POST['ProduktID'];
  $kunden_id = $_POST['kunden_id'];
  $pay_id = $_POST['pay_id'];

  saveToCart($kunden_id, $produktID, $pay_id);
  
  $Meldungen = "Produkt wurde zum Warenkorb hinzugefügt.";
  
}

function deletefromCart($kundenID, $produktID) {
  $pdo = new PDO('mysql:host=localhost;dbname=warehousedb', 'root', 'root');
// Verbindung zur Datenbank
  // Überprüfen, ob das Produkt bereits im Warenkorb des Benutzers ist



  $stmt = $pdo->prepare("DELETE FROM warenkorb WHERE KundenID = :KundenID AND ProduktID = :produktID");
  $stmt->execute(['KundenID' => $kundenID, 'produktID' => $produktID]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

}

if (isset($_POST['aktion']) && $_POST['aktion'] === 'delete') {
  
  $produktID = $_POST['ProduktID'];
  $kunden_id = $_POST['kunden_id'];

  deletefromCart($kunden_id, $produktID);
  
  $Meldungen = "Produkt wurde zum Warenkorb hinzugefügt.";
  
}

function deletecustomer($kundenID) {
  $pdo = new PDO('mysql:host=localhost;dbname=warehousedb', 'root', 'root');

  $stmt = $pdo->prepare("DELETE FROM warenkorb WHERE KundenID = :KundenID");
  $stmt->execute(['KundenID' => $kundenID]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  $stmt = $pdo->prepare("DELETE FROM adressen WHERE KundenID = :KundenID");
  $stmt->execute(['KundenID' => $kundenID]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);


  $stmt = $pdo->prepare("DELETE FROM kunden WHERE KundenID = :KundenID");
  $stmt->execute(['KundenID' => $kundenID]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

}

if (isset($_POST['aktion']) && $_POST['aktion'] === 'custdelete') {
  
  $kunden_id = $_POST['kunden_id'];

  deleteCustomer($kunden_id);
  
  $Meldungen = "Produkt wurde zum Warenkorb hinzugefügt.";
  
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Computer Fakeshop</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <nav id="menu">
    <ul>
      <li><a href="#" onclick="showHome()">Home</a></li>
      <li><a href="#" onclick="showWarenkorb()">Warenkorb</a></li>
      <!--<li><a href="#" onclick="showKonto()">Konto</a></li>-->
      <li><a href="#" onclick="showLogin()">Anmeldung</a></li>
      <li><a href="#" onclick="showAdmin()">Verwaltung</a></li>
      <?php if (!isset($kunden_id)): ?>
      <li class="white-text">Bitte anmelden</li>
      <?php endif; ?>
    </ul>
  </nav>

  <div id="content">
  
    <div id="home">
      <h1>Willkommen!</h1>
      <h2>Vorhandene Artikel</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Preis</th>
            <th>Kategorie</th>
            <th>Aktionen</th>
        </tr>
        <?php foreach ($artikel as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a['ProduktID']) ?></td>
            <td><?= htmlspecialchars($a['Produkt']) ?></td>
            <td><?= htmlspecialchars($a['Preis']) ?></td>
            <td><?= htmlspecialchars($a['KategorieN']) ?></td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="aktion" value="order">
                    <input type="hidden" id="kunden_id" name="kunden_id" value="<?= isset($kunden_id) ? htmlspecialchars($kunden_id) : ''; ?>">
                    <input type="hidden" id="pay_id" name="pay_id" value="<?= isset($pay_id) ? htmlspecialchars($pay_id) : ''; ?>">
                    <input type="hidden" name="ProduktID" value="<?= $a['ProduktID'] ?>">
                    <?php if (isset($kunden_id)): ?>
                    <button type="submit">Bestellen</button>
                    <?php endif; ?>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <div id="warenkorb">
    <h2>Vorhander Warenkorb</h2>
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
                <form action="" method="post">
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
    </div>
    <!--<div id="konto">
      <h1>Hier können Konto auswählen</h1>
    </div> -->
    <div id="login">
      <h1>Anmelden</h1>
      <form action="" method="post">
        <div>
            <label for="LoginKundenName">Benutzername:</label>
            <input type="text" id="LoginKundenName" name="LoginKundenName" required>
        </div>
        <div>
            <label for="LoginPasswort">Passwort:</label>
            <input type="password" id="LoginPasswort" name="LoginPasswort" required>
        </div>
        <button type="submit">Anmelden</button>
      </form>
      <h1>Neukunden Registrierung:</h1>
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
    </div>
    <div id="admin">
      <h1>Alle Kunden</h1>
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
                <form action="" method="post">
                    <input type="hidden" name="aktion" value="custdelete">
                    <input type="hidden" id="kunden_id" name="kunden_id" value="<?= isset($a['KundenID']) ? htmlspecialchars($a['KundenID']) : ''; ?>">
                    <button type="submit">Löschen</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>
  </div>

 
<script src="script.js"></script>
</body