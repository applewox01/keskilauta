<!DOCTYPE html>
<html lang="fi">
<head>
    <?php
    header('Content-Type:text/html; charset=UTF-8');
        $baseTiedosto = fopen("./baselink.txt", "r") or die("Ongelma tietokannassa");
        $baseLink = fgets($baseTiedosto);
        fclose($baseTiedosto);
    ?>
    <meta charset="UTF-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keskilauta.com - raportti</title>
    <link rel="icon" href="<?php echo $baseLink; ?>/assets/logo.png">
</head>
<body>
<a href="<?php echo $baseLink; ?>/index.php"><= Takaisin- tuoreimmat</a>
    <h3><b>Uutiset.com - Raportoi ongelma</b></h3>
    <form action="" method="post">
        <select>
        <option>Valitse ongelma</option>
        <option>Kirjautuminen/rekisteröityminen</option>
        <option>Muu</option>
</select>
<br>
    <b>Yksityiskohdat/selvennys:</b>
        <br>
        <textarea style="max-width: 50%; min-width: 50%;" width="50%">

        </textarea>
        <br>
        <input type="submit" name="report">
</form>
</body>
</html>