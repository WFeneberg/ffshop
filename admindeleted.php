<?php
$pageTitle = 'Administration';
$page = 'admindeleted';
include './inc/header.inc.php';

$pdo = new PDO('mysql:host=localhost;dbname=warehousedb', 'root', 'root');

function deletecustomer($kundenID)
{
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

  echo "Kunde " . $kunden_id . " wurde gelöscht";
}
?>

<?php include './inc/footer.inc.php'; ?>