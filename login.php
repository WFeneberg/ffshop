<?php
$pageTitle = 'Anmelden';
$page = 'login';
include './inc/header.inc.php';
?>
<form action="logedin.php" method="post">
  <div>
    <input type="text" id="LoginKundenName" name="LoginKundenName" required>
    <label for="LoginKundenName"> Benutzername</label>
  </div>
  <div>
    <input type="password" id="LoginPasswort" name="LoginPasswort" required>
    <label for="LoginPasswort"> Passwort</label>
  </div>
  <button type="submit">Anmelden</button>
</form>
<?php include './inc/footer.inc.php'; ?>