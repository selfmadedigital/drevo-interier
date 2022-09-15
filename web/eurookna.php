<?php
    $json = file_get_contents($API_HOST.'/eurookna', false, stream_context_create($arrContextOptions));
    $content = json_decode($json);
?>

<section class="row header-breadcrumb" style="background: url('images/eurookna/header.jpg');">
    <div class="container">
        <div class="row m0 page-cover">
            <h2 class="page-cover-tittle">EUROOKNÁ</h2>
        </div>
    </div>
</section>

<section class="row eurookna sectpad">
    <div class="container">
        <div class="row m0 section_header color">
            <?php echo "<h2>".$content->uvod_nadpis."</h2>";?>
        </div>
        <?php echo "<p>".$Parsedown->text($content->uvod_text)."</p>";?>
        <div class="row">
        	<?php
                foreach ($content->sluzby as $sluzba) {
                	echo "<div class='eurookna-box col-sm-6 col-lg-4'>";
		                echo "<div class='eurookna-icon'>";
		                    echo "<i class='fas fa-".$sluzba->ikona."'></i>";
		                echo "</div>";
		                echo "<div class='eurookna-description'>";
		                    echo "<h4>".$sluzba->nadpis."</h4>";
		                    echo "<p>".$sluzba->obsah."</p>";
		                echo "</div>";
		            echo "</div>";
                }
            ?>
        </div>
    </div>
</section>

<section class="row service-certified sectpad">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 service-image">
                <img src="/images/eurookna/okno.png" alt="">
            </div>
            <div class=" row col-sm-8 service-content">
                <?php echo "<h2>".$content->blok_nadpis."</h2>";?>
                <?php echo "<p>".$Parsedown->text($content->blok_text)."</p>";?>
            </div>
        </div>
    </div>
</section>

<section class="row featured-service-area">
    <div class="sectpad">
        <div class="container">
            <div class="row m0 section_header common">
                <h2>VÝROBA</h2>
            </div>
            <div class="row service-featured">
            	<?php
                foreach ($content->Vyroba as $vyroba) {
	                echo "<div class='col-sm-3 featured-service'>";
	                    echo "<img src='".$API_HOST.$vyroba->obrazok->url."' alt='".$vyroba->popis."'>";
	                    echo "<h4>".$vyroba->popis."</h4>";
	                echo "</div>";
	            }
	            ?>
            </div>
        </div>
    </div>
</section>