<!DOCTYPE html>
<html lang="fi">
    <?php
    if (isset($_SESSION["user"])) {
    session_unset();
    };
    session_start();
    $palvelin = "localhost";
    $kayttaja = "root";  
    $salasana = "";
    $tietokanta = "users";

    $yhteys = new mysqli($palvelin, $kayttaja, $salasana, $tietokanta);

    if ($yhteys->connect_error) {
        die("Yhteyden muodostaminen epäonnistui: " . $yhteys->connect_error);
     }
     // aseta merkistökoodaus (muuten ääkköset sekoavat)
     $yhteys->set_charset("utf8");
    ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uutiset.com - kirjaudu sisään</title>
</head>
<body>

<h3><b>Uutiset.com - Kirjaudu sisään</b></h3>
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
<input type="submit" name="log" value="Kirjaudu sisään">
<?php
if(isset($_POST["log"])) {
$username = $yhteys->real_escape_string(strip_tags($_POST["username"]));
$password = $yhteys->real_escape_string(strip_tags($_POST["password"]));


$result = "SELECT * FROM registered";
$tulokset = $yhteys->query($result);

if($tulokset->num_rows > 0 ){
 //tämä toimii, mutta on ehkä hidasta noutaa kaikki...
 while($rivi = $tulokset->fetch_assoc()) {
  $verifyPass = password_verify($password, $rivi["password"]);
  $verifyUser = password_verify($username, $rivi["username"]);
 if ($verifyPass && $verifyUser) {
    $_SESSION["user"] = $username;
    $_SESSION["admin"] = $rivi["admin"];
    header("Location: ../sivusto.php/");
    exit();
 };
};
echo "<p>Virheellinen salasana tai käyttäjätunnus</p>";
} else {
    echo "<p>Ongelma tietokannassa!</p>";  
};
};
?>
</form>
<a href="./register.php/">Ei käyttäjää? Rekisteröidy täällä</a>
<br>
<a href="../sivusto.php/">Jatka kirjautumatta</a>
<br>
<a href="../report.php/">Raportoi ongelma</a>
</body>
</html>