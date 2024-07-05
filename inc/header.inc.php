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
            <a <?php if(!empty($page) && $page === 'helsinki'):?> style="background-color: blue;" <?php endif; ?> href="helsinki.php">Helsinki</a>
            <a <?php if(!empty($page) && $page === 'mallorca'):?> style="background-color: green;" <?php endif; ?>href="mallorca.php">Mallorca</a>
        </nav>
    </header>

    <main>
        <h2><?php echo (!empty($pageTitle)) ? $pageTitle : 'Fakeshop'; ?></h2>