<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.png">
    <?php
    if (isset($_GET["otsikko"])) {
      echo "<title>".$_GET["otsikko"]."</title>";
    } else {
      echo "<title>Keskilauta</title>";
    }
    ?>
</head>
<style>
  header, footer {
    background-color: blue;
    color: white;
    margin: 0;
}

footer {
  width: 70%;
}


p, h3 {
    margin: 0;
}

.noDecA {
  text-decoration: none;
  color: black;
}


.subText {
    opacity: 50%;
}

body {
    margin: 0;
}

#mainList {
    width: 80%;
}

#logo, #logoSub, footer i {
    text-align: center;
    margin: 0;
}

hr {
    border: 3px dashed blue;
}

#logoList {
    display: flex;
    width: 100%;
}

#logoList a, #logoList p {
    margin: auto;
}

.comment {
    background-color: lightgrey;
}


#logoFront {
    width: 100%;
}


.articleP {
    white-space: break-spaces;
}

footer a, header a {
    text-decoration: none;
    color: white;
}

main {
    display: flex;
}

article {
    width: 70%;
    background-color: lightskyblue;
}

.asideArticle {
  background-color: lightskyblue;
}

aside {
    width: 30%;
    background-color: lightblue;
    position: fixed;
    overflow: auto;
    right: 0;
}

.blueBackground {
    background-color: blue;
    color: white;
}

* {
    font-family: Verdana, Geneva, Tahoma, sans-serif;
}
::selection {
background-color: yellow;
} 

.hidden {
  display: none;
}

.hoverButton:hover {
  background-color: white;
  color: black;
}

.userMenuButton {
  text-decoration: none;
    color: white;
}

.userMenuButton:hover {
  background-color: white;
  color: black;
}

.listVisible {
  background-color: blue;

}

.asideLink {
  color: black;
  text-decoration: none;
  text-align: center;
  width: 100%;
  display: block;
}


.asideLink:hover {
  background-color: black;
  color: white;
}

.otsikkoShort {
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}

footer p {
  text-align: center;
}
</style>
<body>
    <header>
      <a href="./sivusto.php">
  <h1 id="logo">Diskursus.com / Keskilauta</h1>
  <p id="logoSub"><i>Asiat suoraan, niinkuin ne on! Soomest Eestisse!</i></p>
  <!--<img alt="fisu" src="./logo.png" style="height: 100px; width: fit-content; margin-left: auto; margin-right: auto;">-->
</a>
<div id="logoList">
  <a class="hoverButton"><b>Koti</b></a>
<?php

$palvelin = "localhost";
$kayttaja = "root";  
$salasana = "";
$tietokanta = "users";



$yhteys = new mysqli($palvelin, $kayttaja, $salasana, $tietokanta);


if ($yhteys->connect_error) {
   die("Yhteyden muodostaminen epäonnistui: " . $yhteys->connect_error);
}

$yhteys->set_charset("utf8");

session_start();


if (isset($_SESSION["user"])) {
  $user = $_SESSION["user"];
  echo '<p id="kirjButton" class="hoverButton"><b>Kirjauduttu sisään: </b>'.$user.'</p>';
} else {
  echo "<a href='./log-in/log.php/' class='hoverButton'><b>Kirjaudu sisään</b></a>";
};
?>
<a class="hoverButton" href="./kirjoita.php/"><b>Luo kirjoitelma</b></a>
</div>
</header>
<br>
<div class="hidden" id="hiddenList">
    <h3><b>Käyttäjä</b></h3>
    <a href="./logout.php/" class="userMenuButton"><b>Kirjaudu ulos</b></a>
    <br>
    <?php
    if (isset($_SESSION["admin"])) {
      if ($_SESSION["admin"] == 1) {
        echo "<a href='./admin.php/' class='userMenuButton'><b>Admin</b></a>";
      };
    };
    ?>
</div>
<script>

  if (document.getElementById("kirjButton")) {
  let list = document.getElementById("hiddenList");
  let button = document.getElementById("kirjButton");

  button.addEventListener("click", listVisibility);

  function listVisibility(event) {
    event.preventDefault();
    if (list.className == "hidden") {
      list.className = "listVisible";
    } else {
      list.className = "hidden";
    }
  };
};
  </script>

<main>
  <div id="mainList">

<!--<h3><b>Lorem ipsumLorme</b></h3>
<p class="subText">12.000 244 77// iieiei</p>
<p class="articleP">Lst laborum.</p>
<div>
  <h3><b>Kommentit</b></h3>
  <b>Lähetä kommentti</b>
  <form method="post" action="">
  <textarea style="max-width: 50%; min-width: 50%;">

  </textarea>
  <br>
  <input type="submit" name="send">
  </form> --> 

  <?php

if (isset($_GET["artikkeli"])) {
$artikkeli = $_GET["artikkeli"];
$haeSaa = "SELECT * FROM uutiset WHERE id='$artikkeli'";
$tulokset = $yhteys->query($haeSaa);

// jos tulosrivejä löytyi
if ($tulokset->num_rows > 0) {

   while($rivi = $tulokset->fetch_assoc()) {
    echo '<a href="./sivusto.php/"><b><= Takaisin - tuoreimmat</b></a>';
    echo '<article>';
    echo '<h3><b>'.$rivi["otsikko"].'</b></h3>';
    echo '<p class="subText">'.$rivi["kirjoittaja"]. ' || ' .$rivi["julkaisupaiva"].'</p>';
    echo "<p>".$rivi["sisalto"]."</p>";
    echo '<h3><b>Kommentit</b></h3>';
    echo '</article>';
   };

  } else {
    echo "Ei tuloksia!";
  };
}
else { 
  echo "<h3><b>Tuoreimmat kirjoitukset</b></h3>";
$haeSaa = "SELECT * FROM uutiset ORDER BY julkaisupaiva DESC";
$tulokset = $yhteys->query($haeSaa);

// jos tulosrivejä löytyi
if ($tulokset->num_rows > 0) {

   while($rivi = $tulokset->fetch_assoc()) {
    echo '<article>';
    echo "<a href='./sivusto.php?artikkeli=".$rivi["id"]."&otsikko=".$rivi["otsikko"]."'>";
    echo '<h3 class="otsikkoShort"><b>'.$rivi["otsikko"].'</b></h3>';
    echo '<p class="subText">'.$rivi["kirjoittaja"]. ' || ' .$rivi["julkaisupaiva"].'</p>';
    echo "</a>";
    echo '</article>';
    echo "<br>";
   };

  } else {
    echo "Ei tuloksia!";
  };
};
  ?>

</div>
<aside>
<img alt="fish" src="./logo.png" style="width: inherit; height: fit-content; margin-left: auto; margin-right: auto; display: block;">
<br>
<a href="./report.php" class="asideLink"><b>Raportoi ongelma</b></a>
  <a href="./report.php" class="asideLink"><b>Säännöt, jne</b></a>
  <h3 class="blueBackground">Kanalid</h3>

<h3 class="blueBackground">Suosituimmat kirjoitukset</h3>
<?php
$haeArtikkeli = "SELECT * FROM uutiset ORDER BY tykkaykset ";
$tulokset = $yhteys->query($haeArtikkeli);

// jos tulosrivejä löytyi
if ($tulokset->num_rows > 0) {

   while($rivi = $tulokset->fetch_assoc()) {
    echo "<div class='asideArticle'>";
    echo "<a class='noDecA' href='./sivusto.php?artikkeli=".$rivi["id"]."&otsikko=".$rivi["otsikko"]."'>";
    echo '<h3 class="otsikkoShort"><b>'.$rivi["otsikko"].'</b></h3>';
    echo '<p><b>'.$rivi["tykkaykset"].' tykkää</b></p>';
    echo '<p class="subText">'.$rivi["kirjoittaja"]. ' || ' .$rivi["julkaisupaiva"].'</p>';
    echo "</a>";
    echo "</div>";
    echo "<br>";
   };
  };
?>
</aside>
</main>
</body>
</html>