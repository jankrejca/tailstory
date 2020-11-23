<?php
session_start();
require_once '../tailstory.class.php';
$obsah = new tailstory();

        if(isset($_SESSION['username'])){
         $ID = htmlspecialchars($_GET["ID"]);
         $datum = htmlspecialchars($_POST["datum"]);
         $nazev = htmlspecialchars($_POST["nazev"]);

         if($obsah->upravOckovani($ID, $datum, $nazev)) {
             // je zapsáno v MySQL
             header('Location: ockovani.php');
             exit;
         }

         else {
             //chybí povinné pole
             echo "<h3>Schůzka neupravena, je nutné zadat nějaký obsah.</h3>";
         }
        }
        else {
            header('Location: index.php');
        }
?>

