<?php
    $json = file_get_contents($API_HOST.'/galeria', false, stream_context_create($arrContextOptions));
    $content = json_decode($json);
?>

<section class="row header-breadcrumb" style="background: url('images/galeria/header.jpg');">
    <div class="container">
        <div class="row m0 page-cover">
            <h2 class="page-cover-tittle">GALÉRIA</h2>
        </div>
    </div>
</section>

<section class="row latest_projects sectpad projects-1">
    <div class="container">
        <div class="row m0 filter_row projects-menu">
            <ul class="nav project_filter" id="project_filter2">
                <li class="active" data-filter="*">Všetko</li>
                <li data-filter=".eurookna">eurookná</li>
                <li data-filter=".nabytok">nábytok</li>
                <li data-filter=".montaz">montáž</li>
                <li data-filter=".vyroba">výroba</li>
            </ul>
        </div>
        <div class="projects2 popup-gallery" id="projects">
            <div class="grid-sizer"></div>
            <?php
            $counter = 0;
            foreach ($content->fotky as $image) {
                    if ($counter == 12) {
                        $counter = 0;
                    }

                    if ($counter == 9) {
                        $column = 3;
                    } else {
                        $column = rand(1, 2) * 3;
                    }

                    $counter += $column;

                    echo '<div class="col-sm-' . $column . ' col-xs-' . ($column * 2) . ' project eurookna renovation">';
                    echo '<div class="project-img">';
                    echo '<img src="'.$API_HOST.$image->formats->small->url . '" alt="">';
                    echo '</div>';
                    echo '</div>';
            }
            ?>
        </div>
    </div>
</section>