<?php
session_start();
require_once '../tailstory.class.php';
$obsah = new tailstory();

        if(isset($_SESSION['username']) && $_SESSION["opravneni"] == "administrator"){
         $ID = htmlspecialchars($_GET["ID"]);
         $obsahElementu = $_POST["obsah"];
         $obrazek = $_FILES['miniatura']['name'];

         if($obsah->upravElement($ID, $obrazek, $obsahElementu)) {
             // je zapsáno v MySQL
             header('Location: elementy-administrace.php');
             exit;
         }

         else {
             //chybí povinné pole
             echo "<h3>Stránka neupravena, je nutné zadat nějaký obsah.</h3>";
         }
        }
        else {
            header('Location: index.php');
        }
?>

