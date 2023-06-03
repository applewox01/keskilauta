<!DOCTYPE html>
<html lang="fi">
<head>
    <?php
        $baseTiedosto = fopen("./baselink.txt", "r") or die("Ongelma tietokannassa");
        $baseLink = fgets($baseTiedosto);
        fclose($baseTiedosto);
    session_start();
    $palvelin = "10.9.0.60";
    $kayttaja = "s2200813";  
    $salasana = "nQ8clyM4";
    $tietokanta = "s2200813_1";

    $yhteys = new mysqli($palvelin, $kayttaja, $salasana, $tietokanta);

    if ($yhteys->connect_error) {
        die("Yhteyden muodostaminen epäonnistui: " . $yhteys->connect_error);
     }
     // aseta merkistökoodaus (muuten ääkköset sekoavat)
     $yhteys->set_charset("utf8mb4");
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keskilauta - admin</title>
    <link rel="stylesheet" href="<?php echo $baseLink; ?>/css/style.css"> 
    <link rel="icon" href="<?php echo $baseLink; ?>/assets/logo.png">
</head>
<body>
    <header>
    <a href="<?php echo $baseLink; ?>/index.php">
  <h1 id="logo">Keskilauta</h1>
  <p id="logoSub"><i>Luo kirjoitus</i></p>
</a>
</header>
    <a href="<?php echo $baseLink; ?>/index.php"><= Takaisin - tuoreimmat</a>
    <br>
    <?php
    if(isset($_SESSION["admin"])) {
        if ($_SESSION["admin"] == 1) {
            echo '<h3><b>Poista uutinen</b></h3>';
            echo '<form action="" method="post">';
            echo '<label><b>Kirjoituksen ID:</b></label>';
            echo '<br>';
            echo '<input type="text" value="" name="id">';
            echo '<br>';
            echo '<input type="submit" name="poista">';
            echo '</form>';
            if(isset($_POST["poista"])) {
            $id = $_POST["id"];
            $delete = "DELETE FROM uutiset WHERE id='$id'";

            if ($yhteys->query($delete) === TRUE) {
                echo "<b>Poistettu</b>";
            } else {
                echo "<b>Tilanne! ".$yhteys->error."</b>";
            };
    };
        } else {
            echo '<img alt="totuus" src="'.$baseLink.'/assets/123.PNG">';
        };
    } else {
        echo '<img alt="totuus" src="'.$baseLink.'/assets/123.PNG">';
    };
    ?>

</body>
</html>