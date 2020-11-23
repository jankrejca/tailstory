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

    <title>TailStory - nový příspěvek</title>
    <script src="../ckeditor/ckeditor.js"></script>

    <!-- Bootstrap kaskádové styly -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Kaskádové styly -->
    <link href="../css/style.css" rel="stylesheet">

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
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
                <li class="nav-item">
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
            <div class="container admin pridatprispevek">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <form method="POST" id="vlozit" enctype="multipart/form-data">
                            <h1>Přidat nového obyvatele</h1>
                            <p><label>Jméno:</label><input size="20" name="jmeno" required></p>
                            <p><label>Pohlaví:</label>
                                <select name="pohlavi">
                                    <option value="pes">Pes</option>
                                    <option value="fena">Fena</option>
                                </select></p>
                            <p><label>Datum narození:</label><input type="date" size="20" name="narozeni" required></p>
                            <p><label>Velikost:</label>
                                <select name="velikost">
                                    <option value="maly">Malý (do 30cm)</option>
                                    <option value="stredni">Střední (31-60 cm)</option>
                                    <option value="velky">Velký (61 cm a více)</option>
                                </select>
                            </p>
                            <p><label>Plemeno:</label><input size="30" name="plemeno" required></p>
                            <p><label>Barva:</label><input size="20" name="barva" required></p>
                            <p><label>Tetování:</label>
                                <select name="tetovani">
                                    <option value="ano">ano</option>
                                    <option value="ne">ne</option>
                                </select></p>
                            </p>
                            <p><label>Kastrovaný:</label>
                                <select name="kastrovany">
                                    <option value="ano">ano</option>
                                    <option value="ne">ne</option>
                                </select></p>
                            </p>
                            <p><label>Handicapovaný:</label><input size="20" name="handicapovany" required></p>
                            <p><label>Fotografie:</label><input type="file" name="miniatura" accept=".jpeg, .png, .gif, .jpg" required></td></p>
                            <p><label>Obsah: </label><textarea rows="3" cols="50" name="popis" required></textarea></p>
                            <p><input type="submit" name="vlozObyvatele" value="Vložit obyvatele"></p>
                        </form>
                    </div>
                </div>
            </div>
                    
        <?php
        $obsah->vlozObyvatele();
        }
        else {
            $obsah->loginForm();
        }
        ?>
    <!-- Copyright -->
<footer>
    <?php $obsah->footer(false); ?>
</footer>
<script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'popis' );
            </script>

<!-- Bootstrap core JavaScript -->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>