<?php
    $json = file_get_contents($API_HOST.'/plastove-okna', false, stream_context_create($arrContextOptions));
    $content = json_decode($json);
?>

<section class="row header-breadcrumb" style="background: url('images/plastoveokna/header.jpg');">
  <div class="container">
    <div class="row m0 page-cover">
      <h2 class="page-cover-tittle">PLASTOVÉ OKNÁ</h2>
    </div>
  </div>
</section>

<section class=" row who-area sectpad">
  <div class="container">
    <div class="row m0 section_header color">
      <?php echo "<h2>".$content->Nadpis."</h2>";?>
    </div>
    <div class="row">
      <div class="col-sm-4 col-lg-3 who-are">
        <div class="who-are-image row m0">
          <img src="/images/plastoveokna/profil.png" alt="">
        </div>
      </div>
      <div class="col-sm-8 col-lg-9 who-are-texts">
        <div class="who-text">
          <?php echo $Parsedown->text($content->obsah);?>
        <div class="who-text-box row m0 hidden-xs hidden-sm">
          <div class="media">
            <div class="media-left">
              <a href="#">
                <?php echo "<img src='".$API_HOST.$content->hesta_obrazok->url."' alt='Hesta'>";?>
              </a>
            </div>
            <div class="media-body">
              <?php echo "<p>".$Parsedown->text($content->hesta_text)."</p>";?>
              <!-- <p>Spoločnosť <b>Hesta</b> bola založená v roku <b>1993</b> a patrí medzi najdlhšie pôsobiacich výrobcov okien a dverí na Slovensku. Výroba plastových a hliníkových okien a dverí prebieha na <b>najmodernejších strojných zariadeniach</b> od spoločností Elumatec, Stürtz a Berchtold. Je riadená najnovšou verziou online softvérového programu Klaes 7.5. Od vzniku spoločnosti je prvoradým cieľom <b>kvalita produktov</b> a <b>maximálna spokojnosť zákazníka</b> o čom svedčí aj získanie <b>certifikátu manažérstva kvality ISO 9001:2000</b>.
                Výrobky a profilové systémy sú navyše <b>testované</b> a <b>certifikované</b> v skúšobnom ústave TSÚS Bratislava a IFT Rosenheim.</p> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="row features-section">
  <div class="features-image">
    <img src="/images/plastoveokna/okno.png" alt="">
  </div>
  <div class="features-area">
    <div class="features">
      
        <?php
          $index = 1;
          foreach ($content->vyhody as $vyhoda) {
            if($index == 1 || $index == 3){
              echo "<div class='features-content'>";
            }

            echo "<div class='media'>";
              echo "<div class='media-left'>";
                echo "<a href='#'>";
                  echo "<i class='fas fa-".$vyhoda->ikona."'></i>";
                echo "</a>";
              echo "</div>";
              echo "<div class='media-body'>";
                echo "<h4 class='media-heading'>".$vyhoda->nadpis."</h4>";
                echo "<p>".$vyhoda->obsah."</p>";
              echo "</div>";
            echo "</div>";

            if($index == 2 || $index == 4){
              echo "</div>";
            }

            $index++;
          }
          ?>
      </div>
    </div>
  </div>
</section>