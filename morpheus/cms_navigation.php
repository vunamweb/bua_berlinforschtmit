<?php
error_reporting (0);
//error_reporting(E_ALL & ~E_DEPRECATED);
# # # # # # # # # # # # # # # # # # # # # # # # # # #
# www.pixel-dusche.de                               #
# bj&ouml;rn t. knetter                                  #
# start 12/2003                                     #
#                                                   #
# post@pixel-dusche.de                              #
# frankfurt am main, germany                        #
# # # # # # # # # # # # # # # # # # # # # # # # # # #
/*
$auths_arr = array(
20=>"Redaktion",
30=>"Dokumente / Uploads",
40=>"Dokumente / Uploads Gremien",
50=>"Mitglieder",
60=>"Mitarbeiter",
);
*/
# navigation
?>

<div class="row">
    <!-- uncomment code for absolute positioning tweek see top comment in css -->
    <!-- <div class="absolute-wrapper"> </div> -->
    <!-- Menu -->
    <div class="side-menu">

    <nav class="navbar navbar-default" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <div class="brand-wrapper">
            <!-- Hamburger -->
            <button type="button" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Brand -->
            <div class="brand-name-wrapper">
                <a class="navbar-brand" href="index.php">
                    <img src="images/Logo-Morpheus.svg" class="logo" alt="" />
                </a>
            </div>
        </div>
    </div>

    <!-- Main Menu -->
    <div class="side-menu-container">
        <ul class="nav navbar-nav">
				<?php
				if(in_array(10,$auths) || $admin) { ?>

					<li></li>
					<li class="panel panel-default" id="dropdown">
						<a data-toggle="collapse" href="#dropdown-lvl16">
							<i class="fa fa-microphone "></i> Stimmen <span class="caret"></span>
						</a>
						<div id="dropdown-lvl16" class="panel-collapse collapse <?php global $stimmen_in; echo $stimmen_in; ?>">
							<div class="panel-body">
								<ul class="nav navbar-nav">
									<li><a href="morp__stimmen.php" title="FAQ"><i class="fa fa-pie-chart "></i> Stimmen Chart</a>
									<li><a href="morp__stimmen_kategorie.php" title="FAQ"><i class="fa fa-comments "></i> Stimmen Kategorien Fragen</a>
									<li><a href="morp_media.php" title=""><i class="fa fa-microphone "></i> Verwaltung WAV</a>
								</ul>
							</div>
						</div>
					</li>
					
					<li>&nbsp;</li>
					
					<li class="panel panel-default <?php global $redaktion_in; echo $redaktion_in; ?>">
					    <a data-toggle="collapse" href="#dropdown-lvl1">
					        <i class="fa fa-sitemap "></i> Redaktion Text <span class="caret"></span>
					    </a>
					    <div id="dropdown-lvl1" class="panel-collapse collapse <?php global $redaktion_in; echo $redaktion_in; ?>">
					        <div class="panel-body">
					            <ul class="nav navbar-nav">
									<li<?php echo $nav_active; ?>><a href="navigation.php" title="Links verwalten und Content zuweisen"><i class="fa fa-navicon "></i> Seitenverwaltung</a></li>
									<li<?php echo $news_active; ?>><a href="news.php?formatSelect" title="news verwalten"><i class="fa fa-rss-square "></i> News</a></li>
									<!-- <li><a href="news.php?formatSelect=2,3,4" title="news verwalten"><i class="fa fa-rss-square "></i> Startseite Links</a></li> -->
 									<li<?php echo $vorl_active; ?>><a href="template.php" title="Text-Vorlagen verwalten"><i class="fa fa-puzzle-piece "></i> Text Vorlagen</a></li> 									 
<!-- 									<li><a href="_keywcreate.php" title="backup morpheus"><i class="fa fa-search "></i> Suchindex erstellen</a></li> -->
					            </ul>
					        </div>
					    </div>
					</li>

					<li class="panel panel-default <?php global $images_in; echo $images_in; ?>">
					    <a data-toggle="collapse" href="#dropdown-lvl6">
					        <i class="fa fa-camera-retro "></i> Bilder <span class="caret"></span>
					    </a>
					    <div id="dropdown-lvl6" class="panel-collapse collapse <?php global $images_in; echo $images_in; ?>">
					        <div class="panel-body">
					            <ul class="nav navbar-nav">
									<li><a href="image.php" title="Bilder / Fotos verwalten"><i class="fa fa-camera-retro "></i> Bildarchiv</a>
<!--
									<li<?php global $ms_active; echo $ms_active; ?>><a href="morp_masterslider.php" title="Master Slider verwalten"<?php global $ms_active; echo $ms_active; ?>><i class="fa fa-camera-retro "></i> Master Slider</a>
-->
									<li><a href="bild_galerie.php?ggid=1&name=<?php echo $morpheus["GaleryPath"]; ?>&db=morp_cms_galerie_name" title="Galerien verwalten"><i class="fa fa-th"></i> Bilder Galerien</a></li>
					            </ul>
					        </div>
					    </div>
					</li>



				<?php	} ?>
				<?php if(in_array(21,$auths) || $admin) { ?>

					<!-- <li class="panel panel-default <?php global $event_in; echo $event_in; ?>" id="dropdown">
						<a data-toggle="collapse" href="#dropdown-lvl16">
							<i class="fa fa-mortar-board "></i> Veranstaltungen <span class="caret"></span>
						</a>
						<div id="dropdown-lvl16" class="panel-collapse collapse <?php global $event_in; echo $event_in; ?>">
							<div class="panel-body">
								<ul class="nav navbar-nav">
									<li><a href="morp_veranstaltung.php" title=""><i class="fa fa-calendar"></i> Veranstaltungen</a></li>
									<li><a href="morp_veranstaltung_bookings.php" title=""><i class="fa fa-calendar"></i> Bookings</a></li>
									<li><a href="morp_veranstaltungs_kategorien.php" title=""><i class="fa fa-calendar"></i> Event Phasen</a></li>
								</ul>
							</div>
						</div>
					</li> -->
					
					<li class="panel panel-default <?php global $aktuere_in; echo $aktuere_in; ?>">
						<a data-toggle="collapse" href="#dropdown-lvl2a">
							<i class="fa fa-rocket "></i> Akteursdatenbank <span class="caret"></span>
						</a>
						<div id="dropdown-lvl2a" class="panel-collapse collapse <?php global $aktuere_in; echo $aktuere_in; ?>">
							<div class="panel-body">
								<ul class="nav navbar-nav">
									<li<?php echo $akt1_active; ?>><a href="user_intranet.php"><i class="fa fa-users "></i> Teilnehmer</a></li>
									<li<?php echo $akt5_active; ?>><a href="user_intranet_interests.php"><i class="fa fa-users "></i> Interests</a></li>
									<li<?php echo $akt2_active; ?>><a href="user_intranet_properties.php"><i class="fa fa-users "></i> Eigenschaften / Properties</a></li>
									<li<?php echo $akt3_active; ?>><a href="user_intranet_status.php"><i class="fa fa-users "></i> Status</a></li>
									<li<?php echo $akt4_active; ?>><a href="user_intranet_event.php"><i class="fa fa-users "></i> Eigenschaften / Events</a></li>
								</ul>
							</div>
						</div>
					</li>
					
					<li class="panel panel-default" id="dropdown">
						<a data-toggle="collapse" href="#dropdown-lvl40">
							<i class="fa fa-paper-plane"></i> Mailing <span class="caret"></span>
						</a>
						<div id="dropdown-lvl40" class="panel-collapse collapse<?php global $newsletter_in; echo $newsletter_in; ?>">
							<div class="panel-body">
								<ul class="nav navbar-nav">
								    <li><a href="newsletter.php" class="nav" title="newsletter"><i class="fa fa-paper-plane"></i>  Newsletter Verwaltung</a><li>
									<li><a href="newsletter_track.php" class="nav" title="newsletter"><i class="fa fa-tasks"></i>  Newsletter Tracking</a><li>
									<li><a href="newsletter_image.php" class="nav" title="PDF, Bilder und Fotos verwalten"><i class="fa fa-camera-retro"></i>  Bildarchiv</a></li>
									<li><a href="newsletter_template_preview.php" class="nav" title="Templates preview"><i class="fa fa-database"></i>  Templates Vorschau</a></li>
									<li><a href="newsletter_vt.php" class="nav"><i class="fa fa-globe"></i> Verteiler</a></li>
									<li><a href="newsletter_vt_test.php" class="nav"><i class="fa fa-globe"></i> Test Adressen</a></li>
								</ul>
							</div>
						</div>
					</li>
					

					<!--	<li><a href="morp_team.php" title="PDF\'s verwalten"><i class="fa fa-th"></i> Team</a></li>-->
					 <li><a href="formular.php" title="Formulare verwalten"><i class="fa fa-tasks "></i> Formulare</a></li>
					 <li><a href="morp_media.php" title="media"><i class="fa fa-tasks "></i> Media</a></li>
				<?php	} ?>


				<?php if(in_array(30,$auths) || $admin) { ?>
					<li><a href="pdf_group.php?sec=off" title="PDF\'s verwalten"><i class="fa fa-file-pdf-o "></i> Downloads</a></li>

					<li class="panel panel-default">
					    <a data-toggle="collapse" href="#dropdown-lvl4">
					        <i class="fa fa-cog "></i> Config <span class="caret"></span>
					    </a>
					    <div id="dropdown-lvl4" class="panel-collapse collapse">
					        <div class="panel-body">
					            <ul class="nav navbar-nav">
									<li><a href="sprachdatei.php"><i class="fa fa-bullhorn"></i> Text Templates</a></li>
									<li><a href="morp_settings.php" title="settings kunden"><i class="fa fa-users "></i> Einstellungen Kunde</a></li>
									<li><a href="morp_settings_css.php" title="settings css"><i class="fa fa-paint-brush "></i> Einstellungen CSS</a></li>
									<li><a href="config_css.php?datei=../css/css.css" title="config morpheus"><i class="fa fa-users "></i> CSS stylesheet </a></li>
									<li><a href="morp_settings_fonts.php" title="settings fonts"><i class="fa fa-tags "></i> Einstellungen Fonts</a></li>
									<li><a href="morp_icons.php" class="nav" title="Icons konfigurieren"><i class="fa fa-star-half-o"></i> Icons konfigurieren</a></li>
									<li><a href="morp_colors.php" class="nav" title="Icons konfigurieren"><i class="fa fa-eyedropper"></i> Farben konfigurieren</a></li>
					            </ul>
					        </div>
					    </div>
					</li>

				<?php	} ?>

				<?php if($admin) { ?>
				<!-- 	<li><a href="user.php" title="Assets" style=""><i class="fa fa-lock"></i> Zugänge</a></li>-->
				<!--	<li><a href="sitemap_erstelle.php" title="index erstellen"><i class="fa fa-sort-alpha-asc"></i> Sitemap/Index erstellen</a></li>-->

					
										
					<li class="panel panel-default">
						<a data-toggle="collapse" href="#dropdown-lvl2">
							<i class="fa fa-rocket "></i> Admin <span class="caret"></span>
						</a>
						<div id="dropdown-lvl2" class="panel-collapse collapse">
							<div class="panel-body">
								<ul class="nav navbar-nav">
									<li><a href="user.php" title="backup morpheus"><i class="fa fa-users "></i> Userverwaltung</a></li>
									<!-- <li><a href="user_intranet.php" title="backup morpheus"><i class="fa fa-users "></i> User Register</a></li> -->
									<li><a href="config.php?datei=../nogo/config.php" title="config morpheus"><i class="fa fa-users "></i> Config Editor</a></li>
								</ul>
							</div>
						</div>
					</li>

				<?php	} ?>

				<li><a href="backup_morpheus.php" title="backup morpheus"><i class="fa fa-cloud-download "></i> Backup Daten</a></li>
				<li><a href="logout.php" title="logout morpheus"> Logout</a></li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>

    </div>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="side-body">



<?php

/*

	            <li class="panel panel-default">
                <a data-toggle="collapse" href="#dropdown-lvl1">
                    <span class="glyphicon glyphicon-user"></span> Sub Level <span class="caret"></span>
                </a>

                <!-- Dropdown level 1 -->
                <div id="dropdown-lvl1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul class="nav navbar-nav">
                            <li><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>

                            <!-- Dropdown level 2 -->
                            <li class="panel panel-default">
                                <a data-toggle="collapse" href="#dropdown-lvl2">
                                    <span class="glyphicon glyphicon-off"></span> Sub Level <span class="caret"></span>
                                </a>
                                <div id="dropdown-lvl2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav">
                                            <li><a href="#">Link</a></li>
                                            <li><a href="#">Link</a></li>
                                            <li><a href="#">Link</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>

*/