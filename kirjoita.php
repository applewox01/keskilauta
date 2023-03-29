<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keksilauta.com - luo kirjoitelma</title>
</head>
<body>
    <a href="./sivusto.php/"><b><= Takaisin - tuoreimmat</b></a>
    <h3><b>Keksilauta.com - luo kirjoitelma</b></h3>
    <?php
    session_start();
    if(isset($_SESSION["user"])) {
        echo "<b> Käyttäjä: ".$_SESSION["user"]."</b>";
    } else {
        header("Location: ./log-in/log.php/");
        exit();
    };
    ?>
    <form action="" method="post">
    <b>Otsikko: </b>
        <br>
        <input name="otsikko" style="width: 50%;">

        </input>
        <br>
        <b>Sisältö: </b>
        <br>
        <textarea style="max-width: 50%; min-width: 50%;" width="50%" name="sisalto">
        </textarea>
        <br>
        <input type="submit" name="kirjaa">
        <?php

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

        if(isset($_POST["kirjaa"])){

            $otsikko = $_POST["otsikko"];
            $sisalto = $_POST["sisalto"];
            $user = $_SESSION["user"];
            $date = date("Y-m-d");
            $id = rand(0, 99999);
            $id = base64_encode($id);

            $insert = "INSERT INTO uutiset (id, kirjoittaja, sisalto, julkaisupaiva, otsikko)
            VALUES ('$id','$user', '$sisalto', '$date','$otsikko')";
            if (mysqli_query($yhteys, $insert)) {
                header("Location: ./sivusto.php/");
                exit();
              } else {
                echo "<b>Virhe tietokannassa!</b>";
              };
        };
        ?>
</form>
</body>
</html>