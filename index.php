<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
          error_reporting(E_ALL);
          ini_set('display_errors', 1);

    header('Content-Type:text/html; charset=UTF-8');
      $baseTiedosto = fopen("baselink.txt", "r") or die("Ongelma tietokannassa");
      $baseLink = fgets($baseTiedosto);
      fclose($baseTiedosto);
  ?>
    <link href="<?php echo $baseLink; ?>/css/style.css" rel="stylesheet">
    <link rel="icon" href="<?php echo $baseLink; ?>/assets/logo.png">
    <script src="<?php echo $baseLink; ?>/js/refresh.js"></script>
    <script src="<?php echo $baseLink; ?>/js/main.js"></script>
    <?php
    
    session_start();

       $palvelin = "10.9.0.60";
       $kayttaja = "s2200813";  
       $salasana = "nQ8clyM4";
       $tietokanta = "s2200813_1";

   $yhteys = new mysqli($palvelin, $kayttaja, $salasana, $tietokanta);

   if ($yhteys->connect_error) {
       die("Yhteyden muodostaminen epäonnistui: " . $yhteys->connect_error);
    };
    $yhteys->set_charset("utf8");

    echo "<title>Keskilauta</title>";
    ?>
</head>
<body>
    <header>
      <a href="<?php echo $baseLink; ?>/index.php">
  <h1 id="logo">Keskilauta</h1>
  <p id="logoSub"><i>Jne, jne, jne...</i></p>
  <!--<img alt="fisu" src="./logo.png" style="height: 100px; width: fit-content; margin-left: auto; margin-right: auto;">-->
</a>
<div id="logoList">
<?php

if (isset($_SESSION["user"])) {
  $user = $_SESSION["user"];
  echo '<p id="kirjButton" class="hoverButton"><b>Kirjauduttu sisään: </b>'.$user.'</p>';
} else {
  echo "<a href='$baseLink/log-in/log.php/' class='hoverButton'><b>Kirjaudu sisään</b></a>";
  $anonID = rand(0, 9999999);
$_SESSION["anonID"] = $anonID;
};
?>
<a class="hoverButton" href="<?php echo $baseLink; ?>/kirjoita.php/"><b>Luo kirjoitelma</b></a>
</div>
</header>
<br>
<div class="hidden" id="hiddenList">
    <h3><b>Käyttäjä</b></h3>
    <?php
      if (isset($_SESSION["btc"])) {
        if ($_SESSION["btc"] != null) {
    echo "<a href='https://www.blockonomics.co/#/search?q=".$_SESSION["btc"]."' class='userMenuButton'><b>BTC-lompakko: ".$_SESSION["btc"]."</b></a>";
  } else {
    echo "<b style='color: white;'>BTC-lompakko: ei merkittynä</b>";
  };
    } else {
      echo "<b style='color: white;'>BTC-lompakko: ei merkittynä</b>";
    };
    ?>
    <br>
    <a href="<?php echo $baseLink; ?>/asetukset.php" class="userMenuButton"><b>Asetukset</b></a>
    <br>
    <a href="<?php echo $baseLink; ?>/logout.php" class="userMenuButton"><b>Kirjaudu ulos</b></a>
    <br>
    <?php
    if (isset($_SESSION["admin"])) {
      if ($_SESSION["admin"] == 1) {
        echo "<a href='$baseLink/admin.php' class='userMenuButton'><b>Admin</b></a>";
      };
    };
    ?>
</div>
<main>
  <div id="mainList">

  <?php

if (isset($_GET["artikkeli"])) {
$artikkeli = $_GET["artikkeli"];

$haeArtikkeli = "SELECT * FROM uutiset WHERE id='$artikkeli'";
$tulokset = $yhteys->query($haeArtikkeli);

if ($tulokset->num_rows > 0) {

   while($rivi = $tulokset->fetch_assoc()) {
    echo '<a href="'.$baseLink.'/index.php"><b><= Takaisin - tuoreimmat</b></a>';
    echo '<article id="articleIdGET" data-id="'.$_GET["artikkeli"].'">';
    echo '<div style="width: 100%; height: 10%;">';
    if (isset($_SESSION["user"])) {
      if ($_SESSION["user"] == $rivi["kirjoittaja"]) {
        echo '<div class="articleIconButton" class="far fa-trash-alt">&#xf2ed;</div>';
      } else {
        echo '<div class="articleIconButton" class="far fa-flag">&#xf425;</div>';
      };
    };
    echo '</div>';
    echo '<h3><b>'.$rivi["otsikko"].'</b></h3>';
    echo '<p class="showProfile"  author='.$rivi["kirjoittaja"].'>'.$rivi["kirjoittaja"]. ' || ' .$rivi["julkaisupaiva"].'</p>';
    echo '<div class="shownPFP'.$rivi["kirjoittaja"].'" hidden>';
    echo '<b>BTC-lompakko: </b>';
    $haeBTC = " SELECT * FROM registered WHERE username='".$rivi["kirjoittaja"]."' ";
$tuloksetBTC = $yhteys->query($haeBTC);

// jos tulosrivejä löytyi
if ($tuloksetBTC->num_rows > 0) {

   while($BTCrivi = $tuloksetBTC->fetch_assoc()) {
    echo '<a href="https://www.blockonomics.co/#/search?q='.$BTCrivi["btc"].'"><b>'.$BTCrivi["btc"].'</b></a>';
   };
  } else {
    echo '<b>Ei merkittynä</b>';
  };
    echo '</div>';
    echo '<b>'.$rivi["tykkaykset"].' tykkää</b>';
    echo '<div style="width: 100%; height: 10%;">';
    if (isset($_SESSION["user"])) {
        echo '<div class="articleIconButton">&#xf118;</div>';
        echo '<div class="articleIconButton">&#xf556;</div>';
    };
    echo '</div>';
    echo "<p>".$rivi["sisalto"]."</p>";
    echo '<h3><b>Kommentit</b></h3>';
   };
   echo '<form action="" method="post">';
   echo '<input type="submit" name="luoKommentti" value="Lähetä" id="laheta">';
   echo "<br>";
   echo '<textarea value="" placeholder="Jätä kommentti..." name="sisalto" id="sisalto" style="width: 90%; max-width: 90%; min-width: 90%;">';
   echo '</textarea>';
   echo "<br>";
   echo '</form>';
   echo "<div id='kommentit'>";
   ?>
   <?php
   echo "</div>";
   echo "<br>";
   echo '</article>';
  
   if(isset($_POST["luoKommentti"])){
    $kommenttiSisalto = $_POST["sisalto"];
    $id = $_GET["artikkeli"];
    $date = date("Y-m-d");
    if(isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
    } else {
    $user = $_SESSION["anonID"];
    };
    $insert = "INSERT INTO kommentit (id, julkaisupaiva, kirjoittaja, sisalto) 
    VALUES ('$id', '$date', '$user','$kommenttiSisalto')";
    if (mysqli_query($yhteys, $insert)) {
  
    } else {
      echo "Virhe tietokannassa!";
    };
   };
  } else {
    echo "<b>Ei tuloksia!</b>";
    echo "<img alt='error' src='$baseLink/assets/fisuerror.png' style='height: 20%; width: fit-content;'>";
  };
}
else { 

if (isset($_GET["kategoria"])) {
$kategoria = $_GET["kategoria"];
$haeSaa = "SELECT * FROM uutiset WHERE kategoria = '$kategoria' ORDER BY julkaisupaiva DESC";
echo "<h3><b>Kategoria: $kategoria</b></h3>";
} else {
$haeSaa = "SELECT * FROM uutiset ORDER BY julkaisupaiva DESC";
echo "<h3><b>Tuoreimmat kirjoitukset</b></h3>";
};
$tulokset = $yhteys->query($haeSaa);



// jos tulosrivejä löytyi
if ($tulokset->num_rows > 0) {

   while($rivi = $tulokset->fetch_assoc()) {
    echo '<article>';
    echo "<a style='display: flex;' href=' $baseLink/index.php?artikkeli=".$rivi["id"]." '>";
    if ($rivi["status"] == "admin") {
      echo '<div style="width: 2%; height; 100%; background-color: purple;"></div>';
    } elseif ($rivi["status"] == "kulta") {
      echo '<div style="width: 2%; height; 100%; background-color: yellow;"></div>';
    } else {
      echo '<div style="width: 2%; height; 100%; background-color: grey;"></div>';
    };
    echo '<div style="width: 97%;">';
    echo '<b>'.$rivi["kategoria"].'</b>';
    echo '<h3 class="otsikkoShort"><b>'.$rivi["otsikko"].'</b></h3>';
    echo '<p class="showProfile" author='.$rivi["kirjoittaja"].'>'.$rivi["kirjoittaja"].' || ' .$rivi["julkaisupaiva"].'</p>';
    echo '</div>';
    echo "</a>";
    echo '</article>';
    echo "<br>";
   };

  } else {
    echo "<b>Kenties <a href='https://ylilauta.org/thread/'>ylilauta</a> on ruuhkaisempi?</b>";
    echo "<img alt='servut' src='$baseLink/assets/servers.png' style='height: 20%; width: fit-content;'>";
  };
};
  ?>

</div>
<aside>
<img alt="fish" src="<?php echo $baseLink; ?>/assets/logo.png" style="width: inherit; height: fit-content; margin-left: auto; margin-right: auto; display: block;">
<br>
<a href="<?php echo $baseLink; ?>/report.php" class="asideLink"><b>Raportoi ongelma</b></a>
  <a href="<?php echo $baseLink; ?>/report.php" class="asideLink"><b>Säännöt, jne</b></a>
  <h3 class="blueBackground">Kanalid</h3>
  <a href="<?php echo $baseLink; ?>/index.php/" class="asideLink"><b>tuoreimmat</b></a>
  <a href="<?php echo $baseLink; ?>/index.php/?kategoria=Arki" class="asideLink"><b>arki</b></a>
  <a href="<?php echo $baseLink; ?>/index.php/?kategoria=Yhteiskunta" class="asideLink"><b>talous & yhteiskunta</b></a>
  <a href="<?php echo $baseLink; ?>/index.php/?kategoria=Merkonomi" class="asideLink"><b>merkonomit having a normal one</b></a>
  <a href="<?php echo $baseLink; ?>/index.php/?kategoria=Koodaus" class="asideLink"><b>koodaus</b></a>
<h3 class="blueBackground">Suosituimmat kirjoitukset tänään</h3>
<?php
$date = date("Y-m-d");
$haeArtikkeli = "SELECT * FROM uutiset WHERE julkaisupaiva = '$date' ORDER BY tykkaykset LIMIT 10";
$tulokset = $yhteys->query($haeArtikkeli);

// jos tulosrivejä löytyi
if ($tulokset->num_rows > 0) {

   while($rivi = $tulokset->fetch_assoc()) {
    echo "<div class='asideArticle'>";
    echo "<a class='noDecA' href='http://localhost/harjoitusteht/uutiset/index.php/?artikkeli=".$rivi["id"]." '>";
    echo '<h3 class="otsikkoShort"><b>'.$rivi["otsikko"].'</b></h3>';
    echo '<p><b>'.$rivi["tykkaykset"].' tykkää</b></p>';
    echo '<p class="showProfile" author="'.$rivi["kirjoittaja"].'>'.$rivi["kirjoittaja"].'" || ' .$rivi["julkaisupaiva"].'</p>';
    echo '<div id="showAddress'.$rivi["kirjoittaja"].'">';
    echo '</div>';
    echo "</a>";
    echo "</div>";
    echo "<br>";
   };
  } else {
    echo "<b>Tänään näyttää olevan hiljaista..</b>";
  };
?>
</aside>
</main>
</body>
</html>