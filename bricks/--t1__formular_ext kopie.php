<?php
session_start();

global $form_desc, $cid, $navID, $lan, $nosend, $morpheus, $ssl_arr, $ssl, $lokal_pfad, $js, $cid, $formMailAntwort, $plichtArray, $multilang, $full, $mid, $isForm;

// FROM EVENT PAGE
if ($full){

}
else {

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
			<div class="col start">
	';
	$designEnde = '
			</div>
	';

	$design = '
			<div class="col-12 col-md-6 #style#">
				#cont#
			</div>
	';

	$designFull = '
			<div class="col-12">
				#cont#
			</div>
	';

	$designCheckbox = '
		<div class="col-12 #style#">
			<div class="row">
			<label>
				#cont#
					#desc# #zeile2#
			  </label>
			</div>
		</div>
	';

	$designCheckboxSchmal = '
		<div class="col-sm-4">
			<div class="row">
				<div class="col-1">
					#cont#
				</div>
				<div class="col-11">
					<label for="#feld#">#desc# #zeile2#</label>
				</div>
			</div>
		</div>
	';

	$designschmal = '
		<div class="col-sm-8">
			#cont#
		</div>
	';


	$designTEXT = '
		<div class="col-12 mt-4">
			#desc#
		</div>
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
	$isForm = $fid;

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

		if($row->pflicht) $plichtArray[]=array($desc, $feld, $art);
		if($style) $style = " col-md-".$style;

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
		if ($art == "Fieldset Start") $form .= '<fieldset class="row g-2" id="'.$feld.'" style="">';

		elseif ($art == "Fieldset Ende") $form .= '</fieldset>';

		elseif (isin("^Ende", $art)) $form .= '<br style="clear:both;" />';

		elseif ($art == "Eingabefeld") {
			$data = '<input id="'.$feld.'" name="'.$desc.'"'.$pflicht. ' placeholder="'.$desc.$star.'" type="text" class="form-control" />';
			$form .= str_replace(array('#cont#', '#desc#', '#style#'), array($data, $desc, $style), $design);
		}
		
		elseif ($art == "Datum") {
			$data = '
				<input type="text" class="daterange form-control" data-date-format="dd.mm.yyyy" name="'.$desc.'" id="'.$desc.'" placeholder="'.$desc.$star.'" '.$pflicht. ' />';
			$form .= str_replace(array('#cont#', '#desc#', '#style#'), array($data, $desc, $style), $design);
		}
		
		elseif ($art == "Checkbox") {
			$x++;

			unset($value);
			if (isin("\|", $feld)) {
				$t	 = explode("|", $feld);
				$feld 	= $t[0];
				$value  = $t[1];
			}

			$data = '<input type="checkbox"'. ($feld=="de"?' checked':'') .' class="option-input checkbox" id="'.$feld.'"  value="'. ($desc ? $desc : "ja") .'" name="'.$feld.'"'.$pflicht.' /> ';

			$desc = $desc ? ''.$desc.'<br/>' : '';
			$form .= str_replace(array('#cont#', '#desc#', '#style#', '#anz#', '#zeile2#', '#feld#'), array($data, nl2br($desc), $style, $x, '', $feld ), $designCheckbox);
			
			// CHECKBOX SCHALTET FIELDSET FREI
			if ($parent) $js .= '	var '.$feld.' = $("#'.$feld.'");
				var inital'.$feld.' = '.$feld.'.is(":checked");
				var topics'.$feld.' = $("#'.$parent.'")[inital'.$feld.' ? "removeClass" : "addClass"]("hide");
				var topicInputs'.$feld.' = topics'.$feld.'.find("input").attr("disabled", !inital'.$feld.');
				var topicText'.$feld.' = topics'.$feld.'.find("textarea").attr("disabled", !inital'.$feld.');
				'.$feld.'.on("click", function() {
					console.log(8);
					topics'.$feld.'[this.checked ? "removeClass" : "addClass"]("hide");
					topicInputs'.$feld.'.attr("disabled", !this.checked);
					topicText'.$feld.'.attr("disabled",  !this.checked);
				});
';
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
			$data .= fpdForm($feld, $auswahl, "sel", $pflicht, $breite, $desc.' – bitte w&auml;hlen').'</select>';

			if ($pflicht) {
				// $data .= '<label for="'.$feld.'" class="error">Bitte w&auml;hlen Sie eine Option</label>';
				$rules .= $feld.': "required",
	';
			}
			$form .= str_replace(array('#cont#', '#desc#', '#style#'), array($data, $desc, $style), $design);
			// else $form .= str_replace(array('#cont#', '#desc#', '#style#'), array($data, $desc, $style), $designschmal);
		}

		elseif ($art == "Mitteilungsfeld") {
			$data .= '<textarea id="'.$feld.'" name="'.$feld.'"'.$pflicht.' placeholder="'.$desc.'" class="form-control h100"></textarea>';
			$form .= str_replace(array('#cont#', '#desc#', '#style#', '#zeile2#'), array($data, $desc, $style, ''), $designFull);
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
	if($lan == "de") $datenschutzID = 97;
	else if($lan == "en") $datenschutzID = 100;

	$dsText = '<div class="form-group"><label for="datenschutz"><input id="datenschutz" type="checkbox" class="option-input checkbox" name="datenschutz" required ><span  class="lb">';

	if($lan == "de") $dsText .= 'Ich stimme zu, dass meine Angaben aus dem Kontaktformular zur Beantwortung meiner Anfrage erhoben und verarbeitet werden. Die Daten werden nach abgeschlossener Bearbeitung Ihrer Anfrage gelöscht. Hinweis: Sie können Ihre Einwilligung jederzeit für die Zukunft per E-Mail an <a href="mailto:'.$morpheus['email'].'">'.$morpheus['email'].'</a> widerrufen. Detaillierte Informationen zum Umgang mit Nutzerdaten finden Sie in unserer <a href="'.$dir.$navID[$datenschutzID].'" target="_blank"><u>Datenschutzerklärung</u></a>';

	elseif($lan == "en") $dsText .= 'I agree that my details from the contact form will be collected and processed to answer my request. The data will be deleted after processing your request. Note: You can revoke your consent at any time in future by e-mail to <a href="mailto:'.$morpheus['email'].'">'.$morpheus['email'].'</a>.
Detailed information on handling user data can be found in our <a href="'.$dir.($multilang ? $lan.'/' : '').$navID[$datenschutzID].'" target="_blank">Data protection</a>';

	$dsText .= '</span></label></div>';

	$bitteCode = '';
	if($lan == "de") $bitteCode = 'Bitte diesen Code einsetzen:';
	else if($lan == "en") $bitteCode = 'Please insert this code:';

	$senden = '';
	if($lan == "de") $senden = 'Absenden';
	else if($lan == "en") $senden = 'Send';
	
	$Pflichtfelder = '';
	if($lan == "de") $Pflichtfelder = 'Pflichtfelder';
	else if($lan == "en") $Pflichtfelder = 'Mandatory fields';
	


	// $js = str_replace(array('<!-- rules -->', '<!-- optional -->', '<!-- messages -->'), array($rules, $optional, $messages), $js);

	$output .= '
					<div id="kontaktformular" class="box_frm_contact ">
						<div class="row">
							<div class="col-12">
								<div id="message" class="alert alert-primary text-center hide">alert</div>								
							</div>
						</div>
						<form id="kontaktf" method="post" class="row gy-2 gx-3 align-items-center">
							<input type="Hidden" name="fid" value="'.$fid.'">							
							<input type="hidden" name="myid" value="'.$mid.'">							
								'.$form .'
							<div class="frm_contact_body">
								'.$dsText.'
								<span class="">* '.$Pflichtfelder.'</span>
								<p class="mt2"><button class="btn btn-send sendform" type="submit">'.$senden.'</button></p class="mt2">
							</div>
						</form>

					</div>
	';
}

	$morp = '<b>FORMULAR</b>';



// $js .= '
// 	
// 	$(document).ready(function() {
// 		$("#anrede").val("'.$_SESSION["anrede"].'");
// 		$("#name").val("'.$_SESSION["vname"].' '.$_SESSION["nname"].'");
// 		$("#email").val("'.$_SESSION["email"].'");
// 	});
// 	';
