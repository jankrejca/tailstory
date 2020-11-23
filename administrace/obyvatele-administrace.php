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

  <title>TailStory - Obyvatelé</title>

  <!-- Bootstrap kaskádové styly -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Kaskádové styly -->
  <link href="../css/style.css" rel="stylesheet">

  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

</head>

<body class="administrace">
<?php
 if(isset($_SESSION['username'])) {
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
                     <li class="nav-item active">
                         <a class="nav-link" href="obyvatele-administrace.php">Obyvatelé</a>
                     </li>
                     <?php if ($_SESSION["opravneni"] == "administrator") { ?>
                     <li class="nav-item">
                         <a class="nav-link" href="otazky-administrace.php">Otázky a odpovědi</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="elementy-administrace.php">Ostatní stránky</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="uzivatele.php">Uživatelé</a>
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
             <div class="col-lg-12 col-md-12 col-sm-12 text-right">
             <a href="new-obyvatel.php"><i class="far fa-plus-square" style="color: #C71585; font-size: 40px;"></i></a>
             </div>
             <div class="col-lg-12 col-md-12 col-sm-12">
                 <h2 class="nadpis-administrace">Výpis přidaných obyvatel</h2>
                 <div class="table-responsive">
                 <table class='text-center aktuality-administrace w-auto'>
         <tr>
             <td>ID</td>
             <td>Jméno</td>
             <td>Velikost</td>
             <td>Plemeno</td>
             <td>Datum narození</td>
             <td>Upravit</td>
             <td>Adoptováno</td>
             <td>Smazat</td>
         </tr>
         <?php
     $vypisobyvatele = $obsah->vratObyvateleAdmin();
     foreach ($vypisobyvatele as $obyvatel) {
         $ID = $obyvatel->ID;
         $jmeno = $obyvatel->jmeno;
         $velikost = $obyvatel->velikost;
         switch ($velikost) {
             case "maly":
                 $velikost = "malý";
                 break;
             case "stredni":
                 $velikost = "střední";
             case "velky":
                 $velikost = "velký";
                 break;
         }
         $plemeno = $obyvatel->plemeno;
         $originaldatum = $obyvatel->datum;
         $datum = date("d. m. Y", strtotime($originaldatum));
         $adoptovano = $obyvatel->adoptovano;
         ?>
             <tr <?php if($adoptovano == 1) echo 'class="adoptovano"'; ?>>
                 <td><?php echo $ID; ?></td>
                 <td><?php echo $jmeno; ?></td>
                 <td><?php echo $velikost; ?></td>
                 <td><?php echo $plemeno; ?></td>
                 <td><?php echo $datum; ?></td>
                 <td><a href=uprav-obyvatele.php?ID=<?php echo $ID; ?>><img src='../img/edit.jpg' class='uprava' width="30" alt="Upravit"></a>
                 </td>
                 <td>
                     <form action="" method="POST">
                         <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                         <input type="submit" class="btn" style="border-radius: 60;font-size: 25px;color: <?php if($adoptovano == 1) echo "green"; else echo "red"; ?>;" name="stav" value="<?php if($adoptovano == 1) echo "ANO"; else echo "NE"; ?>" />
                     </form>
                 </td>
                 <td><a href=smaz.php?ID=<?php echo $ID."&tabulka=obyvatele"; ?>
                        onclick="return confirm('Chcete opravdu smazat pejska?')"><img src='../img/delete.png'
                                                                                        class='uprava' width="30" alt="Smazat"></a>
                 </td>
             </tr>
         <?php
     }
     ?>
     </table>
                 </div>
                 <div class="mt-5"><div class="legendaObyvatele d-table-cell my-auto"></div><p class="d-table-cell align-middle pl-2"> - adoptováno</p></div>
     </div>
         </div>

         <div class="row pt-5">
             <div class="col-lg-12 col-md-12 col-sm-12">
                 <h2 class="nadpis-administrace">Výpis ztracených pejsků</h2>
                 <div class="table-responsive">
                     <table class='text-center aktuality-administrace w-auto'>
                         <tr>
                             <td>ID</td>
                             <td>Jméno psa</td>
                             <td>Pohlaví</td>
                             <td>Plemeno</td>
                             <td>Podrobnosti</td>
                             <td>Smazat</td>
                         </tr>
                         <?php
                         $vypisZtracene = $obsah->vratTabulku("ztraceni");
                         foreach ($vypisZtracene as $ztracen) {
                             $ID = $ztracen->ID;
                             $jmenopsa = $ztracen->jmenopsa;
                             $pohlavi = $ztracen->pohlavi;
                             $plemeno = $ztracen->plemeno;
                             ?>
                             <tr>
                                 <td><?php echo $ID; ?></td>
                                 <td><?php echo $jmenopsa; ?></td>
                                 <td><?php echo $pohlavi; ?></td>
                                 <td><?php echo $plemeno; ?></td>
                                 <td><a href=podrobnosti-ztracen.php?ID=<?php echo $ID; ?>><img src='../img/info.png' class='uprava' width="30px"></a></td>
                                 <td><a href=smaz.php?ID=<?php echo $ID."&tabulka=ztraceni&location=obyvatele"; ?>
                                        onclick="return confirm('Chcete opravdu smazat ztraceného pejska?')"><img src='../img/delete.png'
                                                                                                       class='uprava' width="30px"></a>
                                 </td>
                             </tr>
                             <?php
                         }
                         ?>
                     </table>
                 </div>
             </div>
         </div>
     </div>
<?php
     $obsah->stavObyvatele();
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
