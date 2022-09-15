<?php
    $json = file_get_contents($API_HOST.'/o-nas', false, stream_context_create($arrContextOptions));
    $content = json_decode($json);
?>

<section class="bannercontainer row">
    <div class="rev_slider banner row m0" id="rev_slider" data-version="5.0">
        <ul>
            <?php
                foreach ($content->slider as $slide) {
                    if($slide->zobrazenie){
                        echo "<li data-transition='parallaxvertical'>";
                            echo "<img src='".$API_HOST.$slide->obrazok->url."' alt='' data-bgposition='center top' data-bgfit='cover' data-bgrepeat='no-repeat' data-bgparallax='1'>";
                        echo "</li>";
                    }
                }
            ?>
        </ul>
    </div>
</section>

<!--experiance-area-->
<section class="row experience-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-5 worker-image">
                <img src="/images/onas/firma.png" alt="">
            </div>
            <div class="col-sm-7 experience-info">
                <div class="content">
                    <?php
                    echo "<h2>".$content->titulok."</h2>";
                    echo "<p>".$Parsedown->text($content->ofirme)."</p>";

                    ?>
                </div>
            </div>
        </div>
    </div>
</section>


<!--we-do-->
<section class="row sectpad we-do-section">
    <div class="container">
        <div class="row m0 section_header color">
            <h2>PRODUKTY</h2>
        </div>
        <div class="we-do-slider">
            <div class="we-sliders">
                <?php
                    foreach ($content->produkty as $product) {
                        echo "<div class='item'>";
                            echo "<div class='post-image'>";
                                echo "<img src='".$API_HOST.$product->obrazok->url."' alt='".$product->nazov."'>";
                            echo "</div>";
                            echo "<a href='".$product->url."'>";
                                echo "<h4>".$product->nazov."</h4>";
                            echo "</a>";
                            echo "<p>".$Parsedown->text($product->popis)."</p>";
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
    </div>
</section>


<!-- clients -->
<section class="row clients">
    <div class="container">
        <div class="row m0 section_header">
            <h2>Partneri</h2>
        </div>
        <div class="clients-logos owl-carousel">
            <?php
                foreach ($content->partneri as $partner) {
                    echo "<div class='col-md-2 col-sm-3 col-xs-6 client'>";
                        echo "<div class='row m0 inner-logo'>";
                            echo "<a href='".$partner->link."' target='_blank'><img src='".$API_HOST.$partner->logo->url."' alt='".$partner->partner."'></a>";
                        echo "</div>";
                    echo "</div>";
                }
            ?>
        </div>
</section>