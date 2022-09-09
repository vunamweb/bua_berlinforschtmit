<?php
global $form_desc, $cid, $navID, $lan, $nosend, $morpheus, $ssl_arr, $ssl, $lokal_pfad, $js, $cid, $formMailAntwort, $plichtArray, $multilang, $full, $mid, $isForm;

// FROM EVENT PAGE
if($_POST && $_FILES) {
	include("./POST.php");
}

else if ($full){

}

else {
	session_start();

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

$uploadForm = 0;

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
	<div class="form-group cb">
			#cont#
		<label for="#id#" class="lb">
			#desc#
		</label>
	</div>
	';

	$designCheckboxSchmal = '
		<div class="form-group">#cont#
			<label for="#id#" class="lb">#desc#</label>
		</div>
	';

	$designschmal = '
		<div class="form-group col-md-6 col-12">
			<label>#desc#</label> &nbsp; &nbsp;<br/>
			#cont#
		</div>
	';


	$designTEXT = '
			<p class="mb2">#desc#</p>
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
	$isForm = $fid;

	$query  	= "SELECT * FROM morp_cms_form WHERE fid=".$fid;
	$result 	= safe_query($query);
	$row 		= mysqli_fetch_object($result);
	$formMailAntwort = $row->antwort;
	$button 	= $row->button;
	global $mailcopy;
	$mailcopy 	= $row->mailcopy;

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
			$data = '<input id="'.$feld.'" name="'.$feld.'"'.$pflicht. ' placeholder="'.$desc.$star.'" type="text" class="form-control" />';
			if ($style == "schmal") $form .= str_replace(array('#cont#', '#desc#', '#style#'), array($data, $desc, $style), $designschmal);
			else $form .= str_replace(array('#cont#', '#desc#', '#style#'), array($data, $desc, $style), $design);
		}
		
		elseif ($art == "Upload") {
			$data = '<input type="file" name="file" id="'.$feld.'" name="'.$desc.'"'.$pflicht. ' placeholder="'.$desc.$star.'" type="text" class="form-control" required />';
			$form .= str_replace(array('#cont#', '#desc#', '#style#'), array($data, $desc, $style), $design);
			$uploadForm = 1;
		}
		
		
		elseif ($art == "Checkbox") {
			$x++;

			unset($value);
			if (isin("\|", $feld)) {
				$t	 = explode("|", $feld);
				$feld 	= $t[0];
				$value  = $t[1];
			}

			$data = '<input type="checkbox"'. ($feld=="de"?' checked':'') .' class="checkbox" id="'.$feld.'" '. ($value ? ' value="'.$value.'"' : ' value="ja"') .' name="'.$feld.'"'.$pflicht.' /> ';

			$selectDesign = $style == "sp2" ? $designCheckboxSchmal : $designCheckbox;
			$desc = $desc ? ''.$desc.'<br/>' : '';
			$form .= str_replace(array('#cont#', '#desc#', '#style#', '#anz#', '#zeile2#', '#id#'), array($data, nl2br($desc), $style, $x, '', $feld ), $selectDesign);

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
	if($lan == "de") $datenschutzID = 6;
	else if($lan == "en") $datenschutzID = 100;

	$dsText = '<div class="form-group cb"><input id="datenschutz" type="checkbox" name="datenschutz" required ><label for="datenschutz" class="lb">';

	if($fid == 6) $dsText .= 'Ja, ich stimme der Nutzung meiner Daten gemäß <a href="'.$dir.$navID[$datenschutzID].'" target="_blank">AGB und DSGVO</a> zu.</label></div>';
	
	else if($lan == "de") $dsText .= 'Ich stimme zu, dass meine Angaben aus dem Kontaktformular zur Beantwortung meiner Anfrage erhoben und verarbeitet werden. Die Daten werden nach abgeschlossener Bearbeitung Ihrer Anfrage gelöscht. Hinweis: Sie können Ihre Einwilligung jederzeit für die Zukunft per E-Mail an <a href="mailto:'.$morpheus['email'].'">'.$morpheus['email'].'</a> widerrufen. Detaillierte Informationen zum Umgang mit Nutzerdaten finden Sie in unserer <a href="'.$dir.$navID[$datenschutzID].'" target="_blank"><u>Datenschutzerklärung</u></a>.</label></div>';

	elseif($lan == "en") $dsText .= 'I agree that my details from the contact form will be collected and processed to answer my request. The data will be deleted after processing your request. Note: You can revoke your consent at any time in future by e-mail to <a href="mailto:'.$morpheus['email'].'">'.$morpheus['email'].'</a>.
Detailed information on handling user data can be found in our <a href="'.$dir.($multilang ? $lan.'/' : '').$navID[$datenschutzID].'" target="_blank">Data protection</a></label></div>';


	$bitteCode = '';
	if($lan == "de") $bitteCode = 'Bitte diesen Code einsetzen:';
	else if($lan == "en") $bitteCode = 'Please insert this code:';

	$senden = '';
	if($lan == "de") $senden = $button ? $button : 'Absenden';
	else if($lan == "en") $senden = 'Send';
	
	$Pflichtfelder = '';
	if($lan == "de") $Pflichtfelder = 'Pflichtfelder';
	else if($lan == "en") $Pflichtfelder = 'Mandatory fields';
	


	$js = str_replace(array('<!-- rules -->', '<!-- optional -->', '<!-- messages -->'), array($rules, $optional, $messages), $js);

	if($fid == 6) $output .= '
<div class="modal fade" id="stimmeText" tabindex="-1" aria-labelledby="stimmeTextLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">			
				<button type="button" class="btn-close close reload" data-bs-dismiss="modal" aria-label="Close">
				<img src="'.$dir.'images/SVG/i_close.svg" alt="" class="img-fluid" width="20">
				</button>
			</div>
				
			<div class="modal-body">			
';
	$output .= '
				
				<div class="row">
					<div class="col-12 mt2">

						<div id="kontaktformular" class="box_frm_contact">
							<div class="row">
								<div class="col-12">
									<div id="message" class="alert alert-primary text-center hide">alert</div>		
								</div>
							</div>
							<form id="kontaktf" method="post"'.($uploadForm ? ' enctype="multipart/form-data"' : '').'>
								<input type="Hidden" name="fid" value="'.$fid.'">							
								<input type="hidden" name="myid" value="'.$mid.'">							
									'.$form .'
								<div class="frm_contact_body">
									'.$dsText.'
									<span class="">* '.$Pflichtfelder.'</span>
									<p class="mt2"><button class="btn btn-success btn-send'.($uploadForm ? '' : ' sendform').'" type="submit">'.$senden.'</button></p class="mt2">
								</div>
							</form>
	
						</div>

					</div>
				</div>
	';
					
	if($fid == 6) $output .= '
				
			</div>
		</div>
	</div>
</div>
	';
}

	$morp = '<b>FORMULAR</b>';


// if($_SESSION["nname"])
// 	$js .= '
// 	
// 	$(document).ready(function() {
// 		$("#anrede").val("'.$_SESSION["anrede"].'");
// 		$("#name").val("'.$_SESSION["vname"].' '.$_SESSION["nname"].'");
// 		$("#email").val("'.$_SESSION["email"].'");
// 	});
// 	';


