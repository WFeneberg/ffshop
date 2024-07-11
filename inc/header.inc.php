<?php 
    if(isset($_COOKIE["KundenID"]))
        $kunden_id =  $_COOKIE["KundenID"];
    if(isset($_COOKIE["PayID"]))
        $pay_id =  $_COOKIE["PayID"];

    $pdo = new PDO('mysql:host=localhost;dbname=warehousedb', 'root', 'root');

?><

!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="styles.css">
    <title><?php echo (!empty($pageTitle)) ? $pageTitle : 'Fakeshop'; ?></title>
</head>
<body>
    <header>
        <h1>>Computer Fakeshop<</h1>

        <nav  class="nav-container">
            <form action="./" method="get">
                <button type="submit" class="nav-button <?php if(!empty($page) && $page === 'index') echo 'active'; ?>">Startseite</button>
            </form>
            <form action="cart.php" method="get">
                <button type="submit" class="nav-button <?php if(!empty($page) && $page === 'shopping') echo 'active'; ?>">Warenkorb</button>
            </form>
            <form action="login.php" method="get">
                <button type="submit" class="nav-button <?php if(!empty($page) && $page === 'login') echo 'active'; ?>">Anmelden</button>
            </form>
            <form action="register.php" method="get">
                <button type="submit" class="nav-button <?php if(!empty($page) && $page === 'register') echo 'active'; ?>">Registrieren</button>
            </form>
            <form action="admin.php" method="get">
                <button type="submit" class="nav-button <?php if(!empty($page) && $page === 'admin') echo 'active'; ?>">Administration</button>
            </form>
        </nav>
    </header>

    <main>
        <h2><?php echo (!empty($pageTitle)) ? $pageTitle : 'Fakeshop'; ?></h2>