<!DOCTYPE html>
<html lang="fi">
    <?php
    header('Content-Type:text/html; charset=UTF-8');
        $baseTiedosto = fopen("../baselink.txt", "r") or die("Ongelma tietokannassa");
        $baseLink = fgets($baseTiedosto);
        fclose($baseTiedosto);
    session_start();
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
     }
     // aseta merkistökoodaus (muuten ääkköset sekoavat)
     $yhteys->set_charset("utf8mb4");
    ?>
<head>
<link href="<?php echo $baseLink; ?>/css/style.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keskilauta.com - kirjaudu sisään</title>
    <link rel="icon" href="<?php echo $baseLink; ?>/assets/logo.png">
    <script src="<?php echo $baseLink; ?>/js/log-in/main.js"></script>
</head>

<body>
<img src="<?php echo $baseLink; ?>/assets/logo.png" alt="fisu" style="height: fit-content; width: 20%;">
<h3><b>Keskilauta.com - Kirjaudu sisään</b></h3>
<form method="post" action="">
<label for="username"><b>Käyttäjätunnus:</b></label>
<br>
<input type="text" name="username">
<br>
<label for="password"><b>Salasana:</b></label>
<br>
<input type="password" name="password" id="password">
<button id="showPass">Näytä salasana</button>

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
    $_SESSION["btc"] = $rivi["btc"];
    header("Location: ".$baseLink."");
    $yhteys->close();
    exit;
 };
};
echo "<p>Virheellinen salasana tai käyttäjätunnus</p>";
};
};
?>
</form>
<a href="<?php echo $baseLink; ?>/log-in/register.php">Ei käyttäjää? Rekisteröidy täällä</a>
<br>
<a href="<?php echo $baseLink; ?>">Jatka kirjautumatta</a>
</body>
</html>