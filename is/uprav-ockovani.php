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

    <title>TailStory - upravit očkování</title>

    <!-- Bootstrap kaskádové styly -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Kaskádové styly -->
    <link href="../css/style.css" rel="stylesheet">

    </head>

<body class="administrace">
<?php
if(isset($_SESSION['username'])) {
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
                                    <a class="nav-link" href="schuzky.php">Schůzky</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="ockovani.php">Očkování</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" style="color: yellow !important;" href="../administrace/">Administrace</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../administrace/logout.php">Odhlásit se</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

            <?php
        $zmen = $_GET["ID"];
        $upravOckovani = $obsah->vratUpravuOckovani($zmen);
        ?>
            <div class="container admin otazky">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                        <h1>Úprava očkování - <?php echo $upravOckovani->jmeno; ?></h1>
                        <form method="POST" action="zapisupravu-ockovani.php?ID=<?php echo $zmen;?>" id="vlozit">
                <p><label>Datum a čas:</label><br><input type="datetime-local" name="datum" value="<?php echo date('Y-m-d\TH:i', strtotime($upravOckovani->datum)); ?>" required></p>
                <p><label>Název:</label><br><input type="text" name="nazev" value="<?php echo $upravOckovani->nazev; ?>" required></p>
                            <p><input type="submit" name="upravOckovani" value="Upravit očkování"></p>
            </form>
            </div>
                </div>
            </div>

            <!-- Copyright -->
    <footer>
        <?php $obsah->footer(false); ?>
    </footer>
        
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