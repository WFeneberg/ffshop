<?php 
$pageTitle = 'Administration';
$page = 'registered';
include './inc/header.inc.php'; 

$pdo = new PDO('mysql:host=localhost;dbname=warehousedb', 'root', 'root');

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


<?php include './inc/footer.inc.php'; ?>