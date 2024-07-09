<?php
global $kunden_id;
global $pay_id;
global $Meldungen;


$pdo = new PDO('mysql:host=localhost;dbname=warehousedb', 'root', 'root');
// Verbindung zur Datenbank




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
  

  
   
   
    </div>
    <!--<div id="konto">
      <h1>Hier können Konto auswählen</h1>
    </div> -->
    <div id="login">
      <h1>Anmelden</h1>
    
      <h1>Neukunden Registrierung:</h1>
      
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