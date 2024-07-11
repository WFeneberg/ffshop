<?php
$pageTitle = 'Anmelden';
$page = 'logedin';
include './inc/header.inc.php';

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
            echo "Anmeldung erfolgreich.";

            $t = time() + 60 * 60 * 24 * 365;
            setcookie("KundenID", $kunden_id, $t);
            setcookie("PayID", $pay_id, $t);
        } else {

            echo "Anmeldung fehlgeschlagen.";
            setcookie("KundenID", '', $t);
            setcookie("PayID", '', $t);
        }
    }
}
?>

<?php include './inc/footer.inc.php'; ?>