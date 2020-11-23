<?php
session_start();
require_once '../tailstory.class.php';
$obsah = new tailstory();

        if(isset($_SESSION['username'])){
         $ID = htmlspecialchars($_GET["ID"]);
         $datum = $_POST["datum"];
         $prispevek = $_POST["obsah"];
         $nadpis = $_POST["nadpis"];
         $obrazek = $_FILES['miniatura']['name'];

         if($obsah->upravPrispevek($ID, $prispevek, $nadpis, $datum, $obrazek)) {
             // je zapsáno v MySQL
             header('Location: aktuality-administrace.php');
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

