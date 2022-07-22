<?php
# print_r($_SESSION);

global $dir, $navID;

$warn = '';
$youAreIn = 0;

$sessMNR = isset($_SESSION["custname"]) ? $_SESSION["custname"] : '';
$sessPASS = isset($_SESSION["pd"]) ? $_SESSION["pd"] : '';

if($sessMNR && $sessPASS) {
	$sql = "SELECT * FROM `morp_intranet_user` WHERE pass='".$sessPASS."' AND `morp_intranet_user`='".$sessMNR."' AND kontrolle=1";
	$res = safe_query($sql);
	$x = mysqli_num_rows($res);
	if($x > 0) $youAreIn = 1;
}

if($youAreIn) {
	$row = mysqli_fetch_object($res);
//	$arr = array("Nachname"=>"nachname", "Vorname"=>"vorname", "E-Mail"=>"email",  "Straße"=>"str", "PLZ"=>"plz", "Ort"=>"ort", "Geburtsdatum"=>"gebdat");
	$arr = array("Nachname"=>"nachname", "Vorname"=>"vorname", "E-Mail"=>"email", "Geburtsdatum"=>"gebdat");

	$output .= '<h2>Ihre Daten</h2>';

	foreach($arr as $key=>$val) {
		$output .= '<p class="clr"><span class="leftnormal">'.$key.'</span><span class="leftbold"> '.$row->$val.'</span></p>';
	}

	$output .= '<p class="clr">&nbsp;<br/>&nbsp;</p><p><a href="'.$dir.$navID[109].'"><span class="fa fa-external-link-square"></span> Change password</a></p>';
}

$output = $warn.$output;

