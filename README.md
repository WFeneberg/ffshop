# ffshop

Fehler: 
Beim Löschen aus dem Warenkorb, verliert der Shop die Payid. Löschen geht irgendwie nicht. Man muss sich jedemal neu anmelden.

Lösung:

Cookie verwenden:
$vorname = htmlentities($_POST["vorname"]);
$nachname = htmlentities($_POST["nachname"]);
$t = time() + 60 * 60 * 24 * 365;
setcookie("vorname", $vorname, $t);
setcookie("nachname", $nachname, $t);

Auslesen:
if(isset($_COOKIE["vorname"]))
      echo $_COOKIE["vorname"];
   echo "'> Vorname</p>";

   echo "<p><input name='nachname' size='20' value='";
   if(isset($_COOKIE["nachname"]))
      echo $_COOKIE["nachname"];
   echo "'> Nachname</p>";