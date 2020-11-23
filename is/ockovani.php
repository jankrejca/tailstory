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

  <title>TailStory - IS očkování</title>

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
                         <a class="nav-link" href="schuzky.php">Schůzky</a>
                     </li>
                     <li class="nav-item active">
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
             <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                 <a href="new-ockovani.php"><i class="far fa-plus-square" style="color: #C71585; font-size: 40px;"></i></a>
             </div>
             <div class="col-lg-12 col-md-12 col-sm-12">
                 <h2 class="nadpis-administrace">Výpis naplánovaných očkování</h2>
                 <div class="table-responsive">
                 <table class='text-center aktuality-administrace w-auto'>
         <tr>
             <td>Pes (ID)</td>
             <td>Datum a čas</td>
             <td>Název</td>
             <td>Upravit</td>
             <td>Navštíveno</td>
             <td>Smazat</td>
         </tr>
         <?php
         $vypisOckovani = $obsah->vratOckovani();
     foreach ($vypisOckovani as $ockovani) {
         $ID = $ockovani->ID;
         $datum = date("d. m. Y G:i", strtotime($ockovani->datum));
         $IDpsa = $ockovani->IDpsa;
         $jmeno = $ockovani->jmeno;
         $nazev = $ockovani->nazev;
         $navstiveno = $ockovani->navstiveno;
         ?>
             <tr <?php if($navstiveno == 1) echo 'class="adoptovano"'; ?>>
                 <td><?php echo $jmeno." (".$IDpsa.")"; ?></td>
                 <td><?php echo $datum; ?></td>
                 <td><?php echo $nazev; ?></td>
                 <td><a href=uprav-ockovani.php?ID=<?php echo $ID; ?>><img src='../img/edit.jpg' class='uprava' width="30" alt="Upravit"></a>
                 </td>
                 <td>
                     <form action="" method="POST">
                         <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                         <input type="submit" class="btn" style="border-radius: 60px;font-size: 25px;color: <?php if($navstiveno == 1) echo "green"; else echo "red"; ?>;" name="stavOckovani" value="<?php if($navstiveno == 1) echo "ANO"; else echo "NE"; ?>" />
                     </form>
                 </td>
                 <td><a href=smaz.php?ID=<?php echo $ID."&tabulka=ockovani"; ?>
                        onclick="return confirm('Chcete opravdu smazat očkování?')"><img src='../img/delete.png'
                                                                                        class='uprava' width="30" alt="Smazat"></a>
                 </td>
             </tr>
         <?php
     }
     ?>
     </table>
                 </div>
                 <div class="mt-5"><div class="legendaObyvatele d-table-cell my-auto"></div><p class="d-table-cell align-middle pl-2"> - navštíveno</p></div>
     </div>
         </div>
     </div>
<?php
     $obsah->stavOckovani();
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