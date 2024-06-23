<?php
global $kunden_id;
global $Meldungen;


$pdo = new PDO('mysql:host=localhost;dbname=warehousedb', 'root', 'root');
// Verbindung zur Datenbank

$artikel = $pdo->query("SELECT * FROM lager")->fetchAll();


if (isset($_POST['KundenName'], $_POST['Passwort'])) {
	
	// 	Kunden hinzufügen
	$stmt = $pdo->prepare("INSERT INTO kunden (KundenName, Passwort) VALUES (:KundenName, :Passwort)");
	
	$stmt->execute([':KundenName' => $_POST['KundenName'], ':Passwort' =>$_POST['Passwort']]);
	
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
	
}


if (isset($_POST['LoginKundenName'], $_POST['LoginPasswort'])) {
	
	// 	Beim Anmelden
	$eingegebenesPasswort = $_POST['LoginPasswort'];
	// 	Das vom Benutzer beim Anmelden eingegebene Passwort
	$stmt = $pdo->prepare("Select KundenID, Passwort FROM kunden WHERE KundenName = :LoginKundenName");
	
	$stmt->execute(['LoginKundenName' => $_POST['LoginKundenName']]);
	
	$user = $stmt->fetch();
  if ($user === false) {
    $Meldungen = "Benutzername nicht gefunden oder falsches Passwort.";
} else {
	// 	Benutzerdaten aus der Datenbank abrufen
	$gespeichertesPasswort = $user['Passwort'];
	// 	Das in der Datenbank gespeicherte Passwort
	$kunden_id = $user['KundenID'];
	// 	Die Kunden-ID des Benutzers
	if ($eingegebenesPasswort === $gespeichertesPasswort) {
		$Meldungen = "Anmeldung erfolgreich.";
	}
	else {
		
		$Meldungen =  "Anmeldung fehlgeschlagen.";
		
	}
}
	
}


?>

<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Computer Fakeshop</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('./asset/Hintergrund.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      color: #FFFFFF;
    }

    body::before {
      content: "";
      position: fixed;
      /* oder 'absolute', falls 'fixed' nicht gewünscht ist */
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('./asset/Hintergrund.jpg') no-repeat center center fixed;
      background-size: cover;
      z-index: -1;
      opacity: 0.9;
    }

    nav#menu {
      background-color: blue;
      /* Setzt die Hintergrundfarbe auf Blau */
      width: 100%;
      /* Stellt sicher, dass das Menü die volle Breite einnimmt */
      position: fixed;
      /* Fixiert das Menü am oberen Rand */
      top: 0;
      left: 0;
      z-index: 1000;
      /* Stellt sicher, dass das Menü über anderen Elementen liegt */
    }

    nav#menu ul {
      list-style-type: none;
      /* Entfernt die Bulletpoints von der Liste */
      text-align: center;
      /* Zentriert die Listenelemente */
    }

    nav#menu li {
      display: inline;
      /* Zeigt die Listenelemente nebeneinander an */
      margin-right: 20px;
      /* Fügt einen rechten Abstand zwischen den Listenelementen hinzu */
    }

    nav#menu a {
      color: white;
      /* Setzt die Textfarbe der Links auf Weiß */
      text-decoration: none;
      /* Entfernt die Unterstreichung der Links */
    }
  </style>
</head>

<body>
  <nav id="menu">
    <ul>
      <li><a href="#" onclick="showHome()">Home</a></li>
      <li><a href="#" onclick="showWarenkorb()">Warenkorb</a></li>
      <li><a href="#" onclick="showKonto()">Konto</a></li>
      <li><a href="#" onclick="showLogin()">Anmeldung</a></li>
      <li><a href="#" onclick="showAdmin()">Verwaltung</a></li>
    </ul>
  </nav>

  <div id="content">
    <div id="home">
      <h1>Willkommen auf der Home-Seite!</h1>
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
            <td><?= htmlspecialchars($a['KategorieID']) ?></td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="aktion" value="order">
                    <input type="hidden" name="ProduktID" value="<?= $a['ProduktID'] ?>">
                    <button type="submit">Bestellen</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <div id="warenkorb">
      <h1>Hier ist Ihr Warenkorb</h1>
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
        
        <input type="submit" value="Kunden hinzufügen">
    </form>
    </div>
    <!--<div id="admin">
      <h1>Hier können admin auswählen</h1>
    </div> -->
  </div>

  <script>
    showHome();
    function updatemenu() {
      if (document.getElementById('responsive-menu').checked) {
        document.getElementById('menu').style.borderBottomRightRadius = '0';
        document.getElementById('menu').style.borderBottomLeftRadius = '0';
      } else {
        document.getElementById('menu').style.borderRadius = '10px';
      }
    }

    function showHome() {
      hideAll();
      document.getElementById('home').style.display = 'block';
    }

    function showKonto() {
      hideAll();
      document.getElementById('konto').style.display = 'block';
    }

    function showWarenkorb() {
      hideAll();
      document.getElementById('warenkorb').style.display = 'block';
    }

    function showLogin() {
      hideAll();
      document.getElementById('login').style.display = 'block';
    }

    function showAdmin() {
      hideAll();
      document.getElementById('admin').style.display = 'block';
    }

    function hideAll() {
      var sections = document.querySelectorAll('#content > div');
      sections.forEach(function(section) {
        section.style.display = 'none';
      });
    }

    function login(event) {
      event.preventDefault();
      // Hier können Sie die Authentifizierung hinzufügen
      // Wenn erfolgreich, wird die Anmeldeseite ausgeblendet und die Home-Seite sowie das Menü angezeigt
      document.getElementById('login').style.display = 'none';
      document.getElementById('menu').style.display = 'block';
      document.getElementById('content').style.display = 'block';
      showHome();
    }
  </script>
  <footer>
    <div class="footer-content">
        <p>Kunden-ID: <?= isset($kunden_id) ? htmlspecialchars($kunden_id) : 'Nicht verfügbar'; ?></p>
        <p>Meldungen: <?= isset($Meldungen) ? htmlspecialchars($Meldungen) : 'Keine Meldungen'; ?></p>
    </div>
</footer>
</body