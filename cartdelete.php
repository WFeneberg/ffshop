<?php
$pageTitle = 'Administration';
$page = 'shoppingdelete';
include './inc/header.inc.php';

$pdo = new PDO('mysql:host=localhost;dbname=warehousedb', 'root', 'root');

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
    
    echo "Produkt wurde aus dem Warenkorb entfernt.";
    
  }
?>

<?php include './inc/footer.inc.php'; ?>