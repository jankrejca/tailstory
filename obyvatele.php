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
  <div class="pl-5 pr-5 pb-5"><h1 class="display-4">Obyvatelé našeho útulku</h1></div>
      <p class="lead" style="padding-left: 48px; margin-top: -28px !important;"><a href="adoptovano.php">Úspěšně adoptovaní pejsci</a></p>
  <div class="container">
      <div class="row">
          <div class="col-md-2 col-sm-12 pt-5 pl-0">
              <h3>Filtrovat</h3>
              <form method="get" class="filtrObyvatel">
                  <p>Pohlaví:<br>
                      <label><input type="checkbox" name="pohlavi[]" value="pes" <?php if (isset($_GET["pohlavi"]) && in_array("pes", $_GET["pohlavi"])) echo "checked"; ?>>pes</label><br>
                      <label><input type="checkbox" name="pohlavi[]" value="fena" <?php if (isset($_GET["pohlavi"]) && in_array("fena", $_GET["pohlavi"])) echo "checked"; ?>>fena</label>
                  </p>
                  <p>Velikost:<br>
                      <label><input type="checkbox" name="velikost[]" value="maly" <?php if (isset($_GET["velikost"]) && in_array("maly", $_GET["velikost"])) echo "checked"; ?>>malý (do 30 cm)</label><br>
                      <label><input type="checkbox" name="velikost[]" value="stredni" <?php if (isset($_GET["velikost"]) && in_array("stredni", $_GET["velikost"])) echo "checked"; ?>>střední (31-60 cm)</label><br>
                      <label><input type="checkbox" name="velikost[]" value="velky" <?php if (isset($_GET["velikost"]) && in_array("velky", $_GET["velikost"])) echo "checked"; ?>>velký (61 cm a více)</label>
                  </p>
                  <p><label>Plemeno:</label><br>
                          <?php
                          $plemena = $obsah->vratPlemena();
                          foreach($plemena as $nazev) {
                              $plemeno = $nazev->plemeno;
                              ?>
                              <label><input type="checkbox" name="plemeno[]" value="<?php echo $plemeno.'"';  if (isset($_GET["plemeno"]) && in_array($plemeno, $_GET["plemeno"])) echo "checked";?>><?php echo $plemeno; ?></label><br>
                              <?php
                          }
                          ?>
                        </p>
                  <div class="text-center"><input type="submit" value="Zobrazit" class="btn-card" onclick="filtrObyvatel()"></div>
              </form>
          </div>

          <div class="col-md-10 col-sm-12">
  <section class="blog-list px-3 py-5 p-md-5">

<?php
if (isset($_GET["page"]) && $_GET["page"] > 0) {
    $start = $_GET["page"] * 4;
    $cil = $start + 4;
}

else {
    $start= 0;
    $cil = 4;
}
$pocetVypsatelnych = 0;
$vypisobyvatele = $obsah->vratObyvatele($start, $cil, 0);
if (empty($vypisobyvatele))
    echo "<h3 class='text-center'>Nic jsme bohužel nenašli.</h3>";
foreach($vypisobyvatele as $obyvatel) {
    $pocetVypsatelnych = $obyvatel->pocet;
    $adoptovano = $obyvatel->adoptovano;
    if ($adoptovano == false) {
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
        $obrazek = "uploads/".$obyvatel->obrazek;
        ?>
        <div class="row pb-5 mb-5">
            <div class="col-md-4 col-sm-12 nahledAktuality mx-auto">
                <div class="popisek text-left my-auto">
                    <a href="<?php echo $obrazek;?>" data-featherlight="image"><img class="mr-3 img-fluid my-auto post-thumb"
                                                                                    src="<?php echo $obrazek; ?>" width="300" alt="<?php echo $jmeno; ?>"></a><br>
                    <span><i class="fas fa-mars"></i>Pohlaví: </span><?php echo $pohlavi; ?><br>
                    <span><i class="fas fa-calendar-alt"></i>Věk:</span><?php echo $vek; ?><br>
                    <span><i class="fas fa-dog"></i>Velikost: </span><?php echo $velikost; ?><br>
                    <span><i class="fas fa-paw"></i>Plemeno: </span><?php echo $plemeno; ?><br>
                    <span><i class="fas fa-palette"></i>Barva: </span><?php echo $barva; ?><br>
                    <span><i class="fas fa-pen"></i>Tetování: </span><?php echo $tetovani; ?><br>
                    <span><i class="fas fa-user-md"></i>Kastrovaný/á: </span><?php echo $kastrovany; ?><br>
                    <span><i class="fas fa-hospital"></i>Handicapovaný: </span><?php echo $handicapovany; ?><br>

                </div>
            </div>
            <div class="col-md-8 col-sm-12 aktualita">
                    <h3><?php echo $jmeno; ?></h3>
                    <div class="uvod"><?php echo $popis; ?></div>
                <p class="mt-5 text-center"><a href="schuzka.php?ID=<?php echo $ID; ?>&jmeno=<?php echo $jmeno; ?>"
                                               class="btn-card">Domluvit si schůzku</a></p>
                </div>
            </div>
        <?php
    }
}
if (isset($_GET["page"]))
$url = "&".substr(strstr($_SERVER["REQUEST_URI"], '&'), strlen("&"));
else
$url = "&".substr(strstr($_SERVER["REQUEST_URI"], '?'), strlen("?"));

if (strlen($url) <= 1)
    $url = "";
    ?>
    <div class="ovladani">
        <?php
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            $page = 0;
        }
        $predchoziStr = $page - 1;
        $dalsiStr = $page + 1;

        if ($page > 0) {
            ?>
            <a href="?page=<?php echo $predchoziStr.$url; ?>" class="btn-card">Předchozí pejsci</a>
            <?php
        }
        if ($cil == 4 && $pocetVypsatelnych > 4) {
            ?>
            <a href="?page=<?php echo $dalsiStr.$url; ?>" class="btn-card">Další pejsci</a>
            <?php
        }
        ?>
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

  <!-- Featherlight -->
  <script src="//cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>

</body>
</html>