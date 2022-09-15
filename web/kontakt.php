<section class="row header-breadcrumb" style="background: url('images/kontakt/header.jpg');">
    <div class="container">
        <div class="row m0 page-cover">
            <h2 class="page-cover-tittle">KONTAKT</h2>
        </div>
    </div>
</section>

<section class="row touch">
    <div class="sectpad touch_bg">
        <div class="container">
            <div class="row m0 section_header color">
                <?php echo "<h2>".$kontakt->nazov_spolocnosti."</h2>";?>
            </div>

            <div class="row touch_middle">
                <div class="col-md-4 contact-info">
                    <div class="row m0 touch_top">
                        <ul class="nav">
                            <li class="item">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#">
                                            <i class="fa fa-map-marker"></i>
                                        </a>
                                    </div>
                                    <div class="media-body address">
                                        <?php echo $kontakt->adresa;?>
                                    </div>
                                </div>
                            </li>
                            <li class="item">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#">
                                            <i class="fa fa-envelope-o"></i>
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <?php echo "<a href='mailto:".$kontakt->email."'>".$kontakt->email."</a>";?>
                                    </div>
                                </div>
                            </li>
                            <li class="item">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#">
                                            <i class="fa fa-phone"></i>
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <?php 
                                        foreach ($kontakt->kontaktna_osoba as $kontaktna_osoba) {
                                            $telephone = "+421 ".chunk_split($kontaktna_osoba->telefon, 3, ' ');
                                            echo "<b>".$kontaktna_osoba->meno."</b><br />";
                                            echo "<a href='tel:".$telephone."'>".$telephone."</a><br />";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </li>
                            <li class="item">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <a href="https://www.facebook.com/Drevo-Interiersk-100733312068669" target="_blank">Drevo-Interier.sk</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8 input_form">
                    <form action="contact_process.php" method="post" id="contactForm">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Meno">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                        <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Telefón">
                        <textarea class="form-control" rows="6" id="message" name="message" placeholder="Správa"></textarea>
                        <div class="row m0">
                            <button type="submit" class="btn btn-default submit">Odoslať</button>
                        </div>
                    </form>
                    <div id="success">
                        <p>Vaša správa bola odoslaná. Budeme vás kontaktovať hneď ako to bude v našich silách.</p>
                    </div>
                    <div id="error">
                        <p>Niečo sa pokazilo! Kontaktujte nás prosím telefonicky alebo e-mailom.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="emergency-contact">
    <div class="text-center">
        <div class="content">
            <?php echo "<a href='http://maps.apple.com/?sll=".$kontakt->mapa_latitude.",".$kontakt->mapa_longitude."'>";?>
                <div id="map-button">
                    <span>SPUSTIŤ NAVIGÁCIU</span>
                    <i class="fa fa-location-arrow"></i>
                </div>
            </a>
        </div>
    </div>
</section>
<!--MapBox-->
<section class="map">
    <div id="mapBox" class="row m0" data-lat="48.3417917" data-lon="17.0344431" data-zoom="15"></div>
</section>