<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $pdo = new PDO('mysql:host=localhost;dbname=ffshop','root','root');
        $sql = "Select * from kunden";
        foreach ($pdo->query($sql) as $row) { ?>
           Name: <?php echo $row['Vorname']." "; ?>
           Nachname: <?php echo $row['Nachname']."<br/>"; ?>
            <?php
        }
    ?>
</body>
</html>