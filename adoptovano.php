<?php 
        session_start();
        require_once 'tailstory.class.php';
        $obsah = new tailstory();
        $obsah->vlozNavstevu();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="TailStory - azyl pro střední a velké psy, kteří by neměli kde jinde složit hlavu.">
  <meta name="author" content="Jan Krejča">

  <title>TailStory - adoptovaní pejsci</title>

  <!-- Bootstrap kaskádové styly -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Kaskádové styly -->
  <link href="css/style.css" rel="stylesheet">

  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

</head>

<body>
  <!-- Navigace -->
  <nav class="navbar shadow navbar-expand-lg navbar-dark bg-white fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="index.php"><img src="img/logo.jpg" height="50" alt="Logo"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="aktuality.php">Aktuality</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link js-scroll-trigger" href="obyvatele.php">Obyvatelé</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="virtualniadopce.php">Virtuální adopce</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="oazylu.php">O azylu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="jakpomoct.php">Jak pomoct</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="kontakt.php">Kontakt</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="oazylu mb-5">
      <p class="lead podkategorie" style="padding-left: 48px;"><a href="obyvatele.php"><i class="fas fa-arrow-left pr-2"></i>Obyvatelé</a></p>
      <div class="pl-5 pr-5 pb-5"><h1 class="display-4">Úspěšně adoptovaní pejsci</h1></div>
  <div class="container">
      <div class="row">
          <div class="col-md-12">
  <section class="blog-list px-3 py-5 p-md-5">
		    <div class="container">
<?php
if (isset($_GET["page"]) && $_GET["page"] > 0) {
    $start = $_GET["page"] * 4;
    $cil = $start + 4;
}

else {
    $start= 0;
    $cil = 4;
}
$vypisobyvatele = $obsah->vratObyvatele($start, $cil, 1);
foreach($vypisobyvatele as $obyvatel) {
        $ID = $obyvatel->ID;
        $jmeno = $obyvatel->jmeno;
        $pohlavi = $obyvatel->pohlavi;
        $narozeni = $obyvatel->narozeni;
        $vek = $obsah->spocitejVek($narozeni);
        $velikost = $obyvatel->velikost;
        switch ($velikost) {
            case "maly":
                $velikost = "Malý (do 30 cm)";
                break;
            case "stredni":
                $velikost = "Střední (31-60 cm)";
                break;
            case "velky":
                $velikost = "Velký (61 cm a více)";
                break;
        }
        $plemeno = $obyvatel->plemeno;
        $barva = $obyvatel->barva;
        $tetovani = $obyvatel->tetovani;
        $kastrovany = $obyvatel->kastrovany;
        $handicapovany = $obyvatel->handicapovany;
        $popis = $obyvatel->popis;
        $obrazek = $obyvatel->obrazek;
        ?>
        <div class="item mb-5 obyvatel">
            <div class="media">
                <div class="popisek text-left my-auto">
                    <img class="mr-3 img-fluid my-auto post-thumb d-none d-md-flex"
                         src="uploads/<?php echo $obrazek; ?>" width="300" alt="Obrázek pejska">
                    <span><i class="fas fa-mars"></i>Pohlaví: </span><?php echo $pohlavi; ?><br>
                    <span><i class="fas fa-calendar-alt"></i>Věk:</span><?php echo $vek; ?><br>
                    <span><i class="fas fa-dog"></i>Velikost: </span><?php echo $velikost; ?><br>
                    <span><i class="fas fa-paw"></i>Plemeno: </span><?php echo $plemeno; ?><br>
                    <span><i class="fas fa-palette"></i>Barva: </span><?php echo $barva; ?><br>
                    <span><i class="fas fa-pen"></i>Tetování: </span><?php echo $tetovani; ?><br>
                    <span><i class="fas fa-user-md"></i>Kastrovaný/á: </span><?php echo $kastrovany; ?><br>
                    <span><i class="fas fa-hospital"></i>Handicapovaný: </span><?php echo $handicapovany; ?><br>
                </div>
                <div class="media-body">
                    <h3><?php echo $jmeno; ?></h3>
                    <div class="uvod"><?php echo $popis; ?></div>
                </div><!--//media-body-->
            </div><!--//media-->

        </div><!--//item-->
        <?php
}
?>
<div class="ovladani">
    <?php
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    }
    else {
        $page = 0;
    }
    $predchoziStr = $page - 1;
    $dalsiStr = $page + 1;
    $pocetPrispevku = $obsah->kolikAdopciNeadopci(1);
    $pocetPrispevku = $pocetPrispevku - 1;
    if ($page > 0) {
        ?>
        <a href="?page=<?php echo $predchoziStr;?>" class="btn-card">Předchozí pejsci</a>
        <?php
    }
    if ($cil == 4 && $pocetPrispevku > 3) {
        ?>
        <a href="?page=<?php echo $dalsiStr;?>" class="btn-card">Další pejsci</a>
        <?php
    }
    ?>
</div>
</div>
</section>
          </div>
      </div>
  </div>
  </div>

  <button class="btn-card fixedButton" onclick="location.href='ztracen.php'">Ztratil jsem psa!</button>

  <footer>
      <?php $obsah->footer(true); ?>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>