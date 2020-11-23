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

    <title>TailStory - upravit element</title>
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
                            <li class="nav-item">
                                <a class="nav-link" href="obyvatele-administrace.php">Obyvatelé</a>
                            </li>
                            <?php if ($_SESSION["opravneni"] == "administrator") { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="otazky-administrace.php">Otázky a odpovědi</a>
                            </li>
                            <li class="nav-item active">
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
        $upravElement = $obsah->vrat($zmen, "elementy");
        if (isset($_GET["nazev"]))
        $nazev = $_GET["nazev"];
        $bezObrazku = array("virtualniadopce", "adresy", "gdpr", "admin-email");
        ?>
            <div class="container admin pridatprispevek">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                        <h2 class="nadpis-administrace">Úprava elementu typu <?php echo $nazev; ?></h2>
            <form method="POST" action="zapisupravu-element.php?ID=<?php echo $zmen;?>" id="vlozit" enctype="multipart/form-data">
                <?php if (!in_array($nazev, $bezObrazku)) { ?><p><label>Obrázek (pokud nechcete nahrát nový, tohoto pole si nevšímejte): </label><br><img src="../uploads/<?php echo $upravElement->obrazek; ?>" width="200" alt="Miniatura elementu" class="mb-3"><br><input type="file" name="miniatura" accept=".jpeg, .png, .gif, .jpg"></td></p><?php } ?>
                <?php if ($nazev != "partner" && $nazev != "admin-email" && $nazev != "socialni") { echo '<p><label>Obsah: </label><br><textarea rows="3" cols="50" name="obsah" required>'.$upravElement->obsah.'</textarea></p>'; }
                else { echo "<p><label>Obsah: </label><input type='text' size='60' name='obsah' value='".$upravElement->obsah."' required></p>"; } ?>
           <p><input type="submit" name="upravElement" value="Upravit element"></p>
            </form>
            </div>
                </div>
            </div>

            <!-- Copyright -->
                <footer>
                    <?php $obsah->footer(false); ?>
                </footer>
    <?php if ($nazev != "partner" && $nazev != "admin-email" && $nazev != "socialni") { ?>
                <script>
                    // Replace the <textarea id="editor1"> with a CKEditor
                    // instance, using default configuration.
                    CKEDITOR.replace('obsah');
                </script>

                <?php
            }
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