<?php
$pageTitle = 'Administration';
$page = 'shoppingdelete';
include './inc/header.inc.php';

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
  
  echo "<span style='color: white;'>Produkt wurde zum Warenkorb hinzugefügt.</span><br>";
  
}

?>
<button onclick="window.location.href='index.php'">Zurück</button>
<button onclick="window.location.href='cart.php'">Wartenkorb</button>
<?php include './inc/footer.inc.php'; ?>