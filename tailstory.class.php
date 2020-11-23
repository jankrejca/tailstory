<?php

class tailstory
{
    public $conn;

    public function __construct()
    {
        $dbname = "krejcja";
        $user = "krejcja";
        $pass = "2222";
        $dsn = "mysql:host=localhost;dbname=$dbname;port=3306";
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            $this->conn = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            echo "Nelze se připojit k MySQL: ";
            echo $e->getMessage();
        }
    }

    public function login()
    {
        if (isset($_SESSION['username']) || isset($_COOKIE['username'])) {
            $text = "Již jste přihlášen.";
        } else {
            if (isset($_POST["prihlas"])) {
                if (isset($_POST["jmeno"]) && isset($_POST["heslo"])) {
                    try {
                        $stmt = $this->conn->prepare("SELECT * FROM `uzivatele` WHERE `jmeno` = :jmeno ;");
                        $stmt->bindParam(':jmeno', $_POST['jmeno']);
                        $stmt->execute();
                        $dotaz = $stmt->fetchAll(PDO::FETCH_OBJ);
                    } catch (PDOException $e) {
                        echo "Chyba čtení tabulky: ";
                        echo $e->getMessage();
                    }
                    if (empty($dotaz) && $_POST["jmeno"] != "")
                        echo "<div class='alert alert-danger w-100 fixed-top' role='alert'>Zadali jste špatně jméno.</div>";
                    else if (!empty($dotaz) && $_POST["jmeno"] != "") {
                        $dotaz = $dotaz[0];
                        if (($dotaz->heslo) == md5($_POST["heslo"])) {
                            $_SESSION['username'] = $_POST['jmeno'];
                            $_SESSION["autor_ID"] = $dotaz->ID;
                            $_SESSION["opravneni"] = $dotaz->opravneni;
                            echo "Byl jste přihlášen.";
                            echo "<br>";
                        } else {
                            echo "<div class='alert alert-danger w-100 fixed-top' role='alert'>Zadané heslo není správné.</div>";
                        }
                    }
                }
            }
        }
    }

    public function loginForm()
    {
        echo '<div class="container">
      <div class="row w-50 mx-auto">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="login-form text-center mt-2 p-5">
            
               <form method="POST" action="">
                  <div class="form-group">
                     <label>Přihlašovací jméno:</label>
                     <input type="text" name="jmeno" class="form-control" placeholder="Přihlašovací jméno">
                  </div>
                  <div class="form-group">
                     <label>Heslo</label>
                     <input type="password" name="heslo" class="form-control" placeholder="Heslo">
                  </div>
                  <input type="submit" name="prihlas" class="btn-card btn mt-3" value="Přihlásit se">
               </form>
            </div>
         </div>
      </div>
     </div>';
    }

    public function footer($frontend) {
        if ($frontend == true) {
            echo '<section class="text-center social">
          <div class="container">
              <div class="row">

                  <div class="col-lg-4 mb-5 mb-lg-0">
                      <h4 class="text-uppercase mb-4">Kontakt</h4>
                      <p class="lead mb-0">Vlčí Doly 22
        <br>768 33 Věžky
        <br>+420 605 513 316
        <br>info@tailstory.cz</p>
                  </div>

                  <div class="col-lg-4 mb-5 mb-lg-0">
                      <h4 class="text-uppercase mb-4">Sociální sítě</h4>';
                            $vypisSocialni = $this->vratElementy("ostatni", "socialni");
                        foreach($vypisSocialni as $socialni) {
                            echo '<a class="mx-1" href="'.$socialni->obsah.'" target="_blank">
                          <img src="uploads/'.$socialni->obrazek.'" width="32" alt="Sociální sítě">
                      </a>'; }
                      echo '<h4 class="text-uppercase mt-4"><a href="otazkyodpovedi.php">FAQ</a></h4>
                  </div>

                  <div class="col-lg-4">
                      <h4 class="text-uppercase mb-4">Další informace</h4>
                      <p class="lead mb-0">Tail Story z.s.<br>Boršice 593, 687 09  Boršice<br>IČ: 06658466<br>č. ú.: 2401354319/2010</p>
                  </div>

              </div>
          </div>
      </section>';
        }
        echo '
        <!-- Copyright -->
      <div class="container-fluid py-4 text-center text-white copyright">
          <small>Copyright &copy; TailStory.cz '.date("Y").'</small>
          <div>Ikony použity z <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> z <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
          <div>Fotografie použity z <a href="https://pixabay.com/">Pixabay</a></div>
      </div>';
    }

    public function kolikZaznamu($tabulka)
    {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM `" . $tabulka . "`;");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo 'Chyba čtení tabulky: ';
            echo $e->getMessage();
        }
    }

    public function vratTabulku($tabulka) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM `" . $tabulka . "`  ORDER BY `ID` DESC;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Chyba čtení tabulky: ';
            echo $e->getMessage();
        }
    }

    public function vratPrispevky($start, $cil) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM `aktuality` ORDER BY `datum` DESC LIMIT :start, :cil;");
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':cil', $cil, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Chyba čtení tabulky: ';
            echo $e->getMessage();
        }
    }

    public function smaz($ID, $tabulka) {
        if (is_numeric($ID)) {
            try {
                $stmt = $this->conn->prepare("DELETE FROM `" . $tabulka . "` WHERE `ID` = :id ;");
                $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            return TRUE;
        } else {
            //$ID není číslo
            return FALSE;
        }
    }

    public function vrat($ID, $tabulka) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM `" . $tabulka . "` WHERE `ID` =:ID;");
            $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ) [0];
        } catch (PDOException $e) {
            echo 'Chyba čtení tabulky: ';
            echo $e->getMessage();
        }
    }

    public function upravPrispevek($ID, $prispevek, $nadpis, $datum, $obrazek) {
        if (is_numeric($ID) && $prispevek != "" && $nadpis != "") {
            if (!empty($obrazek))
            $nazevObrazku = $this->nahratObrazek($obrazek, null);
            try {
                if (!empty($obrazek))
                $stmt = $this->conn->prepare("UPDATE `aktuality` SET `datum`=:datum, `obsah`=:obsah, `nadpis`=:nadpis, `autor`=:autor, `obrazek`=:obrazek WHERE `ID` = :id ;");
                else
                $stmt = $this->conn->prepare("UPDATE `aktuality` SET `datum`=:datum, `obsah`=:obsah, `nadpis`=:nadpis, `autor`=:autor WHERE `ID` = :id ;");
                $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
                $stmt->bindParam(':datum', $datum);
                $stmt->bindParam(':obsah', $prispevek);
                $stmt->bindParam(':nadpis', $nadpis);
                $stmt->bindParam(':autor', $_SESSION["username"]);
                if (!empty($obrazek))
                $stmt->bindParam(':obrazek', $nazevObrazku);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            return TRUE;
        }  else {
            //$ID není číslo
            return FALSE;
        }
    }

    public function vlozPrispevek() {
        if (isset($_POST["vlozPrispevek"]) && isset($_POST["obsah"])) {
            $nadpis = htmlspecialchars($_POST["nadpis"]);
            if (!empty($_FILES["miniatura"]['name'])) {
                $nazevObrazku = $this->nahratObrazek($_FILES["miniatura"]['name'], null);
            } else {
                $nazevObrazku = "logo.jpg";
            }
            try {
                    $stmt = $this->conn->prepare("INSERT INTO `aktuality` (`ID`, `obsah`, `nadpis`, `autor`, `obrazek`) VALUES (NULL, :obsah, :nadpis, :autor, :obrazek);");
                    $stmt->bindParam(':nadpis', $nadpis);
                    $stmt->bindParam(':obsah', $_POST["obsah"]);
                    $stmt->bindParam(':autor', $_SESSION["username"]);
                    $stmt->bindParam(':obrazek', $nazevObrazku);
                    $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    public function vratObyvatele($start, $cil, $adoptovano) {
        try {
            if (isset($_GET["pohlavi"]))
            $pohlavi = $_GET["pohlavi"];
            else
                $pohlavi = ["pes", "fena"];

            if (isset($_GET["velikost"]))
                $velikost = $_GET["velikost"];
            else
                $velikost = ["maly", "stredni","velky"];

            if (isset($_GET["plemeno"]))
                $plemeno = $_GET["plemeno"];
            else {
                $vratPlemena = $this->vratPlemena();
                $plemeno = array();
                foreach ($vratPlemena as $vypisPlemeno) {
                    $plemeno[] = $vypisPlemeno->plemeno;
                }
            }
            $filtry = array(
                'pohlavi' => $pohlavi,
                'velikost' => $velikost,
                'plemeno' => $plemeno
            );
            $where = array();
            foreach ($filtry as $key=>$values) {
                if (is_array($values) && count($values)) {
foreach ($values as $index=>$value) {
    $values[$index] = $value;
}
$where[] = $key." IN ('".implode('\',\'', $values)."')";
}
            }
            $where = implode(' AND ', $where);
            $stmt = $this->conn->prepare("SELECT *, (SELECT COUNT(*) FROM `obyvatele` WHERE " . $where . " AND `adoptovano` =:adoptovano) AS `pocet` FROM `obyvatele` WHERE " . $where . " AND `adoptovano` =:adoptovano  ORDER BY `datum` DESC LIMIT :start, :cil;");
            // pocet se následně používá na frontendu v souvislosti s listovadlem
            $stmt->bindParam(':adoptovano', $adoptovano);
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':cil', $cil, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Chyba čtení tabulky: ';
            echo $e->getMessage();
        }
    }

    public function vratObyvateleAdmin() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM `obyvatele`  ORDER BY `adoptovano` ASC, `datum` DESC;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Chyba čtení tabulky: ';
            echo $e->getMessage();
        }
    }

    public function stavObyvatele() {
        if (isset($_POST["stav"])) {
            echo "<meta http-equiv='refresh' content='0'>";
            $ID = $_POST["ID"];
            $adoptovano = $_POST["stav"];
            if ($adoptovano == "ANO")
                $adoptovano = "0";
            else
                $adoptovano = "1";
            try {
                $stmt = $this->conn->prepare("UPDATE `obyvatele` SET `adoptovano`=:adoptovano WHERE `ID` = :id;");
                $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
                $stmt->bindParam(':adoptovano', $adoptovano);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Chyba čtení tabulky: ';
                echo $e->getMessage();
            }
        }
    }


    public function upravObyvatele($ID, $datum, $jmeno, $pohlavi, $narozeni, $velikost, $plemeno, $barva, $tetovani, $kastrovany, $handicapovany, $popis, $obrazek, $adoptovano) {
        if (is_numeric($ID) && $popis != "" && $jmeno != "") {
            if (!empty($obrazek))
            $jmenoObrazku = $this->nahratObrazek($obrazek, null);
            try {
                if (!empty($obrazek))
                    $stmt = $this->conn->prepare("UPDATE `obyvatele` SET `datum`=:datum, `jmeno`=:jmeno,`pohlavi`=:pohlavi,`narozeni`=:narozeni,`velikost`=:velikost,`plemeno`=:plemeno,`barva`=:barva,`tetovani`=:tetovani,`kastrovany`=:kastrovany,`handicapovany`=:handicapovany,`popis`=:popis, `obrazek`=:obrazek, `adoptovano`=:adoptovano WHERE `ID` = :id ;");
                else
                    $stmt = $this->conn->prepare("UPDATE `obyvatele` SET `datum`=:datum, `jmeno`=:jmeno,`pohlavi`=:pohlavi,`narozeni`=:narozeni,`velikost`=:velikost,`plemeno`=:plemeno,`barva`=:barva,`tetovani`=:tetovani,`kastrovany`=:kastrovany,`handicapovany`=:handicapovany,`popis`=:popis, `adoptovano`=:adoptovano WHERE `ID` = :id ;");
                $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
                $stmt->bindParam(':datum', $datum);
                $stmt->bindParam(':jmeno', $jmeno);
                $stmt->bindParam(':pohlavi', $pohlavi);
                $stmt->bindParam(':narozeni', $narozeni);
                $stmt->bindParam(':velikost', $velikost);
                $stmt->bindParam(':plemeno', $plemeno);
                $stmt->bindParam(':barva', $barva);
                $stmt->bindParam(':tetovani', $tetovani);
                $stmt->bindParam(':kastrovany', $kastrovany);
                $stmt->bindParam(':handicapovany', $handicapovany);
                $stmt->bindParam(':popis', $popis);
                if (!empty($obrazek))
                $stmt->bindParam(':obrazek', $jmenoObrazku);
                $stmt->bindParam(':adoptovano', $adoptovano);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            return TRUE;
        } else {
            //$ID není číslo
            return FALSE;
        }
    }

    public function vlozObyvatele() {
        if (isset($_POST["vlozObyvatele"]) && isset($_POST["popis"]) && !empty($_FILES["miniatura"])) {
            $jmeno = htmlspecialchars($_POST["jmeno"]);
            $jmenoObrazku = $this->nahratObrazek($_FILES['miniatura']['name'], null);
            try {
                $stmt = $this->conn->prepare("INSERT INTO `obyvatele` (`ID`, `jmeno`, `pohlavi`, `narozeni`, `velikost`, `plemeno`, `barva`, `tetovani`, `kastrovany`, `handicapovany`, `popis`, `obrazek`) VALUES (NULL, :jmeno, :pohlavi, :narozeni, :velikost, :plemeno, :barva, :tetovani, :kastrovany, :handicapovany, :popis, :obrazek);");
                $stmt->bindParam(':jmeno', $jmeno);
                $stmt->bindParam(':pohlavi', $_POST["pohlavi"]);
                $stmt->bindParam(':narozeni', $_POST["narozeni"]);
                $stmt->bindParam(':velikost', $_POST["velikost"]);
                $stmt->bindParam(':plemeno', $_POST["plemeno"]);
                $stmt->bindParam(':barva', $_POST["barva"]);
                $stmt->bindParam(':tetovani', $_POST["tetovani"]);
                $stmt->bindParam(':kastrovany', $_POST["kastrovany"]);
                $stmt->bindParam(':handicapovany', $_POST["handicapovany"]);
                $stmt->bindParam(':popis', $_POST["popis"]);
                $stmt->bindParam(':obrazek', $jmenoObrazku);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    public function kolikAdopciNeadopci($boolean) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM `obyvatele` WHERE `adoptovano` =:boolean;");
            $stmt->bindParam(':boolean', $boolean);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo 'Chyba čtení tabulky: ';
            echo $e->getMessage();
        }
    }

    function spocitejVek($narozeni) {
        $dnes = date("Y-m-d");
        $vek = date_diff(date_create($narozeni), date_create($dnes));
        if ($vek->format('%y') < 2) {
            return $vek->format(' %y rok');
        } else if ($vek->format('%y') < 5) {
            return $vek->format(' %y roky');
        } else {
            return $vek->format(' %y let');
        }
    }

    public function vratElementy($stranka, $nazev) {
            try {
                $stmt = $this->conn->prepare("SELECT * FROM `elementy` where `nazev`=:nazev AND `stranka`=:stranka order by `nazev` DESC;");
                $stmt->bindParam(':nazev', $nazev);
                $stmt->bindParam(':stranka', $stranka);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                echo 'Chyba čtení tabulky: ';
                echo $e->getMessage();
            }
        }

    public function vratElementyAdmin($stranka) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM `elementy` where `stranka`=:stranka order by `nazev` DESC;");
            $stmt->bindParam(':stranka', $stranka);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Chyba čtení tabulky: ';
            echo $e->getMessage();
        }
    }

    public function vypisPrvniSlova($string, $pocetSlov) {
        // odstraní whitespace a HTML tagy
        $string = trim(strip_tags($string));
        // rozdělí do stringů po slovech
        $stringSplit = preg_split('/ /',$string);
        $vystup = "";
        for ($x=0; $x<$pocetSlov; $x++) {
            if (isset($stringSplit[$x]))
            $vystup .=  $stringSplit[$x]." ";
        }
        return $vystup;
    }

    public function upravElement($ID, $obrazek, $obsah) {
        if (isset($_POST["upravElement"])) {
            if (!empty($obrazek))
            $jmenoObrazku = $this->nahratObrazek($obrazek, null);
            try {
                if (!empty($obrazek))
                    $stmt = $this->conn->prepare("UPDATE `elementy` SET `obrazek`=:obrazek, `obsah`=:obsah WHERE `ID` = :ID ;");
                else
                    $stmt = $this->conn->prepare("UPDATE `elementy` SET `obsah`=:obsah WHERE `ID` = :ID ;");
                $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
                if (!empty($obrazek))
                $stmt->bindParam(':obrazek', $jmenoObrazku);
                $stmt->bindParam(':obsah', $obsah);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            return TRUE;
        }
    }

    public function vlozElement($stranka, $nazev) {
        if (isset($_POST["vlozElement"]) && isset($_POST["obsah"])) {
            if (!empty($_FILES["miniatura"]))
            $nazevObrazku = $this->nahratObrazek($_FILES['miniatura']['name'], null);
            try {
                if (!empty($_FILES["miniatura"]))
                    $stmt = $this->conn->prepare("INSERT INTO `elementy` (`ID`, `stranka`, `nazev`, `obsah`, `obrazek`) VALUES (NULL, :stranka, :nazev, :obsah, :obrazek);");
                else
                    $stmt = $this->conn->prepare("INSERT INTO `elementy` (`ID`, `stranka`, `nazev`, `obsah`) VALUES (NULL, :stranka, :nazev, :obsah);");
                $stmt->bindParam(':stranka', $stranka);
                $stmt->bindParam(':nazev', $nazev);
                $stmt->bindParam(':obsah', $_POST["obsah"]);
                if (!empty($_FILES["miniatura"]))
                $stmt->bindParam(':obrazek', $nazevObrazku);
                $stmt->execute();
            }
            catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    public function casCteni($obsahprispevku) {
        // sečte počet slov po odstranění HTML tagů
        $slova = str_word_count(strip_tags($obsahprispevku));
        // floor zaokrouhluje dolů
        $minuty = floor($slova / 120);

        if ($minuty<1) {
            $cas = "méně než 1 minuta";
        }
        if ($minuty==1) {
            $cas = $minuty . " minuta";
        }
        else if ($minuty>1) {
            $cas = $minuty . " minuty";
        }
        else if ($minuty>4) {
            $cas = $minuty . " minut";
        }
        return $cas;
    }

    public function vratPlemena() {
        try {
            $stmt = $this->conn->prepare("SELECT DISTINCT `plemeno` FROM `obyvatele` order by `plemeno` ASC;");
            $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Chyba čtení tabulky: ';
            echo $e->getMessage();
        }
    }

    public function vlozOtazku() {
        if (isset($_POST["vlozOtazku"])) {
            $captcha = $_POST["g-recaptcha-response"];
            if (!$captcha) {
                echo "<script> alert('Ověřte prosím, že nejste robot.')</script>";
                exit;
            }
            $secretKey = "6LeNKsgUAAAAACC6dKeno9tC56Un-haRuMg_S8d1";
            $ip = $_SERVER["REMOTE_ADDR"];
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
            $responseKeys = json_decode($response, true);
            if (isset($_POST["otazka"]) && intval($responseKeys["success"]) == 1) {
                $dnes = date("Y-m-d");
                try {
                    $stmt = $this->conn->prepare("INSERT INTO `otazky` (`ID`, `datum`, `autor`, `otazka`,`odpoved`) VALUES (NULL, :datum, :autor, :otazka, NULL);");
                    $stmt->bindParam(':datum', $dnes);
                    $stmt->bindParam(':autor', $_POST["autor"]);
                    $stmt->bindParam(':otazka', $_POST["otazka"]);
                    $stmt->execute();
                    echo "<meta http-equiv='refresh' content='0'>";
                    echo "<div class='alert alert-success position-absolute w-100 pb-3' role='alert'>Otázka byla úspěšně odeslána, pokusíme se na ni co nejdříve odpovědět.</div>";
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
        }
    }

    public function vratOtazky() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM `otazky` ORDER BY `datum` DESC;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Chyba čtení tabulky: ';
            echo $e->getMessage();
        }
    }

    public function kolikOdpovedi() {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM `otazky` WHERE `odpoved` is not NULL;");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo 'Chyba čtení tabulky: ';
            echo $e->getMessage();
        }
    }

    public function upravOtazku($ID, $autor, $otazka, $odpoved) {
        if (isset($_POST["upravOtazku"])) {
            try {
                $stmt = $this->conn->prepare("UPDATE `otazky` SET `autor`=:autor, `otazka`=:otazka, `odpoved`=:odpoved WHERE `ID` = :ID ;");
                $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
                $stmt->bindParam(':autor', $autor);
                $stmt->bindParam(':otazka', $otazka);
                $stmt->bindParam(':odpoved', $odpoved);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            return TRUE;
        }
    }

    public function vratOdpovedi($start, $cil) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM `otazky` WHERE `odpoved` IS NOT NULL ORDER BY `datum` DESC LIMIT :start, :cil;");
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':cil', $cil, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Chyba čtení tabulky: ';
            echo $e->getMessage();
        }
    }

    public function kontaktniFormular() {
        if (isset($_POST["odeslatEmail"]) && isset($_POST["jmeno"]) && isset($_POST["email"]) && isset($_POST["telefon"]) && isset($_POST["zprava"])) {
                $jmeno = $_POST["jmeno"];
                $email = $_POST["email"];
                $telefon = $_POST["telefon"];
                $zprava = $_POST["zprava"];
                $adresa = $this->vratElementy("ostatni", "admin-email")[0]->obsah;
                $obsah = 'MIME-Version: 1.0' . "\r\n";
                $obsah .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $obsah = " Od: $jmeno \n Email: $email \n Telefonní číslo: $telefon \n Zpráva: $zprava";
                $hlavicka = "Od: $email \r\n";
                $predmet = "Kontaktní formulář na webu";
                $uspech = mail($adresa, '=?utf-8?B?'.base64_encode($predmet).'?=', $obsah, $hlavicka);
                if ($uspech) {
                    echo "<div class='alert alert-success position-absolute w-100 admin-alert' role='alert'>Formulář byl úspěšně odeslán.</div>";
                }
                else
                    echo "<div class='alert alert-danger position-absolute w-100 admin-alert' role='alert'>Formulář se nepodařilo odeslat, zkuste to prosím znovu.</div>";
            }
        }

        public function zadostSchuzka() {
                if (isset($_POST["vlozSchuzku"]) && isset($_POST["jmeno"])) {
                    $jmeno = htmlspecialchars($_POST["jmeno"]);
                    $email = htmlspecialchars($_POST["email"]);
                    $telefon = htmlspecialchars($_POST["telefon"]);
                    $datum = htmlspecialchars($_POST["datum"]);
                    $cas = htmlspecialchars($_POST["cas"]);
                    $poznamka = htmlspecialchars($_POST["poznamka"]);
                    $IDpsa = $_POST["pes"];
                    try {
                        $stmt = $this->conn->prepare("INSERT INTO `schuzky` (`ID`, `jmeno`, `email`, `telefon`, `datum`, `cas`, `poznamka`, `IDpsa`) VALUES (NULL, :jmeno, :email, :telefon, :datum, :cas, :poznamka, :IDpsa);");
                        $stmt->bindParam(':jmeno', $jmeno);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':telefon', $telefon);
                        $stmt->bindParam(':datum', $datum);
                        $stmt->bindParam(':cas', $cas);
                        $stmt->bindParam(':poznamka', $poznamka);
                        $stmt->bindParam(':IDpsa', $IDpsa, PDO::PARAM_INT);
                        $stmt->execute();
                        echo "<div class='alert alert-success position-absolute w-100' role='alert'>Formulář byl úspěšně odeslán.</div>";
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                }
            }

    public function stavSchuzky() {
        if (isset($_POST["stavSchuzky"])) {
            echo "<meta http-equiv='refresh' content='0'>";
            $ID = $_POST["ID"];
            $schvaleno = $_POST["stavSchuzky"];
            if ($schvaleno == "ANO")
                $schvaleno = "0";
            else
                $schvaleno = "1";
            try {
                $stmt = $this->conn->prepare("UPDATE `schuzky` SET `schvaleno`=:schvaleno WHERE `ID` = :id;");
                $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
                $stmt->bindParam(':schvaleno', $schvaleno);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Chyba čtení tabulky: ';
                echo $e->getMessage();
            }
        }
    }

    public function upravSchuzku($ID, $datum, $cas) {
        if (isset($_POST["upravSchuzku"])) {
            try {
                $stmt = $this->conn->prepare("UPDATE `schuzky` SET `datum`=:datum, `cas`=:cas WHERE `ID` = :ID;");
                $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
                $stmt->bindParam(':datum', $datum);
                $stmt->bindParam(':cas', $cas);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            return TRUE;
        }
    }


    public function vlozZtracen() {
        if (isset($_POST["vlozZtracen"])) {
            if (isset($_POST["jmeno"]) && isset($_POST["email"]) && isset($_POST["telefon"]) && isset($_POST["datum"]) && isset($_POST["jmenopsa"]) && isset($_POST["pohlavi"]) && isset($_POST["plemeno"]) && isset($_POST["handicapovany"]) && !empty($_FILES["miniatura"])) {
                $nazevObrazku = $this->nahratObrazek($_FILES['miniatura']['name'], 1);
                try {
                    $stmt = $this->conn->prepare("INSERT INTO `ztraceni` (`ID`, `jmeno`, `email`, `telefon`, `datum`, `jmenopsa`, `pohlavi`, `plemeno`, `handicapovany`, `obrazek`) VALUES (NULL, :jmeno, :email, :telefon, :datum, :jmenopsa, :pohlavi, :plemeno, :handicapovany, :obrazek);");
                    $stmt->bindParam(':jmeno', $_POST["jmeno"]);
                    $stmt->bindParam(':email', $_POST["email"]);
                    $stmt->bindParam(':telefon', $_POST["telefon"]);
                    $stmt->bindParam(':datum', $_POST["datum"]);
                    $stmt->bindParam(':jmenopsa', $_POST["jmenopsa"]);
                    $stmt->bindParam(':pohlavi', $_POST["pohlavi"]);
                    $stmt->bindParam(':plemeno', $_POST["plemeno"]);
                    $stmt->bindParam(':handicapovany', $_POST["handicapovany"]);
                    $stmt->bindParam(':obrazek', $nazevObrazku);
                    $stmt->execute();
                    echo "<div class='alert alert-success position-absolute w-100' role='alert'>Formulář byl úspěšně odeslán.</div>";
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
            else
                echo "<div class='alert alert-danger position-absolute w-100' role='alert'>Nebylo vyplněno některé z polí.</div>";
        }
    }

    public function stavZasob() {
        if (isset($_POST["stavZasob"])) {
            echo "<meta http-equiv='refresh' content='0'>";
            $ID = $_POST["ID"];
            $varianta = $_POST["stavZasob"];
            if ($varianta == "-")
                $varianta = "-1";
            else
                $varianta = "+1";
            try {
                $stmt = $this->conn->prepare("UPDATE `stavy` SET `pocet`= `pocet` ".$varianta." WHERE `ID` = :id;");
                $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Chyba čtení tabulky: ';
                echo $e->getMessage();
            }
        }
    }

    public function upravUzivatele($ID, $email, $heslo, $opravneni) {
        if (!is_null($heslo)) {
            try {
                $stmt = $this->conn->prepare("UPDATE `uzivatele` SET `email`=:email, `heslo`=:heslo, `opravneni`=:opravneni WHERE `ID` = :id ;");
                $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':heslo', $heslo);
                $stmt->bindParam(':opravneni', $opravneni);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            return TRUE;
        } else if (!isset($heslo)) {
            try {
                $stmt = $this->conn->prepare("UPDATE `uzivatele` SET `email`=:email, `opravneni`=:opravneni WHERE `ID` = :id ;");
                $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':opravneni', $opravneni);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            return TRUE;
        } else {
            //$ID není číslo
            return FALSE;
        }
    }

    public function vlozUzivatele() {
        if (isset($_POST["vlozUzivatele"]) && isset($_POST["jmeno"]) && isset($_POST["heslo"]) && isset($_POST["heslo2"])) {
            $jmeno = $_POST["jmeno"];
            $email = $_POST["email"];
            if ($_POST["heslo"] == $_POST["heslo2"])
                $heslo = md5($_POST["heslo"]);
            else {
             echo "Hesla se neshodují.";
             exit;
            }
            $opravneni = $_POST["opravneni"];
            try {
                $stmt = $this->conn->prepare("INSERT INTO `uzivatele` (`ID`, `jmeno`, `email`, `heslo`, `opravneni`) VALUES (NULL, :jmeno, :email, :heslo, :opravneni);");
                $stmt->bindParam(':jmeno', $jmeno);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':heslo', $heslo);
                $stmt->bindParam(':opravneni', $opravneni);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    public function vlozNavstevu() {
        $datum = date("Y-m-d");
        try {
        $stmt = $this->conn->prepare("INSERT INTO `navstevnost` (`ID`, `ip`, `datum`) VALUES (NULL, :ip, :datum);");
        $stmt->bindParam(':ip',$_SERVER["REMOTE_ADDR"]);
        $stmt->bindParam(':datum',$datum);
        $stmt->execute();
    }
        catch (PDOException $e) {
        echo $e->getMessage();
}
    }

    public function navstevnost() {
        try{
            $stmt = $this->conn->prepare("SELECT count( ID ) AS celkem, count( DISTINCT `ip` ) AS UN, count( DISTINCT `IP` , `datum` ) AS UDN FROM `navstevnost`");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ)[0];
        } catch (PDOException $e) {
            echo "Chyba čtení tabulky: ";
            echo $e->getMessage();
        }
    }

    public function vlozPoznamku() {
        if (isset($_POST["vlozPoznamku"]) && $_POST["obsah"] != "") {
            $obsah = $_POST["obsah"];
            $datum = date("Y-m-d H:i:s");
            try {
                $stmt = $this->conn->prepare("INSERT INTO `poznamky` (`ID`, `obsah`, `datum`, `autor`) VALUES (NULL, :obsah, :datum, :autor);");
                $stmt->bindParam(':obsah', $obsah);
                $stmt->bindParam(':datum', $datum);
                $stmt->bindParam(':autor', $_SESSION["username"]);
                $stmt->execute();
                header("Location: index.php#poznamky");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    public function vratOckovani() {
        try {
            $stmt = $this->conn->prepare("SELECT `ockovani`.*, `obyvatele`.jmeno FROM `ockovani` JOIN `obyvatele` on `ockovani`.`IDpsa` = `obyvatele`.`ID` ORDER BY `datum` ASC;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Chyba čtení tabulky: ';
            echo $e->getMessage();
        }
    }

    public function vratUpravuOckovani($ID) {
        try {
            $stmt = $this->conn->prepare("SELECT `ockovani`.*, `obyvatele`.jmeno FROM `ockovani` JOIN `obyvatele` on `ockovani`.`IDpsa` = `obyvatele`.`ID` WHERE `ockovani`.`ID` =:id;");
            $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ)[0];
        } catch (PDOException $e) {
            echo 'Chyba čtení tabulky: ';
            echo $e->getMessage();
        }
    }

    public function upravOckovani($ID, $datum, $nazev) {
        if (isset($_POST["upravOckovani"])) {
            try {
                $stmt = $this->conn->prepare("UPDATE `ockovani` SET `datum`=:datum, `nazev`=:nazev WHERE `ID` = :ID;");
                $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
                $stmt->bindParam(':datum', $datum);
                $stmt->bindParam(':nazev', $nazev);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            return TRUE;
        }
    }

    public function stavOckovani() {
        if (isset($_POST["stavOckovani"])) {
            echo "<meta http-equiv='refresh' content='0'>";
            $ID = $_POST["ID"];
            $navstiveno = $_POST["stavOckovani"];
            if ($navstiveno == "ANO")
                $navstiveno = "0";
            else
                $navstiveno = "1";
            try {
                $stmt = $this->conn->prepare("UPDATE `ockovani` SET `navstiveno`=:navstiveno WHERE `ID` = :id;");
                $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
                $stmt->bindParam(':navstiveno', $navstiveno);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Chyba čtení tabulky: ';
                echo $e->getMessage();
            }
        }
    }

    public function vlozOckovani() {
        if (isset($_POST["vlozOckovani"]) && $_POST["nazev"] != "" && is_numeric($_POST["pes"]) && $_POST["datum"] != "") {
            $IDpsa = $_POST["pes"];
            $datum = $_POST["datum"];
            $nazev = $_POST["nazev"];
            try {
                $stmt = $this->conn->prepare("INSERT INTO `ockovani` (`ID`, `nazev`, `datum`, `IDpsa`, `navstiveno`) VALUES (NULL, :nazev, :datum, :IDpsa, 0);");
                $stmt->bindParam(':IDpsa', $IDpsa);
                $stmt->bindParam(':datum', $datum);
                $stmt->bindParam(':nazev', $nazev);
                $stmt->execute();
                echo "<div class='alert alert-success w-100 position-absolute admin-alert' role='alert'>Očkování úspěšně vloženo.</div>";
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    public function nahratObrazek($miniatura, $frontend) {
        $nazevObrazku = explode('.', $miniatura);
        $cislo = date("dmYHis");
        $novyNazev = $cislo . '.' . $nazevObrazku[1];
        if (is_null($frontend))
        $cesta = "../uploads/" . $novyNazev;
        else
        $cesta = "uploads/" . $novyNazev;
        $povoleneFormaty = array('png', 'jpeg', 'gif', 'jpg');
        if(in_array($nazevObrazku[1],$povoleneFormaty)) {
            var_dump($cesta);
            var_dump($novyNazev);
            move_uploaded_file($this->kompreseObrazku($_FILES["miniatura"]["tmp_name"], $cesta, 70), $cesta);
            echo "<div class='alert alert-success w-100 position-absolute admin-alert' role='alert'>Miniatura úspěšně nahrána.</div>";
            return $novyNazev;
        }
        else {
            echo "<div class='alert alert-danger w-100 position-absolute admin-alert' role='alert'>Špatný formát obrázku. Povolené formáty: .JPEG, .JPG, .GIF, .PNG</div>";
            return "logo.jpg";
        }
    }

    public function kompreseObrazku($zdroj, $cil, $kvalita) {
        $podrobnosti = getimagesize($zdroj);
        if ($podrobnosti['mime'] == 'image/jpeg' || $podrobnosti['mime'] == 'image/jpg') {
            $obrazek = imagecreatefromjpeg($zdroj);
            imagejpeg($obrazek, $cil, $kvalita);
        }

        else if ($podrobnosti['mime'] == 'image/gif') {
            $obrazek = imagecreatefromgif($zdroj);
            imagejpeg($obrazek, $cil, $kvalita);
        }

        else if ($podrobnosti['mime'] == 'image/png') {
            $obrazek = imagecreatefrompng($zdroj);
            imagealphablending($obrazek, false);
            imagesavealpha($obrazek, true);
            // imagepng přijímá kvalitu od 0 (bez komprese) do 9
            imagepng($obrazek, $cil, 5);
            imagedestroy($obrazek);
        }

        else {
            return false;
        }
    }

    function vypisPrvniOdstavec($string){
        // uloží do proměnné první odstavec textu
        $string = substr($string, strpos($string, "<p"), strpos($string, "</p>")+4);
        return $string;
    }

    public function vypisSvatek() {
        $jmena = [
            '01-01' => 'Agga',
            '02-01' => 'Joe',
            '03-01' => 'Jack',
            '04-01' => 'Ťapka',
            '05-01' => 'Gaston',
            '06-01' => 'Bred',
            '07-01' => 'Sam',
            '08-01' => 'Elvis',
            '09-01' => 'Rex',
            '10-01' => 'En',
            '11-01' => 'Ryn',
            '12-01' => 'Fred',
            '13-01' => 'Tramp',
            '14-01' => 'Brita',
            '15-01' => 'Brok',
            '16-01' => 'Ikar',
            '17-01' => 'Bert',
            '18-01' => 'Dag',
            '19-01' => 'Ajax',
            '20-01' => 'Chris',
            '21-01' => 'Brian',
            '22-01' => 'Bojar',
            '23-01' => 'Agar',
            '24-01' => 'Brix',
            '25-01' => 'Max',
            '26-01' => 'Amor',
            '27-01' => 'Žolík',
            '28-01' => 'Kid',
            '29-01' => 'Hektor',
            '30-01' => 'Jenny',
            '31-01' => 'Marika',
            '01-02' => 'Car',
            '02-02' => 'César',
            '03-02' => 'Black',
            '04-02' => 'Gina',
            '05-02' => 'Žeryk',
            '06-02' => 'Peggy',
            '07-02' => 'Lord',
            '08-02' => 'Nora',
            '09-02' => 'Brona',
            '10-02' => 'Betoven',
            '11-02' => 'Nero',
            '12-02' => 'Bond',
            '13-02' => 'Kazan',
            '14-02' => 'Dan',
            '15-02' => 'Dona',
            '16-02' => 'Lilly',
            '17-02' => 'Azor',
            '18-02' => 'Argo',
            '19-02' => 'Dasty',
            '20-02' => 'Fin',
            '21-02' => 'Dita',
            '22-02' => 'Elsa',
            '23-02' => 'Kikina',
            '24-02' => 'Pajda',
            '25-02' => 'Dášenka',
            '26-02' => 'Líza',
            '27-02' => 'Flek',
            '28-02' => 'Bobina',
            '29-02' => 'Polly',
            '01-03' => 'Perry',
            '02-03' => 'Missi',
            '03-03' => 'Punťa',
            '04-03' => 'Akim',
            '05-03' => 'Sally',
            '06-03' => 'Bea',
            '07-03' => 'Tedy',
            '08-03' => 'Sára',
            '09-03' => 'Aida',
            '10-03' => 'Alík',
            '11-03' => 'Sisi',
            '12-03' => 'Babeta',
            '13-03' => 'Roxy',
            '14-03' => 'Bona',
            '15-03' => 'Rol',
            '16-03' => 'Besi',
            '17-03' => 'Raf',
            '18-03' => 'Dixi',
            '19-03' => 'Ben',
            '20-03' => 'Oskar',
            '21-03' => 'Nelly',
            '22-03' => 'Abík',
            '23-03' => 'Filip',
            '24-03' => 'Falco',
            '25-03' => 'Baryk',
            '26-03' => 'Cid',
            '27-03' => 'Dino',
            '28-03' => 'Asman',
            '29-03' => 'Dina',
            '30-03' => 'Bob',
            '31-03' => 'Kvido',
            '01-04' => 'Brut',
            '02-04' => 'Máša',
            '03-04' => 'Harry',
            '04-04' => 'Baron',
            '05-04' => 'Ellis',
            '06-04' => 'Lady',
            '07-04' => 'Denny',
            '08-04' => 'Ron',
            '09-04' => 'Jonatán',
            '10-04' => 'Asta',
            '11-04' => 'Luisa',
            '12-04' => 'Debbie',
            '13-04' => 'Astor',
            '14-04' => 'Deril',
            '15-04' => 'Fík',
            '16-04' => 'Betina',
            '17-04' => 'Amos',
            '18-04' => 'Alma',
            '19-04' => 'Daisy',
            '20-04' => 'Berta',
            '21-04' => 'Gary',
            '22-04' => 'Tereza',
            '23-04' => 'Arsa',
            '24-04' => 'Mates',
            '25-04' => 'Borina',
            '26-04' => 'Hasan',
            '27-04' => 'Amigo',
            '28-04' => 'Sandy',
            '29-04' => 'Jim',
            '30-04' => 'Briana',
            '01-05' => 'Jonáš',
            '02-05' => 'Scotty',
            '03-05' => 'Šarik',
            '04-05' => 'Penny',
            '05-05' => 'Cindy',
            '06-05' => 'Agila',
            '07-05' => 'Bendži',
            '08-05' => 'Fatima',
            '09-05' => 'Jasper',
            '10-05' => 'Zak',
            '11-05' => 'Arthur',
            '12-05' => 'Bady',
            '13-05' => 'Atos',
            '14-05' => 'Atyr',
            '15-05' => 'Ebony',
            '16-05' => 'Riky',
            '17-05' => 'Karina',
            '18-05' => 'Tara',
            '19-05' => 'Meggie',
            '20-05' => 'Cite',
            '21-05' => 'Bára',
            '22-05' => 'Arina',
            '23-05' => 'Benita',
            '24-05' => 'Bonny',
            '25-05' => 'Arif',
            '26-05' => 'Bastien',
            '27-05' => 'Alf',
            '28-05' => 'Daxi',
            '29-05' => 'Rasty',
            '30-05' => 'Pongo',
            '31-05' => 'Denis',
            '01-06' => 'Deli',
            '02-06' => 'Tesák',
            '03-06' => 'Ar',
            '04-06' => 'Tin',
            '05-06' => 'Billy',
            '06-6' => 'Anita',
            '07-06' => 'Albi',
            '08-06' => 'Lex',
            '09-06' => 'Cigy',
            '10-06' => 'Dyk',
            '11-06' => 'Sad',
            '12-06' => 'Gero',
            '13-06' => 'Rintintin',
            '14-06' => 'Buš',
            '15-06' => 'Huč',
            '16-06' => 'Iris',
            '17-06' => 'Perdita',
            '18-06' => 'Ara',
            '19-06' => 'Míša',
            '20-06' => 'Lyr',
            '21-06' => 'Aton',
            '22-06' => 'Bron',
            '23-06' => 'Laura',
            '24-06' => 'Lassie',
            '25-06' => 'Ferda',
            '26-06' => 'Felix',
            '27-06' => 'Akita',
            '28-06' => 'Arny',
            '29-06' => 'Lima',
            '30-06' => 'Apollo',
            '01-07' => 'Beli',
            '02-07' => 'Sany',
            '03-07' => 'Sultán',
            '04-07' => 'Rommy',
            '05-07' => 'Art',
            '06-07' => 'Alan',
            '07-07' => 'Fogy',
            '08-07' => 'Barbie',
            '09-07' => 'Sax',
            '10-07' => 'Aranka',
            '11-07' => 'Rek',
            '12-07' => 'Boy',
            '13-07' => 'Paddy',
            '14-07' => 'Bon',
            '15-07' => 'Philippo',
            '16-07' => 'Zora',
            '17-07' => 'Ťulda',
            '18-07' => 'Johny',
            '19-07' => 'Jessie',
            '20-07' => 'Carmen',
            '21-07' => 'Lajka',
            '22-07' => 'Adar',
            '23-07' => 'Pad',
            '24-07' => 'Britt',
            '25-07' => 'Bad',
            '26-07' => 'Čiko',
            '27-07' => 'Dora',
            '28-07' => 'Dina',
            '29-07' => 'Elza',
            '30-07' => 'Bodie',
            '31-07' => 'Miky',
            '01-08' => 'Endy',
            '02-08' => 'Tony',
            '03-08' => 'Lesan',
            '04-08' => 'Sir',
            '05-08' => 'Alex',
            '06-08' => 'Čikina',
            '07-08' => 'King',
            '08-08' => 'Bobina',
            '09-08' => 'Akar',
            '10-08' => 'Damián',
            '11-08' => 'Angela',
            '12-08' => 'Sheila',
            '13-08' => 'Bena',
            '14-08' => 'Enny',
            '15-08' => 'Gerry',
            '16-08' => 'Faraon',
            '17-08' => 'Aron',
            '18-08' => 'Lucky',
            '19-08' => 'Lisy',
            '20-08' => 'Aran',
            '21-08' => 'Mik',
            '22-08' => 'Azar',
            '23-08' => 'Bruno',
            '24-08' => 'Eila',
            '25-08' => 'Fifi',
            '26-08' => 'Dafné',
            '27-08' => 'Egar',
            '28-08' => 'Mona',
            '29-08' => 'Betty',
            '30-08' => 'Bary',
            '31-08' => 'Bax',
            '01-09' => 'Blesk',
            '02-09' => 'Pluto',
            '03-09' => 'Bandy',
            '04-09' => 'Ruby',
            '05-09' => 'Ted',
            '06-09' => 'Brek',
            '07-09' => 'Aston',
            '08-09' => 'Loran',
            '09-09' => 'Diky',
            '10-09' => 'Rolf',
            '11-09' => 'Wendy',
            '12-09' => 'Bella',
            '13-09' => 'Alisa',
            '14-09' => 'Lasky',
            '15-09' => 'Ella',
            '16-09' => 'Brixa',
            '17-09' => 'Štaflík',
            '18-09' => 'Špagetka',
            '19-09' => 'Aura',
            '20-09' => 'Thami',
            '21-09' => 'Leo',
            '22-09' => 'Filla',
            '23-09' => 'Elka',
            '24-09' => 'Arči',
            '25-09' => 'Daryk',
            '26-09' => 'Bazir',
            '27-09' => 'Dar',
            '28-09' => 'Dafy',
            '29-09' => 'Dena',
            '30-09' => 'Doris',
            '01-10' => 'Ali',
            '02-10' => 'Kiki',
            '03-10' => 'Morgan',
            '04-10' => 'Rina',
            '05-10' => 'Kojak',
            '06-10' => 'Tina',
            '07-10' => 'Hero',
            '08-10' => 'Sabar',
            '09-10' => 'Adam',
            '10-10' => 'Luna',
            '11-10' => 'Viki',
            '12-10' => 'Fox',
            '13-10' => 'Vigo',
            '14-10' => 'Axa',
            '15-10' => 'Isar',
            '16-10' => 'Lojza',
            '17-10' => 'Monty',
            '18-10' => 'Dingo',
            '19-10' => 'Eros',
            '20-10' => 'Čibi',
            '21-10' => 'Džina',
            '22-10' => 'Badys',
            '23-10' => 'Bina',
            '24-10' => 'Pussy',
            '25-10' => 'Hex',
            '26-10' => 'Čiči',
            '27-10' => 'Agila',
            '28-10' => 'Bart',
            '29-10' => 'Askot',
            '30-10' => 'Hrom',
            '31-10' => 'Amanda',
            '01-11' => 'Dolly',
            '02-11' => 'Niki',
            '03-11' => 'Bern',
            '04-11' => 'Chasan',
            '05-11' => 'Sigi',
            '06-11' => 'Brest',
            '07-11' => 'Fido',
            '08-11' => 'Omar',
            '09-11' => 'Dant',
            '10-11' => 'Fix',
            '11-11' => 'York',
            '12-11' => 'Clea',
            '13-11' => 'Hera',
            '14-11' => 'Muf',
            '15-11' => 'Armína',
            '16-11' => 'Brixie',
            '17-11' => 'Tobi',
            '18-11' => 'Asan',
            '19-11' => 'Goro',
            '20-11' => 'Tim',
            '21-11' => 'Cherry',
            '22-11' => 'Nessie',
            '23-11' => 'Bugsy',
            '24-11' => 'Jimmy',
            '25-11' => 'Keks',
            '26-11' => 'Sorbone',
            '27-11' => 'Jolla',
            '28-11' => 'Tracy',
            '29-11' => 'Mína',
            '30-11' => 'Ray',
            '01-12' => 'Žaky',
            '02-12' => 'Norik',
            '03-12' => 'Corado',
            '04-12' => 'Lola',
            '05-12' => 'Elba',
            '06-12' => 'Charley',
            '07-12' => 'Greg',
            '08-12' => 'Olsan',
            '09-12' => 'Clif',
            '10-12' => 'Civil',
            '11-12' => 'Aret',
            '12-12' => 'Grand',
            '13-12' => 'Kelly',
            '14-12' => 'Molly',
            '15-12' => 'Enzo',
            '16-12' => 'Jerry',
            '17-12' => 'Kenny',
            '18-12' => 'Arna',
            '19-12' => 'Orfeus',
            '20-12' => 'Blank',
            '21-12' => 'Hardy',
            '22-12' => 'Goffy',
            '23-12' => 'Moris',
            '24-12' => 'Sonny',
            '25-12' => 'Fera',
            '26-12' => 'Connie',
            '27-12' => 'Karo',
            '28-12' => 'Sian',
            '29-12' => 'Ašar',
            '30-12' => 'Čaky',
            '31-12' => 'Briny'
        ];
        $datum = date("d-m");
        return $jmena[$datum];
    }
}