<?php
$pageTitle = 'Administration';
$page = 'shoppingdelete';
include './inc/header.inc.php';


function deletefromCart($kundenID, $produktID) {
    // Verbindung zur Datenbank
    $pdo = new PDO('mysql:host=localhost;dbname=warehousedb', 'root', 'root');
  
    $stmt = $pdo->prepare("DELETE FROM warenkorb WHERE KundenID = :KundenID AND ProduktID = :produktID");
    $stmt->execute(['KundenID' => $kundenID, 'produktID' => $produktID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
  }
  
  if (isset($_POST['aktion']) && $_POST['aktion'] === 'delete') {
    
    $produktID = $_POST['ProduktID'];
    $kunden_id = $_POST['kunden_id'];
  
    deletefromCart($kunden_id, $produktID);
    
    echo "<span style='color: white;'>Produkt wurde aus dem Warenkorb entfernt.</span><br>";
    
  }
?>
<button onclick="window.location.href='cart.php'">Zurück</button>
<button onclick="window.location.href='index.php'">Start-Seite</button>
<?php include './inc/footer.inc.php'; ?>