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

  <title>TailStory - informační systém</title>

  <!-- Bootstrap kaskádové styly -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Kaskádové styly -->
  <link href="../css/style.css" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
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
                     <li class="nav-item active">
                         <a class="nav-link" href="index.php">Hlavní stránka</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="schuzky.php">Schůzky</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="ockovani.php">Očkování</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" style="color: yellow !important;" href="../administrace/">Administrace</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="../administrace/logout.php">Odhlásit se</a>
                     </li>
                 </ul>
             </div>
         </div>
     </nav>

     <div class="container p-0 admin">
         <div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12">
                 <?php
                 $schuzky = $obsah->vratTabulku("schuzky");
                 $dnes = strtotime(date("Y-m-d"));
                 foreach ($schuzky as $schuzka) {
                     $datum = strtotime($schuzka->datum);
                     $rozdil = $datum - $dnes;
                     if ($rozdil <= 7*24*60*60 && $rozdil >= 0 && $schuzka->schvaleno == 1) { // pokud dříve nebo rovno za týden
                         echo "<div class='alert alert-warning w-100 mb-2' role='alert'>POZOR! Schůzka s ".$schuzka->jmeno." ".date("d. m. Y", strtotime($schuzka->datum))." v ".date("H:i", strtotime($schuzka->cas))."</div>";
                     }
                 }
                 ?>
             </div>
         </div>
         <div class="row pt-5 stavy">
             <div class="col-lg-12 col-md-12 col-sm-12">
                <h2 class="pb-3">Stavy zásob na skladě</h2>
             </div>
             <?php
             $stavy = $obsah->vratTabulku("stavy");
             foreach ($stavy as $stav) { ?>
             <div class="col-md-3">
                 <div class="card mx-sm-1 p-3">
                     <div class="text-center"><img src="../img/<?php echo $stav->obrazek; ?>" width="100" alt="Ikona stavu zásob"></div>
                     <div class="text-center mt-3"><h4><?php echo $stav->nazev; ?></h4></div>
                     <div class="text-center mt-2"><h1><?php echo $stav->pocet; ?></h1></div>
                     <form action="" method="POST">
                         <input type="hidden" name="ID" value="<?php echo $stav->ID; ?>">
                         <div class="text-center">
                         <input type="submit" class="btn border border-dark minus" name="stavZasob" value="-" />
                         <input type="submit" class="btn border border-dark plus" name="stavZasob" value="+" />
                         </div>
                     </form>
                 </div>
             </div>
             <?php }
             $obsah->stavZasob();
             ?>
         </div>
         <div class="row pt-5" id="poznamky">
             <div class="col-sm-12 mb-3"><a href="new-poznamka.php">Přidat poznámku</a></div>
             <?php
             $poznamky = $obsah->vratTabulku("poznamky");
             foreach ($poznamky as $poznamka) { ?>
             <div class="col-md-4 col-sm-12 p-3 mb-3 poznamka">
                 <h4><?php echo date("d. m. Y H:i", strtotime($poznamka->datum)); ?></h4>
                 <a href=smaz.php?ID=<?php echo $poznamka->ID."&tabulka=poznamky&location=index"; ?>
                    onclick="return confirm('Chcete opravdu smazat poznámku?')"><img src='../img/delete.png'
                                                                                    class='uprava float-right' width="20" alt="Smazat"></a>
                 <p><?php echo $poznamka->obsah; ?></p>
                 <p class="text-right">Napsal: <?php echo $poznamka->autor; ?></p>
             </div>
             <?php } ?>
         </div>
     </div>

     <?php
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