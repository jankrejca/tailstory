<?php
include_once 'tailstory.class.php';
$obsah = new tailstory();
$otazkyOdpovedi = $obsah->vratOtazky();

                  if (isset($_GET["page"]) && $_GET["page"] > 0) {
                      $start = $_GET["page"] * 4;
                      $cil = $start + 4;
                  }
                  else {
                      $start= 0;
                      $cil = 4;
                  }
                  $vypisOdpovedi = $obsah->vratOdpovedi($start, $cil);
                  foreach($vypisOdpovedi as $odpoved) {
                      $datum = $odpoved->datum;
                      $datum = date("d. m. Y", strtotime($datum));
                      $autor = $odpoved->autor;
                      $otazka = $odpoved->otazka;
                      $odpoved = $odpoved->odpoved;
                      ?>
                      <div class="row otazkaodpoved">
                          <div class="col-lg-12 col-sm-12 text-center">
                                <p class="text-left"><?php echo $datum." se ptá ".$autor.":"; ?></p>
                                <p class="text-left lead font-weight-bold"><?php echo $otazka; ?></p>
                                <p class="text-left lead">- <?php echo $odpoved; ?></p>
                          </div>
                      </div>
                      <?php
                  }
?>
