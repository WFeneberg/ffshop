<?php 
$pageTitle = 'Abmelden';
$page = 'logout';
include './inc/header.inc.php'; 

if (isset($_SERVER['HTTP_COOKIE'])) {
    $t = time() + 60 * 60 * 24 * 365;
            echo "<span style='color: white;'>Kunde abgemeldet.</span><br>";

            setcookie("KundenID", '', $t);
            setcookie("PayID", '', $t);
}
?>
<button onclick="window.location.href='index.php'">Start-Seite</button>
<?php include './inc/footer.inc.php'; ?>