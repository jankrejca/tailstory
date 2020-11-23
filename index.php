<?php
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

  <!-- Ověření pro Google Custom Search -->
  <meta name="google-site-verification" content="WfbvwcPlWO6goBrs3ETZyML8XJE7X00Lo_KMwsmvXhc" />
  <title>TailStory - azyl pro psy v nouzi</title>

  <!-- Bootstrap kaskádové styly -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Kaskádové styly -->
  <link href="css/style.css" rel="stylesheet">

  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

</head>
<body class="d-flex flex-column">
  <!-- Navigace -->
  <nav class="navbar shadow navbar-expand-lg navbar-dark bg-white fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href=""><img src="img/logo.jpg" alt="Logo" height="50"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item">
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

  <!-- Úvod -->

  <header class="masthead">
    <div class="filtr">
      <div class="container h-100">
      <div class="row h-100 align-items-center">
        <div class="col-12 text-center">
          <h1 class="font-weight-bold text-white display-1 text-center">TailStory</h1>
          <p class="lead text-white text-center"><?php echo "azyl pro střední a velké psy, kteří by neměli kde jinde složit hlavu<br>Dnes má v psím kalendáři svátek: "; echo $obsah->vypisSvatek(); ?></p>
            <div class="w-50 mx-auto"><div class="gcse-search"></div></div>
        </div>
      </div>
    </div>
    </div>
  </header>

  <!-- Jak pomáháme? -->
  
  <section id="jakpomahame">
    <div class="container-fluid">
    <div class="row align-items-center">

        <?php
        $vypisSluzby = $obsah->vratElementy("homepage", "sluzba");
        foreach($vypisSluzby as $sluzba) {
            $obsahElementu = $sluzba->obsah;
            $obrazek = $sluzba->obrazek;
            ?>
            <div class="col-lg-3 md-6 sm-12">
                <div class="p-5 text-center w-100">
                    <img src="uploads/<?php echo $obrazek; ?>" alt="Ikona služby" class="pb-4 ikonaSluzby text-center"><br>
                    <?php echo $obsahElementu; ?></div>
            </div>
            <?php
        }
        ?>

    </div>
    </div>
  </section>

  <!-- O nás -->

  <section id="kdojsme">
    <div class="container">
      <div class="row align-items-center">
          <?php
          $vypisKdojsme = $obsah->vratElementy("homepage", "kdojsme");
          foreach($vypisKdojsme as $kdojsme) {
              $obsahElementu = $kdojsme->obsah;
              $obrazek = $kdojsme->obrazek;
              ?>
              <div class="col-lg-6 order-lg-2">
                  <div class="p-5">
                      <img class="img-fluid rounded-circle shadow" src="uploads/<?php echo $obrazek; ?>" alt="Kdo jsme">
                  </div>
              </div>
              <div class="col-lg-6 order-lg-1">
                  <div class="p-5">
                      <?php echo $obsahElementu; ?>
                  </div>
              </div>
              <?php
          }
          ?>
      </div>
    </div>
  </section>

  <!-- Čísla -->

<div id="cisla" class="sectionClass">
  <div class="fullWidth eight columns">
      <div class="cislaWrap">
          <div class="item">
              <i class="fas fa-dog"></i>
              <p class="cislo"><?php $neadoptovanych = $obsah->kolikAdopciNeadopci(0); echo $neadoptovanych; ?></p>
              <span></span>
              <p>Pejsků k adopci</p>
          </div>
          <div class="item">
            <i class="fas fa-check-circle"></i>
            <p class="cislo"><?php echo $obsah->kolikAdopciNeadopci(1); ?></p>
            <span></span>
            <p>Adoptovaných pejsků</p>
        </div>
          <div class="item">
              <i class="fas fa-tint"></i>
              <p class="cislo">
                  <?php
                  $start = new DateTime('2019-10-01');
                  $dnes = new DateTime();
                  $dny  = $dnes->diff($start)->format('%a');
                  echo $misek = $dny * 3 * $neadoptovanych;
                  ?>
              </p>
              <span></span>
              <p>Vypitých misek</p>
          </div>
          <div class="item">
              <i class="fas fa-bone"></i>
              <p class="cislo"><?php
                  echo $hracek = $dny * $neadoptovanych;
                  ?></p>
              <span></span>
              <p>Rozkousaných hraček</p>
          </div>
      </div>
  </div>
</div>


  <!-- 3 poslední aktuality -->
  <section class="novinky">
      <div class="container">
          <div class="p-5"><h2 class="display-4">Poslední aktuality</h2></div>
          <div class="row">
              <?php
              $vypisprispevku = $obsah->vratPrispevky(0, 3);
              $counter = 0;
              foreach($vypisprispevku as $prispevek) {
                  $counter += 1;
                  $nadpis = $prispevek->nadpis;
                  $originaldatum = $prispevek->datum;
                  $datum = date("d. m. Y G:i", strtotime($originaldatum));
                  $obrazek = $prispevek->obrazek;
                  ?>
              <div class="col-md-4">
                  <div class="card-content">
                      <div class="card-img">
                          <img src="uploads/<?php echo $obrazek; ?>" alt="Miniatura příspěvku">
                          <h4><span><?php echo $datum; ?></span></h4>
                      </div>
                      <div class="card-desc">
                          <h3><?php echo $nadpis; ?></h3>
                          <?php echo $obsah->vypisPrvniOdstavec($prispevek->obsah); ?>
                          <a href="aktuality.php#<?php echo $counter; ?>" class="btn-card">Číst dále</a>
                      </div>
                  </div>
              </div>
              <?php
              }
            ?>
        </div>
    </div>
</section>



<!-- Partneři -->

  <section class="partneri">
    <div class="container">
        <h3 class="display-4 text-center">Naši partneři</h3>
      <div class="row">
          <?php
          $vypisPartneri = $obsah->vratElementy("homepage", "partner");
          foreach($vypisPartneri as $partner) {
              $odkaz = $partner->obsah;
              $obrazek = $partner->obrazek;
              ?>
              <div class="col-md-4 col-sm-6 my-auto p-5">
                  <a href="<?php echo $odkaz; ?>" target="_blank">
                      <img class="img-fluid d-block mx-auto my-auto" alt="Logo partnera" src="uploads/<?php echo $obrazek; ?>">
                  </a>
              </div>
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

  <script async src="https://cse.google.com/cse.js?cx=016679626760832362630:whhmuhxdl0n"></script>
</body>
</html>