<?php

if($show)
	$arr_form = array(

			array("", "CONFIG", '<div class="col-md-12 mb2">'),

		array("mid", "", '<input type="hidden" value="'.$mid.'" name="#n#" required />'),
		array("sichtbar", "Online / sichtbar ?", 'chk'),
		array("isAngebot", "Das ist ein Angebot / nicht aktiv = Suchanfrage", 'chk'),

			array("", "CONFIG", '</div><div class="row mt2"><div class="col-md-6">'),

		array("aTitle", "Titel Anzeige / Angebot", '<input type="Text" value="#v#" class="form-control" name="#n#" required />'),
		array("aDesc", "Vollständige Beschreibung", '<textarea class="form-control" name="#n#" required />#v#</textarea>'),
		array("aPreis", "Preis (oder kostenlos)", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
//		array("datumende", "End Datum", '<input type="Text" value="#v#" class="form-control" name="#n#" required />'),

			array("", "CONFIG", '</div><div class="col-md-6">'),

		array("mail", "E-Mail für Kontaktaufnahme", '<input type="Text" value="#v#" class="form-control" name="#n#" required />', '', $profile["mail"]),
		array("fon", "Telefon für Kontaktaufnahme", '<input type="Text" value="#v#" class="form-control" name="#n#" required />', '', $profile["fon"]),

			array("", "CONFIG", '</div><div class="col-md-12 mb3 mt2">'),

		array("img1", "Foto 1", 'img'),
		array("img2", "Foto 2", 'img'),
		array("img3", "Foto 3", 'img'),
		array("img4", "Foto 4", 'img'),
		array("", "CONFIG", '</div></div>'),

	);

else
	$arr_form = array(
		array("mid", "", '<input type="hidden" value="'.$mid.'" name="#n#" required />'),
		array("aTitle", "Titel Anzeige / Angebot", '<input type="Text" value="#v#" class="form-control" name="#n#" required />'),
		array("aDesc", "Vollständige Beschreibung", '<textarea class="form-control" name="#n#" required />#v#</textarea>'),
		array("aPreis", "Preis (oder kostenlos)", '<input type="Text" value="#v#" class="form-control" name="#n#" required />'),
//		array("datumende", "End Datum", '<input type="Text" value="#v#" class="form-control" name="#n#" required />'),
		array("mail", "E-Mail für Kontaktaufnahme", '<input type="Text" value="#v#" class="form-control" name="#n#" required />', '', $profile["mail"]),
		array("fon", "Telefon für Kontaktaufnahme", '<input type="Text" value="#v#" class="form-control" name="#n#" required />', '', $profile["fon"]),
	);


$table 	= 'morp_cms_angebote';
$tid 	= 'aid';


?>