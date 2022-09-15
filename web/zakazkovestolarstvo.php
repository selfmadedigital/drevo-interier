<?php
    $json = file_get_contents($API_HOST.'/zakazkove-stolarstvo', false, stream_context_create($arrContextOptions));
    $content = json_decode($json);
?>

<section class="row header-breadcrumb" style="background: url('images/zakazkovestolarstvo/header.jpg');">
    <div class="container">
        <div class="row m0 page-cover">
            <h2 class="page-cover-tittle">ZÁKAZKOVÉ STOLÁRSTVO</h2>
        </div>
    </div>
</section>

<section class="row sectpad services">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 sidebar">
                <ul class="nav nav-tabs" role="tablist">
                    <?php
                        $first = true;
                        foreach ($content->produkty as $produkt) {
                            $id_name = strtolower(stripAccents(str_replace(' ', '', $produkt->nazov)));

                            echo "<li role='presentation' id='sidebar-".$id_name."'>";
                                echo "<a href='#".$id_name."' aria-controls='content-1' role='tab' data-toggle='tab'>";
                                    echo $produkt->nazov;
                                echo "</a>";
                            echo "</li>";

                            $first = false;
                        }
                    ?>
                </ul>
                <div class="row m0 downloads">
                    <h4>CERTIFIKÁTY</h4>
                    <div class="dload">
                        <div class="dlbg">
                            <a href="<?php echo $API_HOST.$content->certifikaty->url;?>">CERTIFIKÁTY PDF</a>
                            <a href="<?php echo $API_HOST.$content->certifikaty->url;?>"><i class="fa fa-file-pdf-o"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9 tab_pages">
                <div class="tab-content">
                    <?php
                    foreach ($content->produkty as $produkt) {
                        $id_name = strtolower(stripAccents(str_replace(' ', '', $produkt->nazov)));
                        echo "<div role='tabpanel' class='tab-pane' id='".$id_name."'>";
                            echo "<div class='row m0 tab_inn_cont_1 '>";
                                echo "<div class='tab_inn_cont_2 row'>";
                                    echo "<div class='cont_left col-sm-8'>";
                                        echo "<div class='row m0 section_header color'>";
                                            echo "<h2>".$produkt->nazov."</h2>";
                                        echo "</div>";
                                        echo "<h3>".$produkt->nadpis_1."</h3>";
                                        echo "<p>".$produkt->text_1."</p><br>";
                                    echo "</div>";
                                    echo "<div class='cont_right col-sm-4'>";
                                        echo "<img src='".$API_HOST.$produkt->obrazok_1->url."' alt=''>";
                                    echo "</div>";
                                echo "</div>";
                                echo "<img src='".$API_HOST.$produkt->obrazok_2->url."' alt=''>";
                                echo "<h3>".$produkt->nadpis_2."</h3>";
                                echo "<p>".$produkt->text_2."</p>";
                            echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>