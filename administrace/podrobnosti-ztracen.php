<?php
session_start();
require_once '../tailstory.class.php';
$prihlaseni = new tailstory();
$prihlaseni->login();
$obsah = new tailstory();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="TailStory - azyl pro střední a velké psy, kteří by neměli kde jinde složit hlavu.">
    <meta name="author" content="Jan Krejča">

    <title>TailStory - podrobnosti ztraceného pejska</title>

    <!-- Bootstrap kaskádové styly -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Kaskádové styly -->
    <link href="../css/style.css" rel="stylesheet">

    </head>

<body class="administrace">
<?php

        if(isset($_SESSION['username'])){
            if ($_SESSION["opravneni"] == "administrator") {
            ?>
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
                                <a class="nav-link" href="aktuality-administrace.php">Aktuality</a>
                            </li>
                            <li class="nav-item active">
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

            <?php
        $zmen = $_GET["ID"];
        $zobrazZtraceneho = $obsah->vrat($zmen, "ztraceni");
        $datum = date("d. m. Y", strtotime($zobrazZtraceneho->datum));
        ?>
            <div class="container admin otazky">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
            <img src="../uploads/<?php echo $zobrazZtraceneho->obrazek; ?>" height="420" class="mb-5" alt="Ztracený pejsek">
                        <p><span class="font-weight-bold">Jméno majitele:</span> <?php echo $zobrazZtraceneho->jmeno; ?></p>
                        <p><span class="font-weight-bold">Email majitele:</span> <?php echo $zobrazZtraceneho->email; ?></p>
                        <p><span class="font-weight-bold">Telefon majitele:</span> <?php echo $zobrazZtraceneho->telefon; ?></p>
                        <p><span class="font-weight-bold">Datum ztráty:</span> <?php echo $datum; ?></p>
                        <p><span class="font-weight-bold">Jméno psa:</span> <?php echo $zobrazZtraceneho->jmenopsa; ?></p>
                        <p><span class="font-weight-bold">Pohlaví:</span> <?php echo $zobrazZtraceneho->pohlavi; ?></p>
                        <p><span class="font-weight-bold">Plemeno:</span> <?php echo $zobrazZtraceneho->plemeno; ?></p>
                        <p><span class="font-weight-bold">Handicapovaný:</span> <?php echo $zobrazZtraceneho->handicapovany; ?></p>
            </div>
                </div>
            </div>


            <!-- Copyright -->
                <footer>
                    <?php $obsah->footer(false); ?>
                </footer>
    <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'obsah' );
            </script>
        
                <?php
        } else {
                echo "<h2 class='text-center'>Nemáte dostatečná oprávnění pro přístup do této sekce.</h2>";
            }
        }
                else {
            header ('Location: index.php');
        }
?>

<!-- Bootstrap core JavaScript -->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>