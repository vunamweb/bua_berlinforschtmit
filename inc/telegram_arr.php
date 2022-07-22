<?php

if($show)
	$arr_form = array(

			array("", "CONFIG", '<div class="col-md-12 mb2">'),

		array("mid", "", '<input type="hidden" value="'.$mid.'" name="#n#" required />'),
		array("sichtbar", "Online / sichtbar ?", 'chk'),

			array("", "CONFIG", '</div><div class="row mt2"><div class="col-md-6">'),

		array("tTitle", "Titel Telegram", '<input type="Text" value="#v#" class="form-control" name="#n#" required />'),
		array("tText", "Text", '<textarea class="form-control" name="#n#" required />#v#</textarea>'),
		array("datum", "Datum", '<input type="Text" value="#v#" class="form-control" name="#n#" />', 'date'),

//		array("datumende", "End Datum", '<input type="Text" value="#v#" class="form-control" name="#n#" required />'),

			array("", "CONFIG", '</div><div class="col-md-6">'),

		array("mail", "E-Mail für Kontaktaufnahme", '<input type="Text" value="#v#" class="form-control" name="#n#" required />', '', $profile["mail"]),
		array("fon", "Telefon für Kontaktaufnahme", '<input type="Text" value="#v#" class="form-control" name="#n#" required />', '', $profile["fon"]),

			array("", "CONFIG", '</div><div class="col-md-12 mb3 mt2">'),

//		array("img1", "Foto 1", 'img'),

		array("", "CONFIG", '</div></div>'),

	);

else
	$arr_form = array(
		array("tTitle", "Titel Telegram", '<input type="Text" value="#v#" class="form-control" name="#n#" required />'),
		array("tText", "Text", '<textarea class="form-control" name="#n#" required />#v#</textarea>'),
		array("mail", "E-Mail für Kontaktaufnahme", '<input type="Text" value="#v#" class="form-control" name="#n#" required />', '', $profile["mail"]),
		array("fon", "Telefon für Kontaktaufnahme", '<input type="Text" value="#v#" class="form-control" name="#n#" required />', '', $profile["fon"]),
	);


$table 	= 'morp_cms_telegram';
$tid 	= 'tid';


?>