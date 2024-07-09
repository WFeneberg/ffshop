<?php 
$pageTitle = 'Anmelden';
$page = 'login';
include './inc/header.inc.php'; 
?>
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
<?php include './inc/footer.inc.php'; ?>