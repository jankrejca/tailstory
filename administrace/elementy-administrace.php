<?php 
        session_start();
        require_once '../tailstory.class.php';
        $obsah = new tailstory();
        $prihlaseni = $obsah->login();
        ?>

<!DOCTYPE html>
<html lang="cs">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="TailStory - azyl pro střední a velké psy, kteří by neměli kde jinde složit hlavu.">
  <meta name="author" content="Jan Krejča">

  <title>TailStory - ostatní stránky</title>

  <!-- Bootstrap kaskádové styly -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Kaskádové styly -->
  <link href="../css/style.css" rel="stylesheet">

  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body class="administrace">
<?php
 if (isset($_SESSION['username'])) {
     if ($_SESSION["opravneni"] == "administrator") {
         ?>

         <!-- Navigace -->
         <nav class="navbar shadow navbar-expand-lg navbar-dark fixed-top admin-nav" id="mainNav">
             <div class="container">
                 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                         aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                 </button>
                 <div class="collapse navbar-collapse" id="navbarResponsive">
                     <ul class="navbar-nav mx-auto">
                         <li class="nav-item">
                             <a class="nav-link" href="index.php">Hlavní stránka</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="aktuality-administrace.php">Aktuality</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="obyvatele-administrace.php">Obyvatelé</a>
                         </li>
                         <?php if ($_SESSION["opravneni"] == "administrator") { ?>
                             <li class="nav-item">
                                 <a class="nav-link" href="otazky-administrace.php">Otázky a odpovědi</a>
                             </li>
                             <li class="nav-item active">
                                 <a class="nav-link" href="elementy-administrace.php">Ostatní stránky</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link" href="uzivatele-administrace.php">Uživatelé</a>
                             </li>
                         <?php } ?>
                         <li class="nav-item">
                             <a class="nav-link" style="color: yellow !important;" href="../is/">IS</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="logout.php">Odhlásit se</a>
                         </li>
                     </ul>
                 </div>
             </div>
         </nav>

         <div class="container p-0 admin">
             <div class="row">
                 <div class="col-lg-12 col-md-12 col-sm-12">
                     <h2 class="nadpis-administrace">Úprava ostatních stránek</h2>
                     <?php
         $pages = array("homepage", "virtualniadopce", "oazylu", "jakpomoct", "kontakt", "ostatni");
         foreach ($pages as $page) {
             switch ($page) {
                 case "gdpr":
                     $pagename = "GDPR";
                     break;
                 case "homepage":
                     $pagename = "Domovská stránka";
                     break;
                 case "jakpomoct":
                     $pagename = "Jak pomoct";
                     break;
                 case "kontakt":
                     $pagename = "Kontakt";
                     break;
                 case "oazylu":
                     $pagename = "O azylu";
                     break;
                 case "virtualniadopce":
                     $pagename = "Virtuální adopce";
                     break;
                 default:
                     $pagename = "Ostatní";
                     break;
             }
                     ?>
                     <h3 class="text-left pb-2"><?php echo $pagename; ?></h3>
                     <div class="table-responsive mb-5">
                         <table class='text-center aktuality-administrace w-auto'>
                             <tr>
                                 <td>Typ elementu</td>
                                 <td>Začátek obsahu</td>
                                 <td>Upravit</td>
                                 <td>Smazat</td>
                                 <td>Přidat</td>
                             </tr>
                             <?php
                             $vypisElementu = $obsah->vratElementyAdmin($page);
                             foreach ($vypisElementu as $element) {
                                 $ID = $element->ID;
                                 $stranka = $element->stranka;
                                 $nazev = $element->nazev;
                                 $nemazat = array(1,3,4,5,16,18,21,22,23,31, 35);
                                 $pridavat = array(1,5,16,21,23, 35);
                                 $obsahElementu = $obsah->vypisPrvniSlova($element->obsah, 2);
                                 ?>
                                 <tr>
                                     <td><?php echo $nazev; ?></td>
                                     <td><?php echo $obsahElementu . "..."; ?></td>
                                     <td><a href=uprav-element.php?ID=<?php echo $ID."&nazev=".$nazev; ?>><img src='../img/edit.jpg'
                                                                                              class='uprava'
                                                                                              width="30" alt="Upravit"></a></td>
                                     <td><?php if (!in_array($ID,$nemazat)) { ?><a href=smaz.php?ID=<?php echo $ID . "&tabulka=elementy"; ?>
                                            onclick="return confirm('Chcete opravdu smazat element?')">
                                             <img src='../img/delete.png' class='uprava' width="30" alt="Smazat"></a><?php } ?></td>
                                     <td><?php if (in_array($ID,$pridavat)) { ?><a href=new-element.php?stranka=<?php echo $stranka ?>&nazev=<?php echo $element->nazev; ?>><i
                                                     class="far fa-plus-square"
                                                     style="color: #C71585; font-size: 35px;"></i></a><?php } ?></td>
                                 </tr>
                                 <?php
                             }
                             ?>
                         </table>
                     </div>
             <?php } ?>
             </div>
             </div>
         </div>
         <?php
     }
     else {
         echo "<h2 class='text-center'>Nemáte dostatečná oprávnění pro přístup do této sekce.</h2>";
     }
 }

        else {
            $obsah->loginForm();
        }
?>

<!-- Copyright -->
<footer>
    <?php $obsah->footer(false); ?>
</footer>

  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>