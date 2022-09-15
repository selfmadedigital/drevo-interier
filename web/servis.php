<?php
    $json = file_get_contents($API_HOST.'/servis', false, stream_context_create($arrContextOptions));
    $content = json_decode($json);
?>


<section class="row header-breadcrumb" style="background: url('images/servis/header.jpg');">
   <div class="container">
      <div class="row m0 page-cover">
         <h2 class="page-cover-tittle">SERVIS</h2>
      </div>
   </div>
</section>

<section class="row projects-description-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 projects-description">
                <div class="row m0 section_header project-top">
                   <?php 
                      echo "<h2>".$content->nadpis_1."</h2>";
                      echo $content->text_1;
                   ?>
                </div>

               <div class="projects-description-text">
                    <?php 
                      echo "<h3>".$content->nadpis_2."</h3>";
                      echo $content->text_2;
                   ?>
               </div>

               <section class="fluid-work-area">
              <div class="work-image">
                  <img src="/images/servis/remmers.jpg" alt="Remmers Pflege Set">
              </div>
              <div class="work-promo">
                  <div class="promo-content">
                      <?php echo $content->blok;?>
                  </div>
              </div>
          </section>
            </div>

            <div class="sidebar_section col-lg-4">
                <div class="sidebar row m0">
                    <div class="row widget widget-categories">
                        <h4 class="widget-title inner">Služby</h4>
                        <div class="row widget-inner">
                            <ul class="nav categories">
                                <?php
                                foreach ($content->sluzby as $sluzba) {
                                  echo "<li><i class='fa fa-angle-right'></i>".$sluzba->sluzba."</li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="row widget widget-popular-posts">
                        <h4 class="widget-title">Renovácia</h4>
                        <div class="row widget-inner">
                            <?php
                                foreach ($content->renovacia as $renovacia) {
                                  echo "<div class='media popular-post'>";
                                      echo "<div class='media-left'><img src='".$API_HOST.$renovacia->formats->small->url."' alt=''></div>";
                                  echo "</div>";
                                }
                            ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>

