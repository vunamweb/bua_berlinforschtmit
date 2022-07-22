<?php
global $dir, $cid, $morpheus, $table, $js;
global $arr_form, $table, $tid, $mylink, $profile;

$profile = 1;

$mid = $_SESSION["mid"];
$save = $_POST["save"];
$newpass = $_GET["newpass"];

// print_r($_GET);

$arr_form = array(
	// array("","CONFIG", '<div class="col-12 col-md-6">'),
	array("img", "Foto", 'img'),
	// array("","CONFIG", '</div>'),
	array("anrede", "Anrede", '<input type="Text" value="#v#" class="form-control" name="#n#" required placeholder="Frau / Herr" />', ' col-12 col-md-6 col-lg-3'),
	array("titel", "Titel", '<input type="Text" value="#v#" class="form-control" name="#n#" required placeholder="Titel" />', ' col-12 col-md-6 col-lg-3'),
	array("vname", "Vorname", '<input type="Text" value="#v#" class="form-control" name="#n#" required placeholder="#ph#" />', ' col-12 col-md-6 col-lg-3'),
	array("nname", "Nachname", '<input type="Text" value="#v#" class="form-control" name="#n#" required placeholder="#ph#" />', ' col-12 col-md-6 col-lg-3'),
	array("organisation", "Organisation / Institution", '<input type="Text" value="#v#" class="form-control" name="#n#" required placeholder="#ph#" />', ' col-12 col-md-6'),
	// array("position", "Position / Funktion", '<input type="Text" value="#v#" class="form-control" name="#n#" placeholder="#ph#" />', ' col-12 col-md-6'),
	array("website", "Webseite", '<input type="Text" value="#v#" class="form-control" name="#n#" placeholder="#ph#" />', ' col-12 col-md-6'),
//	array("pw", "Passwort", '<input type="Text" value="#v#" class="form-control" name="#n#" required />', ' col-12 col-md-6'),
	array("fon", "Telefonnummer", '<input type="Text" value="#v#" class="form-control" name="#n#" placeholder="#ph#"  />', ' col-12 col-md-6'),
	array("email", "E-Mail Adresse", '<input type="Text" value="#v#" class="form-control" name="#n#" required placeholder="#ph#" />', ' col-12 col-md-6'),
//	array("wantEmail", "Ich möchte automatische Nachrichten erhalten", 'chk'),
	
	
	// array("","CONFIG", '</div><div class="col-6">'),
	// array("notes", "Über mich", '<textarea class="form-control profile_notes" name="#n#">#v#</textarea>'),
	// array("","CONFIG", '</div><div class="col-6">'),
	array("wishes", "ICH WÜNSCHE MIR, DASS BIS 2025 FOLGENDES ZIEL FÜR URBAN HEALTH ERREICHT WIRD …", '<textarea class="form-control profile_notes" name="#n#" placeholder="#ph#">#v#</textarea>', ' col-12 col-md-6'),
	array("taetigkeiten", "TÄTIGKEITSSCHWERPUNKTE/ FORSCHUNGSSCHWERPUNKTE<br>(MAX. FÜNF STICHWORTEN)", '<textarea class="form-control profile_notes" name="#n#" placeholder="#ph#">#v#</textarea>', ' col-12 col-md-6'),
	array("interests", "Meine Interessen in Stichpunkten", '<textarea class="form-control profile_notes" name="#n#" placeholder="#ph#">#v#</textarea>', ' col-12 col-md-6'),
	
	array("","CONFIG", '<div class="col-6"></div><div class="col-6">'),
	
	array("showProfile", "Mein Profil darf von den anderen Teilnehmern gesehen werden", 'chk'),
	
	array("","CONFIG", '</div><div class="col-6"><h3>Meine Interessen</h3>'),
	
	array("inID", "Interessen", 'radio_2_table', 'morp_intranet_user_interests', 'inID', 'interest', 'morp_intranet_user_allocation_interests', 'aiID', 'mid', $mid),
	
	array("","CONFIG", '</div>'),
);


$table = 'morp_intranet_user';
$tid = 'mid';

if ($save) {
	// makeImage('/www/htdocs/w0118b8d/php7.pixeldusche.com/intranet/images/portrait/org/DSC_8106.jpg', '/www/htdocs/w0118b8d/php7.pixeldusche.com/intranet/images/portrait/', '800x800', 0);
	$edit = saveMorpheusForm($mid, 0);
}

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
$output .= '
<div class="container">
';
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *



// NEW PASSWORD * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
if($newpass) {
	$output .= '<div class="row"><div class="col-6">';
	include("page/login-newpass.php");
	$output .= '</div></div>';
}


// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

else {
	$sql = "SELECT * FROM `$table` WHERE $tid='".$mid."'";
	$res = safe_query($sql);
	$checkit = mysqli_num_rows($res);
	$row = mysqli_fetch_object($res);
	//print_r($row);
	$portrait = $row->img;

	$form = '';

	foreach($arr_form as $arr) {
	 	$form .= setMorpheusFormFrontend($row, $arr, "portrait", $mid, 0, "mid", '400x400');
	}

	$output .= '
			<form method="post">
				<input type="hidden" value="1" name="save" />
				
				<div class="row">
					'.$form.'
					<div class="col-12 col-md-6">
						<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; Mein Profil speichern / aktualisieren</button>
						<br/><br/><a class="btn btn-info" href="'.$dir.'?hn=profil&cont=profil&newpass=1">Neues Passwort anlegen</a>
					</div>
				</div>
			</form>
			
			<h1>Meine Veranstaltungen</h1>
';
}

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *



$output .= '
</div>

<div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="imgModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="imgModalLabel">Image Upload</h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>';

