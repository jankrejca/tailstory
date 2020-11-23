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

  <title>TailStory - ztratil jsem psa</title>

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

  <section class="oazylu mb-5">
  <div class="pl-5 pr-5 pb-5"><h1 class="display-4 pb-1">Ztratil jsem psa</h1>
      <p>Napište nám prosím údaje o Vašem ztraceném psovi do formuláře, pokud o něm budeme mít nějaké informace, budeme Vás kontaktovat.</p></div>

      <!-- Formulář -->
      <div class="container-fluid schuzka">
          <div class="row">
              <div class="col-lg-12 col-sm-12 text-center">
                  <form method="post" enctype="multipart/form-data">
                  <?php if(isset($_GET["ID"]) && isset($_GET["jmeno"])) echo "<label>Jméno pejska: ".$_GET['jmeno']."</label>"; ?><br>
                  <label>Vaše jméno:</label><br><input type="text" name="jmeno" placeholder="Vaše jméno" required><br>
                  <label>Email:</label><br><input type="email" name="email" placeholder="Email" required /><br>
                  <label>Telefon:</label><br><input type="tel" name="telefon" placeholder="Telefon" required><br>
                  <label>Datum ztráty:</label><br><input type="date" name="datum"><br>
                  <label>Jméno psa:</label><br><input type="text" name="jmenopsa" placeholder="Jméno psa"><br>
                  <label>Pohlaví:</label><br><input type="text" name="pohlavi" placeholder="Pohlaví psa"><br>
                  <label>Plemeno:</label><br><input type="text" name="plemeno" placeholder="Plemeno"><br>
                  <label>Handicapovaný:</label><br><input type="text" name="handicapovany" placeholder="Handicapovaný"><br>
                  <label>Fotografie:</label><input type="file" name="miniatura" accept=".jpeg, .png, .gif, .jpg" required><br>
                  <input type="hidden" name="ID" value="<?php echo $_GET['ID']; ?>">
                  <label>odesláním souhlasíte se <a href="gdpr.php">zpracováním osobních údajů</a></label><br><input type="submit" name="vlozZtracen" value="Odeslat" class="btn-card">
              </form>
          </div>
          </div>
          </div>

  </section>

  <?php
  $obsah->vlozZtracen();
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