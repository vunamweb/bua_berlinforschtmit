<?php
session_start();
# # # # # # # # # # # # # # # # # # # # # # # # # # #
# www.pixel-dusche.de                               #
# björn t. knetter                                  #
# start 12/2003                                     #
#                                                   #
# post@pixel-dusche.de                              #
# frankfurt am main, germany                        #
# # # # # # # # # # # # # # # # # # # # # # # # # # #

include("cms_include.inc");

$arr = array( 4=>"Kein Zugang Morpheus", 2=>"Redakteur", 1=>"Administrator");

$mid	= $_REQUEST["mid"];
$neu	= $_REQUEST["neu"];
$save	= $_REQUEST["save"];
$unm	= $_REQUEST["unm"];
$vnm	= $_REQUEST["vname"];
$nnm	= $_REQUEST["nname"];
$email	= $_REQUEST["email"];

$isallowed	= $_REQUEST["isallowed"];
$optin	= $_REQUEST["optin"];

$anrede	= $_REQUEST["anrede"];
$fon	= $_REQUEST["fon"];
$pwd	= $_REQUEST["pwd"];
$adm	= $_REQUEST["adm"];

$newpass= $_REQUEST["newpass"];


$del	= $_REQUEST["del"];
$delete	= $_REQUEST["delete"];


echo "<div>";


if ($delete && $admin) {
	$sql = "DELETE FROM morp_intranet_user WHERE mid=$delete";
	$res = safe_query($sql);
}
elseif ($del) {
	$sql = "SELECT uname FROM morp_intranet_user WHERE mid=$del";
	$res = safe_query($sql);
	$row 	= mysqli_fetch_object($res);

	echo ('
		<p>M&ouml;chten Sie den morp_intranet_user <b>'.$row->uname .'</b> wirklich l&ouml;schen?</p>
		<p><a href="?delete='.$del.'" class="button">Ja</a> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href="?" class="button">Nein</a></p><br><br><br><br>
');
}


if ($save) {
	$ct = count($arr);

	$isallowed = $isallowed ? 1 : 0;
	$optin	= $optin ? 1 : 0;
	$adm = $adm ? $adm : 0;
	//$newpass=1;
	$pwd = md5($pwd);
	$set .= "uname='$unm', vname='$vnm', email='$email', anrede='$anrede', fon='$fon', nname='$nnm'".($neu || $newpass ? ", pw='$pwd'" : '').", admin=$adm,
	isallowed=$isallowed , optin=$optin";

	if ($neu) 	$query = "insert morp_intranet_user ";
	else 		$query = "update morp_intranet_user ";

	$query .= "set " .$set;

	if (!$neu) $query .= " WHERE mid=$mid";
	safe_query($query);

	// echo $query;
	
	unset($neu);
	unset($mid);
}

if ($mid || $neu) {
	echo "<h2>Mitgliederverwaltung</h2>";

	if (!$neu) {
		$query  = "SELECT * FROM morp_intranet_user WHERE mid=$mid ";
		$result = safe_query($query);
		$row 	= mysqli_fetch_object($result);
	}

	foreach ($arr as $val) {
		if ($row->$val == 1) $$val = "checked";
	}

	$admin = $row->admin || $row->berechtigung == 1 ? " checked" : '';
	$bere = $neu ? " checked" : '';

	echo '<p><a href="?">' .backlink().' zur&uuml;ck</a></p><p>&nbsp;</p>';
	echo '
	<form method="post">
		<input type="hidden" name="neu" value="'.$neu.'">
		<input type="hidden" name="mid" value="'.$mid.'">
		<input type="hidden" name="save" value="1">
		<p><label>Benutzername</label><input type="text" name="unm" value="'.$row->uname.'" class="form-control" placeholder=""></p>
		<p class="mt1"><label>Vorname</label><input type="text" name="vname" value="'.$row->vname.'" class="form-control" placeholder=""></p>
		<p class="mt1"><label>Nachname</label><input type="text" name="nname" value="'.$row->nname.'" class="form-control" placeholder=""></p>
		<p class="mt1"><label>E-Mail</label><input type="text" name="email" value="'.$row->email.'" class="form-control" placeholder=""></p>
		<p class="mt1"><label>Passwort</label><input type="text" name="pwd" value="'.$row->pw.'" class="form-control" placeholder=""></p>
		<p>&nbsp;</p>
		<p class="mt1"><input type="checkbox" name="optin" id="optin" value="1" class=""'.($row->optin ? ' checked' : '').'> &nbsp; <label for="optin">E-Mail bestätigt</label></p>
		<p class="mt1"><input type="checkbox" name="isallowed" id="isallowed" value="1" class=""'.($row->isallowed ? ' checked' : '').'> &nbsp; <label for="isallowed">freischalten</label></p>

		<div class="form-group">
			<div class="funkyradio">
				<div class="funkyradio-default">
					<input type="checkbox" name="pw" id="pw">
					<label for="pw">PW</label>
				</div>
			</div>
		</div>
		
		<p>&nbsp;</p>
		<p><input type="submit" class="button" name="speichern" value="speichern"></p>
';

}

elseif ($admin) {
	echo "<h2>Liste berechtigter Mitarbeiter f&uuml;r das Intranet</h2><p>&nbsp;</p>";

	echo '<table border=0 cellspacing=1 cellpadding=0 class="autocol p20">';
	echo '<tr>
		<td><p>Benutzername</p></td>
		<td>Vorname</td>
		<td>Name</td>
		<td>berechtigt</td>
		<td>Mail bestätigt</td>
		<td>E-Mail</td>
	</tr>';


	$query  = "SELECT * FROM morp_intranet_user WHERE 1 ORDER BY isallowed DESC, optin, nname, vname";
	$result = safe_query($query);
	$ct 	= mysqli_num_rows($result);
	$change = $ct / 3;

	while ($row = mysqli_fetch_object($result)) {
		$c++;

		$auth = explode("|", $row->auths);
		$authliste = array();
		foreach($auth as $val) {
			$authliste[] = $auths_arr[$val];
		}

		echo '<tr>
			<td><a href="?mid='.$row->mid.'">'.$row->email.'</a></td>
			<td>'.$row->vname.'</td>
			<td>'.$row->nname.'</td>
			<td>'.$row->isallowed.'</td>
			<td>'.$row->optin.'</td>
			<td>'.$row->email.'</td>
			<td><a href="?del='.$row->mid.'" class="btn btn-danger"><i class="fa fa-trash-o small"></i></a></td>
		</tr>';
	}

	echo '</table><div style="clear:left;"><p>&nbsp;</p>
		<p><a href="?neu=1" class="button"><i class="fa fa-plus small"></i> NEU </a></p></div>';
}

else die('<p><strong>Keine Berechtigung</strong></p>');
?>

</div>

<?php
include("footer.php");
?>