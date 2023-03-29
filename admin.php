<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uutiset.com - admin</title>
</head>
<body>
    <a href="./sivusto.php"><= Takaisin- tuoreimmat</a>
    <h3><b>Uutiset.com</b></h3>
    <h3><b>Luo uutinen</b></h3>
    <form action="" method="post">
        <label><b>Otsikko:</b></label>
        <br>
        <input type="text">
        <br>
        <label><b>Sisältö:</b></label>
        <br>
        <input type="text">
        <br>
        <?php
        $id = rand(0, 99999);
        $id = base64_encode($id);
        echo "<b>ID: $id</b>";
        ?>
        <br>
        <input type="submit">
</form>

<h3><b>Poista uutinen</b></h3>
    <form action="" method="post">
        <label><b>Uutisen ID:</b></label>
        <br>
        <input type="text" value="" name="id">
        <br>
        <input type="submit" name="poista">
</form>

</body>
</html>