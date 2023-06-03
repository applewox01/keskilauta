<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
              error_reporting(E_ALL);
              ini_set('display_errors', 1);    
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

       header('Content-Type:text/html; charset=UTF-8');
       $baseTiedosto = fopen("./baselink.txt", "r") or die("Ongelma tietokannassa");
       $baseLink = fgets($baseTiedosto);
       fclose($baseTiedosto);

    if (isset($_SESSION["user"])) {
        echo "<title>".$_SESSION["user"]." - asetukset</title>";
    } else {
        header("Location: ".$baseLink."/log-in/log.php");
        exit;
    };
    ?>
    <link rel="stylesheet" href="<?php echo $baseLink; ?>/css/style.css"> 
</head>
<body>
<header>
    <a href="<?php echo $baseLink; ?>/index.php">
  <h1 id="logo">Keskilauta</h1>
  <p id="logoSub"><i>Asiat suoraan, niinkuin ne on! Soomest Eestisse!</i></p>
</a>
</header>
<a href="<?php echo $baseLink; ?>/index.php"><= Takaisin- tuoreimmat</a>
    <?php
        $user = $_SESSION["user"];
        echo "<h3><b>Käyttäjä: ".$user."</b></h3>";

    ?>
    
    <form method="post" action="">
    <i>Kansa näkee lompakon osoitteen profiilissasi, voit sitten ryssätä heiltä hilloa lompakkoosi :)</i>
    <br>
    <b>BTC-lompakkosi osoite:</b>
    <br>
    <?php
    if(isset($_SESSION["btc"])) {
    echo '<input type="text" name="lompakko" value='.$_SESSION["btc"].'>';
    } else {
    echo '<input type="text" name="lompakko" value="">';
    };
    ?>
    <br>
    <input type="submit" name="update" value="Päivitä">
</form>
<?php
if(isset($_POST["update"])) {
    $lompakko = $_POST["lompakko"];

    $update = "UPDATE registered SET btc='$lompakko' WHERE username='$user' ";

if ($yhteys->query($update) === TRUE) {
    $_SESSION["btc"] = $lompakko;
    header("Location: ".$baseLink."/index.php");
    exit;
} else {
  echo "<b>Ongelma tietokannassa! Yritä myöhemmin uudelleen</b>";
};
 
};
?>
</body>
</html>