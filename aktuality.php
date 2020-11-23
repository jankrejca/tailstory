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

  <title>TailStory - azyl pro psy v nouzi</title>

  <!-- Bootstrap kaskádové styly -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Kaskádové styly -->
  <link href="css/style.css" rel="stylesheet">

  <!-- Featherlight -->
  <link href="//cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.css" type="text/css" rel="stylesheet" />

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
        <li class="nav-item active">
            <a class="nav-link js-scroll-trigger" href="aktuality.php">Aktuality</a>
          </li>
          <li class="nav-item">
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

  <section class="blog-list oazylu mb-5">
  <div class="pl-5 pr-5 pb-5"><h1 class="display-4">Aktuality</h1></div>
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
$vypisprispevku = $obsah->vratPrispevky($start, $cil);
$counter = 0;
foreach($vypisprispevku as $prispevek) {
  $counter += 1;
  $nadpis = $prispevek->nadpis;
  $obsahprispevku = $prispevek->obsah;
  $datum = $prispevek->datum;
  $datum = date("d. m. Y G:i", strtotime($datum));
  $autor = $prispevek->autor;
  $obrazek = "uploads/".$prispevek->obrazek;
?>
    <div class="row pb-5 mb-5 anchor-offset" id="<?php echo $counter; ?>">
				    <div class="col-md-4 col-sm-12 nahledAktuality">
                        <a href="<?php echo $obrazek;?>" data-featherlight="image"><img class="mr-3 img-fluid shadow post-thumb" src="<?php echo $obrazek; ?>" width="300" alt="image"></a>
                    </div>
					    <div class="col-md-8 col-sm-12 aktualita">
              <h3><?php echo $nadpis; ?></h3>
						    <div class="popisek mb-1"><span class="zverejneno">Zveřejněno: <?php echo $datum; ?></span><br><span class="cascteni">Průměrná doba čtení: <?php echo $obsah->casCteni($obsahprispevku); ?></span><br><span class="autor">Autor: <?php echo $autor; ?></span></div>
						    <div class="uvod"><?php echo $obsahprispevku; ?></div> 
					    </div>
    </div>
<?php }
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
                    $pocetPrispevku = $obsah->kolikZaznamu("obyvatele");
                    $pocetPrispevku = $pocetPrispevku - 1;
                    if ($page > 0) {
                        ?>
                        <a href="?page=<?php echo $predchoziStr;?>" class="btn-card">Předchozí aktuality</a>
                        <?php
                    }
                    if ($cil == 4) {
                        ?>
                        <a href="?page=<?php echo $dalsiStr;?>" class="btn-card">Další aktuality</a>
                        <?php
                    }
                    ?>
                </div>
</div>
</section>

  <button class="btn-card fixedButton" onclick="location.href='ztracen.php'">Ztratil jsem psa!</button>

  <footer>
      <?php $obsah->footer(true); ?>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Featherlight -->
  <script src="//cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>

</body>
</html>