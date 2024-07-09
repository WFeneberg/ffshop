<!DOCTYPE html>
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

        <nav>
            <a <?php if(!empty($page) && $page === 'index'):?> style="background-color: red;" <?php endif; ?> href="./">Startseite</a>
            <a <?php if(!empty($page) && $page === 'shopping'):?> style="background-color: blue;" <?php endif; ?> href="cart.php">Warenkorb</a>
            <a <?php if(!empty($page) && $page === 'login'):?> style="background-color: green;" <?php endif; ?>href="login.php">Anmelden</a>
            <a <?php if(!empty($page) && $page === 'register'):?> style="background-color: yellow;" <?php endif; ?>href="register.php">Registrieren</a>
            <a <?php if(!empty($page) && $page === 'admin'):?> style="background-color: white;" <?php endif; ?>href="admin.php">Administration</a>
            </nav>
    </header>

    <main>
        <h2><?php echo (!empty($pageTitle)) ? $pageTitle : 'Fakeshop'; ?></h2>