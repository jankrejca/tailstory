<?php
session_start();
require_once '../tailstory.class.php';
$obsah = new tailstory();

        if(isset($_SESSION['username']) && $_SESSION["opravneni"] == "administrator"){
         $ID = htmlspecialchars($_GET["ID"]);
         $email = htmlspecialchars($_POST["email"]);
         if ($_POST["heslo"] != "" && $_POST["heslo2"] != "") {
            if ($_POST["heslo"] == $_POST["heslo2"]) {
                $heslo = md5($_POST["heslo"]);
            }
            else {
                echo "Zadaná hesla se liší";
                exit;
            }
         }
         else {
             $heslo = null;
         }
         $opravneni = htmlspecialchars($_POST["opravneni"]);

         if($obsah->upravUzivatele($ID, $email, $heslo, $opravneni)) {
             // je zapsáno v MySQL
             header('Location: uzivatele-administrace.php');
             exit;
         }
         else {
             //chybí povinné pole
             echo "<h3>Uživatel neupraven, je nutné zadat nějaký obsah.</h3>";
         }
        }
        else {
            header('Location: index.php');
        }
?>

