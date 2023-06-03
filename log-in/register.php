<!DOCTYPE html>
<html lang="fi">
  <!--TEST ED.-->
      <?php
      error_reporting(E_ALL);
      ini_set('display_errors', 1);

      session_start();
      
        $baseTiedosto = fopen("../baselink.txt", "r") or die("Ongelma tietokannassa");
        $baseLink = fgets($baseTiedosto);
        fclose($baseTiedosto);

        if (isset($_SESSION["user"])) {
          header("Location: ".$baseLink."");
        } else {
          header('Content-Type:text/html; charset=UTF-8');
        };

        $palvelin = "10.9.0.60";
        $kayttaja = "s2200813";  
        $salasana = "nQ8clyM4";
        $tietokanta = "s2200813_1";

    $yhteys = new mysqli($palvelin, $kayttaja, $salasana, $tietokanta);

    if ($yhteys->connect_error) {
        die("Yhteyden muodostaminen epäonnistui: " . $yhteys->connect_error);
     };
     // aseta merkistökoodaus (muuten ääkköset sekoavat)
     $yhteys->set_charset("utf8");
    ?>
<head>
<link href="<?php echo $baseLink; ?>/css/style.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keskilauta.com - rekisteröityminen</title>
    <link rel="icon" href="<?php echo $baseLink; ?>/assets/logo.png">
</head>
<body>
<img src="<?php echo $baseLink; ?>/assets/logo.png" alt="fisu" style="height: fit-content; width: 20%;">
<h3><b>Keskilauta.com - Rekisteröidy</b></h3>
<form method="post" action="">
<label for="username"><b>Käyttäjätunnus:</b></label>
<br>
<input type="text" name="username">
<br>
<label for="password"><b>Salasana:</b></label>
<br>
<input type="password" name="password" id="password">
<button id="showPass">Näytä salasana</button>
<script>
let button = document.getElementById("showPass");
let password = document.getElementById("password");
button.addEventListener("click", showOrHide);

let hidPass = true;
function showOrHide(event) {
event.preventDefault();
if (hidPass == true) {
  hidPass = false;
  button.innerHTML = "Piilota salasana";
  password.type = "text";
} else {
  hidPass = true;
  button.innerHTML = "Näytä salasana";
  password.type = "password";
};
}; 
///////////////////////
//TO DO LIST:
//SALASANASSA EI SAA OLLA ERITYISMERKKEJÄ, EIKÄ SAA OLLA TYHJÄ
//event default prevent
console.log("Js works!");
</script>
<br>
<ul>
  <li><b>min. 8 merkkiä, max. 50 merkkiä</b></li>
  <li><b>ei erikoismerkkejä</b></li>
    </ul>
<input type="submit" name="reg" value="Rekisteröidy">
<?php

if(isset($_POST["reg"])) {

$originalUsername = $_POST["username"];
$originalPassword = $_POST["password"];

$username = $yhteys->real_escape_string(strip_tags($_POST["username"]));
$password = $yhteys->real_escape_string(strip_tags($_POST["password"]));

$encodedUser = password_hash($username, PASSWORD_DEFAULT);
$encodedPass = password_hash($password, PASSWORD_DEFAULT);

$valid = true;

if ($username != $originalUsername || $password != $originalPassword) {
  $valid = false;
  echo "<p><b>Kelvoton tunnus: </b>ei erikoismerkkejä</p>";
};
if (strlen($username) < 8 || strlen($password) < 8) {
  $valid = false;
  echo "<p><b>Kelvoton tunnus: </b>min. 8 merkkiä, liian lyhyt</p>";
} elseif (strlen($username) > 50 || strlen($password) > 50) {
  $valid = false;
  echo "<p><b>Kelvoton tunnus: </b>max. 50 merkkiä, liian pitkä</p>";
};

$result = "SELECT * FROM registered WHERE username = '$encodedUser' ";
$tulokset = $yhteys->query($result);
if($tulokset->num_rows > 0 ){
 //löytyi
 echo "<p>käyttäjätunnus on varattu</p>";
} else {
    //eli ei löytynyt
    if ($valid == true) {
    $insert = "INSERT INTO registered (admin, password, username) 
    VALUES (0, '$encodedPass', '$encodedUser')";
    if ($yhteys->query($insert) == true) {
        echo "<p>Käyttäjä luotu</p>";
        echo "".$baseLink."/log-in/log.php";
        $yhteys->close();
        header("Location: ".$baseLink."/log-in/log.php");
        exit;
      } else {
        echo "<b>Virhe tietokannassa!</b>";
      };
    };
};
};
?>
</form>
<a href="<?php echo $baseLink; ?>/log-in/log.php">Kirjaudu sisään täällä</a>
<br>
<a href="<?php echo $baseLink; ?>/report.php">Raportoi ongelma</a>
<br>
<a href="<?php echo $baseLink; ?>">Jatka rekisteröitymättä</a>
</body>
</html>