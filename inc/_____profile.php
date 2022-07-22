<?php
global $dir, $cid, $morpheus, $table;
global $arr_form, $table, $tid, $mylink, $mid;


$save = $_POST["save"];
$newpass = $_GET["newpass"];

// print_r($_GET);

$arr_form = array(
	array("anrede", "Anrede", '<input type="Text" value="#v#" class="form-control" name="#n#" required placeholder="Frau / Herr" />'),
	array("vname", "Vorname", '<input type="Text" value="#v#" class="form-control" name="#n#" required />'),
	array("nname", "Nachname", '<input type="Text" value="#v#" class="form-control" name="#n#" required />'),
//	array("pw", "Passwort", '<input type="Text" value="#v#" class="form-control" name="#n#" required />'),
	array("fon", "Telefonnummer", '<input type="Text" value="#v#" class="form-control" name="#n#"  />'),
	array("email", "E-Mail Adresse", '<input type="Text" value="#v#" class="form-control" name="#n#" required />'),
//	array("wantEmail", "Ich möchte automatische Nachrichten erhalten", 'chk'),
	array("img", "Foto", 'img'),
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
	include("login-newpass.php");
}


// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

else {
	$sql = "SELECT * FROM `$table` WHERE $tid='".$mid."'";
	$res = safe_query($sql);
	$checkit = mysqli_num_rows($res);
	$row = mysqli_fetch_object($res);

	$portrait = $row->img;

	$form = '';

	foreach($arr_form as $arr) {
	 	$form .= setMorpheusForm($row, $arr, "portrait", $mid, 0, "mid", '400x400');
	}

	$output .= '
	<div class="row">
		<div class="col-sm-6">
			<form method="post">
				<input type="hidden" value="1" name="save" />
				'.$form.'
				<hr>
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; Mein Profil speichern / aktualisieren</button>
			</form>

		</div>
		<div class="col-sm-6">
			'.($portrait ? '<img src="'.$dir.'mthumb.php?w=300&amp;h=300&amp;src=images/portrait/'.urlencode($portrait).'" class="mt2" />' : '').'
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6 mt4">
			<a class="btn btn-info" href="'.$dir.'?hn=profil&cont=profil&newpass=1">Neues Passwort anlegen</a>
		</div>
		<div class="col-sm-6">

		</div>
	</div>
';
}

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *



$output .= '
</div>

';

?>