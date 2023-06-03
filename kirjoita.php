<!DOCTYPE html>
<html lang="fi">
<head>
    <?php
          error_reporting(E_ALL);
          ini_set('display_errors', 1);
    $baseTiedosto = fopen("./baselink.txt", "r") or die("Ongelma tietokannassa");
    $baseLink = fgets($baseTiedosto);
    fclose($baseTiedosto);
    ?>
    <meta charset="UTF-8">
    <link href="<?php echo $baseLink; ?>/css/style.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keksilauta.com - luo kirjoitelma</title>
    <link rel="icon" href="<?php echo $baseLink; ?>/assets/logo.png">
</head>

<body>
<header>
    <a href="<?php echo $baseLink; ?>">
  <h1 id="logo">Keskilauta</h1>
  <p id="logoSub"><i>Luo kirjoitus</i></p>
</a>
</header>
    <a href="<?php echo $baseLink; ?>"><b><= Takaisin - tuoreimmat</b></a>
    <?php

    session_start();
    if(isset($_SESSION["user"])) {
        header('Content-Type:text/html; charset=UTF-8');
        echo "<b> Käyttäjä: ".$_SESSION["user"]."</b>";
    } else {
        header("Location: ".$baseLink."/log-in/log.php");
        exit();
    };
    ?>
    <form action="" method="post">
        <input type="file" id="tiedosto" name="tiedosto" accept="image/*, video/*">
        <br>
        <input name="otsikko" style="width: 50%;" required placeholder="Otsikko *">
        <br>
        <b for="kategoria">Kategoria: </b>
        <br>
        <select name="kategoria">
        <option value="Tuoreimmat">Tuoreimmat</option>
        <option value="Merkonomi" >Merkonomi</option>
        <option value="Koodaus" >Koodaus</option>
        <option value="Yhteiskunta" >Yhteiskunta</option>
        </select>
        <br>
        <textarea style="max-width: 50%; min-width: 50%; min-height: 100px" width="50%" height="100px" name="sisalto" value="" placeholder="Sisältö">
        </textarea>
        <br>
        <input type="submit" name="kirjaa">
        <?php

 $palvelin = "10.9.0.60";
 $kayttaja = "s2200813";  
 $salasana = "nQ8clyM4";
 $tietokanta = "s2200813_1";

 $yhteys = new mysqli($palvelin, $kayttaja, $salasana, $tietokanta);

 if ($yhteys->connect_error) {
     die("Yhteyden muodostaminen epäonnistui: " . $yhteys->connect_error);
  }
  // aseta merkistökoodaus (muuten ääkköset sekoavat)
  $yhteys->set_charset("utf8");

        if(isset($_POST["kirjaa"])){

            $otsikko = $yhteys -> real_escape_string($_REQUEST["otsikko"]);
            $sisalto = $_REQUEST["sisalto"];

            $greenText = array();

            preg_match_all('/>.+>/mu', $sisalto, $greenText);

            foreach ($greenText[0] as $text) {
                $trimmed = substr($text, 0, -1);
                $sisalto = str_replace($text, "<span style='color: green;'>".$trimmed."</span>", $sisalto);
            };

            $sisalto = nl2br($sisalto);

            $sisalto =  $yhteys -> real_escape_string($sisalto);

            $kategoria = $_REQUEST["kategoria"];
            $user = $_SESSION["user"];
            $date = date("Y-m-d");
            $id = rand(0, 99999);
            $id = base64_encode($id);

            $insert = "INSERT INTO uutiset (id, kirjoittaja, sisalto, julkaisupaiva, otsikko, kategoria)
            VALUES ('$id','$user', '$sisalto', '$date','$otsikko','$kategoria')";
            if (mysqli_query($yhteys, $insert)) {
                header("Location: ".$baseLink."");
                exit;
              } else {
                echo "<b>Virhe tietokannassa!</b>";
              };
        };
        ?>
</form>
</body>
</html>