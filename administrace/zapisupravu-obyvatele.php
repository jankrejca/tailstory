<?php
session_start();
require_once '../tailstory.class.php';
$obsah = new tailstory();

        if(isset($_SESSION['username'])){
            $ID = htmlspecialchars($_GET["ID"]);
            $datum = $_POST["datum"];
            $jmeno = $_POST["jmeno"];
            $pohlavi = $_POST["pohlavi"];
            $narozeni = $_POST["narozeni"];
            $velikost = $_POST["velikost"];
            $plemeno = $_POST["plemeno"];
            $barva = $_POST["barva"];
            $tetovani = $_POST["tetovani"];
            $kastrovany = $_POST["kastrovany"];
            $handicapovany = $_POST["handicapovany"];
            $popis = $_POST["popis"];
            $obrazek = $_FILES['miniatura']['name'];
            $adoptovano = $_POST["adoptovano"];

         if($obsah->upravObyvatele($ID, $datum, $jmeno, $pohlavi, $narozeni, $velikost, $plemeno, $barva, $tetovani, $kastrovany, $handicapovany, $popis, $obrazek, $adoptovano)) {
             // je zapsáno v MySQL
             header('Location: obyvatele-administrace.php');
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

