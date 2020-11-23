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

  <title>TailStory - otázky a odpovědi</title>

  <!-- Recaptcha -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>function get_action(form) {
            var v = grecaptcha.getResponse();
            if(v.length == 0)
            {
                document.getElementById('captcha').innerHTML="Nevyplnili jste potvrzení Captcha.";
                return false;
            }
            if(v.length != 0)
            {
                document.getElementById('captcha').innerHTML="Captcha splněna.";
                return true;
            }
        }</script>
    <script src="vypisAJAX.js"></script>

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
      <a class="navbar-brand js-scroll-trigger" href="index.php"><img src="img/logo.jpg" height="50" alt="Logo"></a>
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
          <li class="nav-item active">
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

  <?php
  if (isset($_GET["page"]))
  setcookie("page", $_GET["page"]);
  else
  setcookie("page", 0);
  ?>

  <section class="px-3 py-5 p-md-5">
      <p class="lead podkategorie" style="padding-left: 48px;"><a href="oazylu.php"><i class="fas fa-arrow-left pr-2"></i>O azylu</a></p>
  <div class="pl-5 pr-5 pb-5"><h1 class="display-4">Otázky a odpovědi</h1></div>
      <p class="text-center lead">Zeptejte se nás, my Vám rádi odpovíme.</p>
      <p class="text-center lead">Pod formulářem najdete již zodpovězené otázky.</p>
      <div class="container otazky">
          <div class="row">
              <div class="col-lg-12 col-sm-12 text-center">
                  <form method="post">
                      <label>Vaše jméno:</label><br><input type="text" name="autor" placeholder="Vaše jméno" /><br>
                      <label>Otázka:</label><br><textarea name="otazka" rows="4" placeholder="Zpráva"></textarea>
                      <div class="text-center"><div class="g-recaptcha" style="display: inline-block;" data-sitekey="6LeNKsgUAAAAAD1RYLNofnYsT1bbkCsHQebSm492"></div></div>
                      <p>odesláním souhlasíte se <a href="gdpr.php">zpracováním osobních údajů</a></p><input type="submit" value="Odeslat" name="vlozOtazku" class="btn-card">
                  </form>
              </div>

              <div class="container odpovedi" id="vypis">
                  <?php
                  include "vypis.php";
                  ?>
              </div>
              <div class="ovladani">
                  <?php
                  if (isset($_GET["page"]) && $_GET["page"] > 0) {
                      $page = $_GET["page"];
                      $cil = $start + 4;
                  }
                  else {
                      $page= 0;
                      $cil = 4;
                  }
                  $predchoziStr = $page - 1;
                  $dalsiStr = $page + 1;
                  $pocetPrispevku = $obsah->kolikOdpovedi();
                  if ($page > 0) {
                      ?>
                      <a href="?page=<?php echo $predchoziStr;?>" class="btn-card">Předchozí otázky</a>
                      <?php
                  }
                  if ($cil < $pocetPrispevku) {
                      ?>
                      <a href="?page=<?php echo $dalsiStr;?>" class="btn-card">Další otázky</a>
                      <?php
                  }
                  ?>
              </div>
          </div>
      </div>
  </section>

  <?php
  $obsah->vlozOtazku();
  ?>

  <button class="btn-card fixedButton" onclick="location.href='ztracen.php'">Ztratil jsem psa!</button>

  <footer>
      <?php $obsah->footer(true); ?>
     </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>