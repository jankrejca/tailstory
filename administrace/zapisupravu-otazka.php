<?php
session_start();
require_once '../tailstory.class.php';
$obsah = new tailstory();

        if(isset($_SESSION['username']) && $_SESSION["opravneni"] == "administrator"){
         $ID = htmlspecialchars($_GET["ID"]);
         $autor = htmlspecialchars($_POST["autor"]);
         $otazka = htmlspecialchars($_POST["otazka"]);
         $odpoved = htmlspecialchars($_POST["odpoved"]);

         if($obsah->upravOtazku($ID, $autor, $otazka, $odpoved)) {
             // je zapsáno v MySQL
             header('Location: otazky-administrace.php');
             exit;
         }

         else {
             //chybí povinné pole
             echo "<h3>Otázka neupravena, je nutné zadat nějaký obsah.</h3>";
         }
        }
        else {
            header('Location: index.php');
        }
?>

