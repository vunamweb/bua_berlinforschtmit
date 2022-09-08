<?php
# # # # # # # # # # # # # # # # # # # # # # # # # # #
# www.pixel-dusche.de                               #
# björn t. knetter                                  #
# start 11/2007                                     #
#                                                   #
# post@pixel-dusche.de                              #
# frankfurt am main, germany                        #
# # # # # # # # # # # # # # # # # # # # # # # # # # #

global $morpheus;

$morpheus["layout"]			= array("","Dreispaltig");

/* DESIGNS BENENNUNG */
$morpheus["design"]			= array(
									1=>"Standard",
									2=>"Ohne Header Image",
#									3=>"Design 3",
#									1=>"Startseite",
#									3=>"Unterseiten mit Hintergrund-Bild",
#									5=>"Unterseiten volle Breite ohne Bild / Bsp. News",
#									4=>"Graph",
);

/* TEMPLATES BENENNUNG */
$morpheus["template"]		= array(

									1=>"Content<br>",
									2 => "Mehr Spalten Container<br>",
#									4=> "Blöcke<br>",
#									6=>"Text / Bild Container",
									5=>"Footer Bild<br>",

									7=> "Header Bild<br>",
#									5=> "Text plus Galerie<br>",
#									3=> "Text Slider<br>",
#									12=>"Galerie 4 Bilder",
#									8=> "Workshop<br>",
									11=> "Image Slider",
									9=> "Video / Movie Slider<br>",
#									20=>"Jobs<br>",
#									15=>"Zeitstrahl<br>",
#									16=> "Logo Slider<br>",
#									17=> "Video / Jobs Slider<br>",
									10=> "Events<br>",
#									5=> "Naviagtion",
#									3=>"Prozess",
									14=> "Ohne Format / z.B. Footer<br>",
									15=> "Audio",
									

);

$morpheus["navpos"]			= array(
									1=>"Hauptnavigation",
									2=>"Meta-Navigation",
#									3=>"Footer-Naviagtion"
									);

#$morpheus["news_formate"]	= array(1=>"Abstrakt und Detail", 4=>"Presse", );

# einstellungen, welche elemente in der seitenverwaltung aktiv sein sollen
$morpheus["foto"]			= 0;
$morpheus["standard_tid"]	= array(1);
$morpheus["standard_des"]	= 1;
#$morpheus["news_formate"]	= array(1=>"News", 3=>"Interview", 4=>"Settings");
$morpheus["news_formate"]	= array(1=>"News");

$morpheus["templ_conf1"]	= array(1=>"Container", 2=>"Container Text zentriert", 3=>"Container volle Breite", 4=>"Keine Section / nur fuer Admin");
// 3=>"Container Trennlinie", 5=>"Container BG Image ohne Text", 6=>"Image Slider", ); // 7=>'HTML', 8=>'HTML 2', 9=>"Container geringe Höhe / nur BG Image" );
#$morpheus["templ_conf2"]	= array(1=>"1/3 Spalten", 2=>"2/3 Spalte", 3=>"1/4 Spalte", 3=>"3/4 Spalte" );
$morpheus["templ_conf2"]	= array(1=>"1/2 Spalten", 2=>"3/4 Spalten",  3=>"1/4 Spalten",  4=>"2/3 Spalten", 5=>"1/3 Spalten", );
// 7=>"1/2 Spalten rechten Abstand",8=>"1/2 Spalten mit großem linken Abstand",9=>"1/2 Spalten mit extra großem linken Abstand", 10=>"1 Spalter", 11=>"leer", 12=>"1/2 Spalten für Parallax ohne Abstand");
// $morpheus["templ_conf2"]		= array(1=>"1/3 Spalten", 2=>"1/4 Spalten", 3=>"1/2 Spalten", 4=>"2/3 Spalten", 5=>"1/6 Spalten", 6=>"1/2 Spalten linker Abstand", 7=>"1/2 Spalten rechten Abstand",8=>"1/2 Spalten mit großem linken Abstand",9=>"1/2 Spalten mit extra großem linken Abstand", 10=>"1 Spalter", 11=>"leer", 12=>"1/2 Spalten für Parallax ohne Abstand");
//$morpheus["templ_conf3"]		= array(1=>"Logo // w=200 h=200", 2=>"Screens w=500");
$morpheus["templ_conf6"]		= array(1=>"1/2 Bild / 1/2 Text Management", 2=>"1/2 Text / 1/2 Bild Management", 3=>"1/2 Bild / 1/2 Text", 4=>"1/2 Text / 1/2 Bild", 5=>"Header Bild mit Text", 6=>"Header Startseite / Homepage");
// $morpheus["templ_conf7"]		= array(1=>"Bild links / Text rechts", 2=>"Text links / Bild rechts");
$morpheus["templ_conf15"]		= array(1=>"start", 2=>"end");

$morpheus["template_ende"]	= array(2,);
$morpheus["template_abstand"]= array(1,2,11);
$morpheus["template_pad"]	= array(1,2);
$morpheus["template_schmal"]	= array();


$auths_arr = array(
	10=>"Seitenverwaltung, Bildarchiv, Text Vorlagen, Formulare, News, Newsletter, Mailing",
	// 21=>"Mitarbeiter",
	30=>"Dokumente Downloads",
	50=>"Akteursdatenbank",
	60=>"Veranstaltungen / Events",
	40=>"Configuration",
	99=>"Settings, Userverwaltung",
);

