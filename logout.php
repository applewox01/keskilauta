<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log out</title>
    <link rel="icon" href="<?php echo $baseLink; ?>/assets/logo.png">
</head>
<body>
<?php
    $baseTiedosto = fopen("./baselink.txt", "r") or die("Ongelma tietokannassa");
    $baseLink = fgets($baseTiedosto);
    fclose($baseTiedosto);
session_start();
session_unset();
session_destroy();
header("Location: ".$baseLink."/log-in/log.php");
exit;
?>
</body>
</html>