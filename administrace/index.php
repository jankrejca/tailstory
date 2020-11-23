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

  <title>TailStory - administrace</title>

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
                     <li class="nav-item active">
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
                     <li class="nav-item">
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
                 <h1 class="nadpis-administrace">Přehled návštěvnosti</h1>
                 <div class="table-responsive mb-5 w-50 mx-auto">
                     <table class='text-center aktuality-administrace w-auto'>
                         <tr><td colspan="2">Statistika návštěvnosti</td></tr>
                <?php
                $navstevnost = $obsah->navstevnost();
                echo "<tr><td class='text-left'>Celkem navštíveno:</td><td>".$navstevnost->celkem."</td></tr>";
                echo "<tr><td class='text-left'>Unikátních návštěv:</td><td>".$navstevnost->UN."</td></tr>";
                echo "<tr><td class='text-left'>Unikátních denních návštěv:</td><td>".$navstevnost->UDN."</td></tr>";
                ?>
                     </table>
                 </div>
             </div>
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