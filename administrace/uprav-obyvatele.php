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

    <title>TailStory - upravit obyvatele</title>
    <script src="../ckeditor/ckeditor.js"></script>

    <!-- Bootstrap kaskádové styly -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Kaskádové styly -->
    <link href="../css/style.css" rel="stylesheet">

    </head>

<body class="administrace">
<?php

        if(isset($_SESSION['username'])){
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
        $upravObyvatele = $obsah->vrat($zmen, "obyvatele");
        $datumVlozeni = date('Y-m-d\TH:i', strtotime($upravObyvatele->datum));
        $pohlavi = $upravObyvatele->pohlavi;
        $velikost = $upravObyvatele->velikost;
        $adoptovano = $upravObyvatele->adoptovano;
        ?>
            <div class="container admin pridatprispevek">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
            <form method="POST" action="zapisupravu-obyvatele.php?ID=<?php echo $zmen;?>" id="vlozit" enctype="multipart/form-data">
                <h1>Upravit obyvatele <?php echo $upravObyvatele->jmeno; ?></h1>
                <p><label>Datum vložení:</label><input type="datetime-local" name="datum" value="<?php echo $datumVlozeni;?>" required></p>
            <p><label>Adoptováno:</label>
                <select name="adoptovano">
                    <?php
                    switch ($adoptovano) {
                        case "0":
                            echo '<option value="0" selected>ne</option><option value="1">ano</option>';
                            break;
                        case "1":
                            echo '<option value="0">ne</option><option value="1" selected>ano</option>';
                            break;
                    }
                    ?>
                </select>
            </p>
            <p><label>Jméno:</label><input size="20" name="jmeno" value="<?php echo $upravObyvatele->jmeno;?>" required></p>
            <p><label>Pohlaví:</label>
                <select name="pohlavi">
                    <?php
                    switch ($pohlavi) {
                        case "pes":
                            echo '<option value="pes" selected>Pes</option><option value="fena">Fena</option>';
                            break;
                        case "fena":
                            echo '<option value="pes">Pes</option><option value="fena" selected>Fena</option>';
                            break;
                    }
                    ?>
                </select>
            </p>
            <p><label>Datum narození:</label><input type="date" size="20" name="narozeni" value="<?php echo $upravObyvatele->narozeni;?>" required></p>
            <p><label>Velikost: </label>
                <select name="velikost">
                <?php
                switch ($velikost) {
                    case "maly":
                        echo '<option value="maly" selected>Malý (do 30cm)</option><option value="stredni">Střední (31-60 cm)</option><option value="velky">Velký (61 cm a více)</option>';
                        break;
                    case "stredni":
                        echo '<option value="maly">Malý (do 30cm)</option><option value="stredni" selected>Střední (31-60 cm)</option><option value="velky">Velký (61 cm a více)</option>';
                        break;
                    case "velky":
                        echo '<option value="maly">Malý (do 30cm)</option><option value="stredni">Střední (31-60 cm)</option><option value="velky" selected>Velký (61 cm a více)</option>';
                        break;
                }
                        ?>
                </select>
            <p><label>Plemeno:</label><input size="30" name="plemeno" value="<?php echo $upravObyvatele->plemeno;?>" required></p>
            <p><label>Barva:</label><input size="20" name="barva" value="<?php echo $upravObyvatele->barva;?>" required></p>
            <p><label>Tetování:</label><input size="20" name="tetovani" value="<?php echo $upravObyvatele->tetovani;?>" required></p>
            <p><label>Kastrovaný:</label><input size="20" name="kastrovany" value="<?php echo $upravObyvatele->kastrovany;?>" required></p>
            <p><label>Handicapovaný:</label><input size="20" name="handicapovany" value="<?php echo $upravObyvatele->handicapovany;?>" required></p>
            <p><label>Miniatura (pokud nechcete nahrát novou, tohoto pole si nevšímejte):</label><br><img src="../uploads/<?php echo $upravObyvatele->obrazek; ?>" width="200" alt="Miniatura obyvatele" class="mb-3"><br><input type="file" name="miniatura" accept=".jpeg, .png, .gif, .jpg"></td></p>
           <p><label>Obsah: </label><textarea rows="3" cols="50" name="popis" required><?php echo $upravObyvatele->popis;?></textarea></p>
           <p><input type="submit" name="upravPrispevek" value="Upravit obyvatele"></p>
            </form>
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
                CKEDITOR.replace( 'popis' );
            </script>
        
                <?php
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