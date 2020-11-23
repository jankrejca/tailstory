<?php

require_once '../tailstory.class.php';
$obsah = new tailstory();

session_start();
if (isset($_SESSION["username"])) {
    if ($obsah->smaz($_GET["ID"], $_GET["tabulka"])) {
        //smazán
        if (isset($_GET["location"])) {
            header("Location: " . $_GET["location"] . "-administrace.php");
        } else {
            header("Location: " . $_GET["tabulka"] . "-administrace.php");
        }
        exit;
    } else {
        //nesmazán
        header("Location: index.php");
    }
}
else {
    echo "<h2 class='text-center'>Nemáte dostatečná oprávnění pro přístup do této sekce.</h2>";
}
    
?>

