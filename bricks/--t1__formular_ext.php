<?php
session_start();

global $form_desc, $cid, $navID, $lan, $nosend, $morpheus, $ssl_arr, $ssl, $lokal_pfad, $js, $cid, $formMailAntwort, $plichtArray, $multilang;


// print_r($_REQUEST);


// .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .
// .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .
// .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .
// .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .
// DESIGN DES FORMULARES
// .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .
// .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .
// .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .
// .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .

	$designStart = '
			<div class="form-group">
	';
	$designEnde = '
			</div>
	';

	$design = '
			<div class="form-group">
				#cont#
			</div>
	';

	$designFull = '
			<div class="form-group col-12">
				#zeile2# #cont#
			</div>
	';

	$designCheckbox = '
		<div class="form-group col-12">
			<div class="row">
				<div class="col-1">
					#cont#
				</div>
				<div class="col-10">
					<label>#desc# #zeile2#</label>
				</div>
			</div>
		</div>
	';

	$designCheckboxSchmal = '
		<div class="form-group col-md-6 col-12">
			<div class="row">
				<div class="col-1">
					#cont#
				</div>
				<div class="col-10">
					<label>#desc# #zeile2#</label>
				</div>
			</div>
		</div>
	';

	$designschmal = '
		<div class="form-group col-md-6 col-12">
			<label>#desc#</label> &nbsp; &nbsp;<br/>
			#cont#
		</div>
	';


	$designTEXT = '
			#desc#
	';
	$designTEXTschmal = '
		<div class="col-12 col-md-6 mb2">
			<p>#desc#</p>
		</div>
	';
	$designFETT = '
		<div class="col-12 ">
			<h3>#desc#</h3>
		</div>
	';

// .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .
// .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .
// .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .
// ENDE DESIGN
// .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .
// .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .
// .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .    .

	$fid 	= $text;

	$query  	= "SELECT * FROM morp_cms_form WHERE fid=".$fid;
	$result 	= safe_query($query);
	$row 		= mysqli_fetch_object($result);
	$formMailAntwort = $row->antwort;

	$query  = "SELECT * FROM morp_cms_form_field WHERE fid=$fid ORDER BY reihenfolge";
	$result = safe_query($query);

	$x = 0;

	$plichtArray = array();

	while ($row    = mysqli_fetch_object($result)) {
		$nm 	= $row->fname;
		$text 	= $row->fform;

		$art 	= $row->art;
		$feld 	= $row->feld;
		$desc 	= ($row->desc);
		$hilfe 	= $row->hilfe;
		$email 	= $row->email;
		$size	= $row->size;
		$parent	= $row->parent;
		$fehler	= $row->fehler;
		$style  = $row->klasse;
		$cont	= $row->cont;
		$auswahl = ($row->auswahl);

		$star = ' *';
		$pflicht = '';

		if($row->pflicht) $plichtArray[]=$row->feld;

		if ($cont == "email" && $row->pflicht) 	{ $pflicht = ' required'; }
		elseif ($cont == "number" && $row->pflicht) 	{ $pflicht = ' required'; $rules .= $feld.': { required:true, number: true },
	'; }
		elseif ($cont == "number") 	{ $star = ''; $rules .= $feld.': { number: true },
	'; }
		elseif ($cont == "email") 	{ $pflicht = ' class="email"'; $star = ''; }
		elseif ($row->pflicht) 	{ $pflicht = ' required'; }
		else					{ $pflicht = ''; $star = ''; }

		//$desc .= $star;

		if ($fehler) 	$messages .= $feld.': "'.$fehler.'"'.",\n";

		$data = "";

		// FELD IST ABHAENGIG DAVON; DASS EINE CHECKBOX AKTIVIERT WURDE
		if ($art == "Fieldset Start") $form .= '</table><fieldset id="'.$feld.'" style="">'.$table;

		elseif ($art == "Fieldset Ende") $form .= '</table></fieldset>'.$table;

		// elseif (isin("^Ende", $art)) $form .= '<br style="clear:both;" />';

		elseif ($art == "Eingabefeld") {
			$data = '<input id="'.$feld.'" name="'.$desc.'"'.$pflicht. ' placeholder="'.$desc.$star.'" type="text" class="form-control" />';
			if ($style == "schmal") $form .= str_replace(array('#cont#', '#desc#', '#style#'), array($data, $desc, $style), $designschmal);
			else $form .= str_replace(array('#cont#', '#desc#', '#style#'), array($data, $desc, $style), $design);
		}

		elseif ($art == "Checkbox") {
			$x++;

			unset($value);
			if (isin("\|", $feld)) {
				$t	 = explode("|", $feld);
				$feld 	= $t[0];
				$value  = $t[1];
			}

			$data = '<input type="checkbox"'. ($feld=="de"?' checked':'') .' class="checkbox" id="'.$feld.'" '. ($value ? ' value="'.$value.'"' : ' value="ja"') .' name="'.$desc.'"'.$pflicht.' /> ';

			$selectDesign = $style == "sp2" ? $designCheckboxSchmal : $designCheckbox;
			$desc = $desc ? ''.$desc.'<br/>' : '';
			$form .= str_replace(array('#cont#', '#desc#', '#style#', '#anz#', '#zeile2#'), array($data, nl2br($desc), $style, $x, '<span class="hilfe">'.nl2br($hilfe).'</span>' ), $selectDesign);

			// CHECKBOX SCHALTET FIELDSET FREI
/*
			if ($parent) $optional .= '	var '.$feld.' = $("#'.$feld.'");
		var inital'.$feld.' = '.$feld.'.is(":checked");
		var topics'.$feld.' = $("#'.$parent.'")[inital'.$feld.' ? "removeClass" : "addClass"]("gray");
		var topicInputs'.$feld.' = topics'.$feld.'.find("input").attr("disabled", !inital'.$feld.');
		var topicText'.$feld.' = topics'.$feld.'.find("textarea").attr("disabled", !inital'.$feld.');
		'.$feld.'.click(function() {
			topics'.$feld.'[this.checked ? "removeClass" : "addClass"]("gray");
			topicInputs'.$feld.'.attr("disabled", !this.checked);
			topicText'.$feld.'.attr("disabled",  !this.checked);
		});
	';
*/
		}

		elseif ($art == "Radiobutton") {
			$data .= fpdForm($feld, $auswahl, "radio", $pflicht);
			if ($pflicht) {
				$rules .= $feld.': "required",
	';
			}
			$form .= str_replace(array('#cont#', '#desc#', '#style#'), array($data, $desc, $style), $design);
		}

		elseif ($art == "Dropdown") {
/*
			if ($style == " StSp1" || $style == " StSp2" || $style == " StSp3") $breite = 100;
			else $breite = 180;
*/

			if (!isin("print.php", $uri)) 	$data .= fpdForm($feld, $auswahl, "sel", $pflicht, $breite).'</select>';
			else 							$data .= fpdForm($feld, $auswahl, "radio", $pflicht);

			if ($pflicht) {
				// $data .= '<label for="'.$feld.'" class="error">Bitte w&auml;hlen Sie eine Option</label>';
				$rules .= $feld.': "required",
	';
			}
			if ($style == " schmal") $form .= str_replace(array('#cont#', '#desc#', '#style#'), array($data, $desc, $style), $designschmal);
			else $form .= str_replace(array('#cont#', '#desc#', '#style#'), array($data, $desc, $style), $designschmal);
		}

		elseif ($art == "Mitteilungsfeld") {
			$data .= '<textarea id="'.$feld.'" name="'.$feld.'"'.$pflicht.' placeholder="'.$desc.'" class="form-control h100"></textarea>';
			$form .= str_replace(array('#cont#', '#desc#', '#style#', '#zeile2#'), array($data, $desc, $style, '<p class="hilfe">'.nl2br($hilfe).'</p>'), $design);
		}

		elseif ($art == "Freitext Fett") {
			$form .= str_replace(array('#desc#', '#anz#'), array(nl2br($hilfe), $x), $designFETT);
		}

		elseif ($art == "Freitext") {
			$form .= str_replace(array('#desc#', '#anz#'), array(nl2br($hilfe), $x), $designTEXT);
		}

		elseif ($art == "Freitext Headline") {
			$form .= str_replace(array('#desc#', '#anz#'), array('<h2 class="underline">'.nl2br($hilfe).'</h2>', $x), $designTEXT);
		}

		elseif ($art == "Freitext halbe Spalt") {
			$form .= str_replace(array('#desc#', '#anz#'), array(''.nl2br($hilfe).'', $x), $designTEXTschmal);
		}

		elseif ($art == "Ende Spalte") {
			$form .= str_replace(array('#desc#', '#anz#'), array('END', $x), $designEnde);
		}
		elseif ($art == "Start Spalte") {
			$form .= str_replace(array('#desc#', '#anz#'), array('START', $x), $designStart);
		}

	}


	$dsText = '';
	if($lan == "de") $datenschutzID = 9;
	else if($lan == "en") $datenschutzID = 24;
	else if($lan == "fr") $datenschutzID = 24;

	if($lan == "de") $dsText = '<p class="smaller"><input id="datenschutz" type="checkbox" name="datenschutz" required > &nbsp; Ich stimme zu, dass meine Angaben aus dem Kontaktformular zur Beantwortung meiner Anfrage erhoben und verarbeitet werden. Die Daten werden nach abgeschlossener Bearbeitung Ihrer Anfrage gelöscht. Hinweis: Sie können Ihre Einwilligung jederzeit für die Zukunft per E-Mail an <a href="mailto:'.$morpheus['email'].'">'.$morpheus['email'].'</a> widerrufen. Detaillierte Informationen zum Umgang mit Nutzerdaten finden Sie in unserer <a href="'.$dir.$navID[$datenschutzID].'" target="_blank"><u>Datenschutzerklärung</u></a></p>';
	elseif($lan == "en") $dsText = '<p class="smaller"><input id="datenschutz" type="checkbox" name="datenschutz" required > I agree that my details from the contact form will be collected and processed to answer my request. The data will be deleted after processing your request.</p>
							<p class="smaller">Note: You can revoke your consent at any time in future by e-mail to <a href="mailto:'.$morpheus['email'].'">'.$morpheus['email'].'</a>.
Detailed information on handling user data can be found in our <a href="'.$dir.($multilang ? $lan.'/' : '').$navID[$datenschutzID].'" target="_blank">Data protection</a></p>';
	elseif($lan == "fr") $dsText = '<p> class="smaller"<input id="datenschutz" type="checkbox" name="datenschutz" required > J\'accepte que mes données du formulaire de contact soient collectées et traitées pour répondre à ma demande. Les données seront supprimées après la fin du traitement de votre demande.</p>
							<p class="smaller">Remarque : Vous pouvez annuler votre accord à tout moment à l’avenir en envoyant un e-mail à <a href="mailto:'.$morpheus['email'].'">'.$morpheus['email'].'</a>.
Vous trouverez des informations détaillées sur le traitement des données dans notre <a href="'.$dir.($multilang ? $lan.'/' : '').$navID[$datenschutzID].'" target="_blank">Déclaration de confidentialité</a></p>';

	$bitteCode = '';
	if($lan == "de") $bitteCode = 'Bitte diesen Code einsetzen:';
	else if($lan == "en") $bitteCode = 'Please insert this code:';
	else if($lan == "fr") $bitteCode = 'Veuillez insérer ce code:';

	$senden = '';
	if($lan == "de") $senden = 'Absenden';
	else if($lan == "en") $senden = 'send';
	else if($lan == "fr") $senden = 'envoyer';


	$js = str_replace(array('<!-- rules -->', '<!-- optional -->', '<!-- messages -->'), array($rules, $optional, $messages), $js);


	$output .= '
			<div class="row">
				<div class="col-12 col-md-8 offset-md-2">
					<div id="kontaktformular" class="box_frm_contact">
						<form id="kontaktf" method="post">
							<input type="Hidden" name="fid" value="'.$fid.'">


							<div class="frm_contact_body">
								'.$form .'
								'.$dsText.'
								<span class="">* sind Pflichtfelder</span>
								<p class="mt2"><button class="btn btn-send sendform" type="submit">'.$senden.'</button></p class="mt2">
							</div>

							<div class="frm_contact_footer">
								<a class="btn btnemail" href="mailto:mail@yukon.pm">mail@yukon.pm</a>
							</div>
						</form>

					</div>
				</div>
			</div>
	';

/*
	$output .= '

					<div id="kontaktformular">
						<form id="kontaktf" method="post">
							<input type="Hidden" name="fid" value="'.$fid.'">


							<div class="row">'.$form .'</div>

							'.$dsText.'

							<div class="row">
								<div class="col-12">
									<span>'.$bitteCode.'</span>  <img src="'.$dir.'c.php" alt="" stlye="display:inline-block" />
									<input type="text" name="eintrag" id="eintrag" required  class="form-control" style="width:80px; display:inline-block " />
								</div>
								<div class="col-12">
									<span class="small">* sind Pflichtfelder</span>
								</div>
								<div class="col-12 text-right">
									<button class="btn btn-info bg-orange sendform" type="submit">'.$senden.'</button>
								</div>
							</div>

						</form>

	';
*/


	$morp = '<b>FORMULAR</b>';

?>