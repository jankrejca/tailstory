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

  <title>TailStory - kontakt</title>

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
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="oazylu.php">O azylu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="jakpomoct.php">Jak pomoct</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link js-scroll-trigger" href="kontakt.php">Kontakt</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="oazylu">
  <div class="pl-5 pr-5 pb-5"><h1 class="display-4">Kontakt</h1></div>

      <!-- Tým -->
      <div class="container">
          <div class="row mx-auto">
              <?php
              $vypisTymu = $obsah->vratElementy("kontakt", "tym");
              foreach($vypisTymu as $tym) {
                  $obsahElementu = $tym->obsah;
                  $obrazek = $tym->obrazek;
                  ?>
                  <div class="col-xl-6 col-md-6 mb-4">
                      <div class="card border-0 shadow">
                          <img src="uploads/<?php echo $obrazek; ?>" class="card-img-top" alt="...">
                          <div class="card-body text-center">
                              <?php echo $obsahElementu; ?>
                              </div>
                          </div>
                      </div>
                  <?php
              }
              ?>
          </div>
          </div>

      <!-- Formulář -->
      <div class="container kontaktniformular">
          <div class="row">
              <div class="col-lg-6 col-sm-12 text-center">
                  <form method="post">
                  <label>Vaše jméno:</label><br><input type="text" name="jmeno" placeholder="Vaše jméno" /><br>
                  <label>Email:</label><br><input type="email" name="email" placeholder="Email" /><br>
                  <label>Telefon:</label><br><input type="tel" name="telefon" placeholder="Telefon"/><br>
                  <label>Zpráva:</label><br><textarea name="zprava" rows="8" placeholder="Zpráva"></textarea>
                  <label>odesláním souhlasíte se <a href="gdpr.php">zpracováním osobních údajů</a></label><input type="submit" name="odeslatEmail" value="Odeslat" class="btn-card">
              </form>
          </div>
              <?php
              $obsah->kontaktniFormular();
              $vypisAdres = $obsah->vratElementy("kontakt", "adresy");
              foreach($vypisAdres as $adresy) {
              $obsahElementu = $adresy->obsah;
              ?>
              <div class="col-lg-6 col-sm-12">
                  <?php echo $obsahElementu; ?>
                  <div class="w-100"><iframe style="width: 100%;" height="350" id="gmap_canvas" src="https://maps.google.com/maps?q=Vl%C4%8D%C3%AD%20Doly%2022&t=&z=9&ie=UTF8&iwloc=&output=embed"></iframe></div>
              </div>
              <?php
              }
              ?>
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