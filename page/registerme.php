<?php
session_start();
/**
* Filename.......: example.1.php
* Project........: HTML Mime Mail class
* Last Modified..: 15 July 2002
*/

//  error_reporting(E_ALL);
//	print_r($_POST);

global $lan;
$lan = isset($_POST["lan"]) ? $_POST["lan"] : "de";
$portal = isset($_POST["portal"]) ? $_POST["portal"] : "";
$pixel = isset($_POST["pixel"]) ? $_POST["pixel"] : 0;
$checkit = isset($_SESSION['evC']) ? $_SESSION['evC'] : '';

$send = 1;

if ($checkit) {
	$checkit = explode("-", $checkit);
	$checkit = $checkit[1];
	$send = $pixel == $checkit ? 1 : 0;
}

$checkMySec = md5("pixeldusche".date("ymd"));
$sec = isset($_POST["mystring"]) ? $_POST["mystring"] : 0;

$data = json_decode($_POST['data'],true);

$fid = $data[0];
$fid = $fid["value"];

include("../nogo/funktion.inc");
include("../nogo/config.php");
$mail_txt = $morpheus["mail_start"].'<p><b>Ein neuer Antrag f�r den Mitgliederbereich liegt vor.</b></p> <p>Bitte schalten Sie den Benutzer frei.</p><p>&nbsp;</p>';

$x = count($data);

for($i=0; $i<($x-1); $i++) {
	if($data[$i]["name"]=="name") $nname = $data[$i]["value"];
	else if($data[$i]["name"]=="vorname") $vname = $data[$i]["value"];
	else if($data[$i]["name"]=="email") $email = trim($data[$i]["value"]);
	else if($data[$i]["name"]=="anrede") $anrede = trim($data[$i]["value"]);
	else if($data[$i]["name"]=="titel") $titel = trim($data[$i]["value"]);
	else if($data[$i]["name"]=="website") $website = trim($data[$i]["value"]);
	else if($data[$i]["name"]=="institution") $institution = trim($data[$i]["value"]);
	
	else if($data[$i]["name"]=="pass1") $pw1 = $data[$i]["value"];
	else if($data[$i]["name"]=="pass2") $pw2 = $data[$i]["value"];
	
	if($data[$i]["name"]!="pass1" && $data[$i]["name"]!="pass2") 
		$mail_txt .= '<p><b>'.utf8_decode(ucfirst($data[$i]["name"])).'</b>: '.utf8_decode(nl2br($data[$i]["value"])).'</p>';

}

if(validEmail($email) < 1) { echo "mailfailed"; die(); }
if($pw1 != $pw2) { echo "pwfailed"; die(); }
if(strlen($pw1) < 6 )  { echo "pwfaileds"; die(); }
// echo($mail_txt);

include("../nogo/db2.php");
dbconnect();

$SID = md5($email.$pw1);
$optlink = '<a href="'.$morpheus["url"].'?optin='.$SID.'">'.$morpheus["url"].'?optin='.$SID.'</a>';
$mail_txt_double_opt_in = $morpheus["mail_start"]. str_replace('#URL#', $optlink, textvorlage(39));

if( $sec && ($sec == $checkMySec) && $send ) {
	$sql = "SELECT * FROM morp_intranet_user WHERE email='$email'";
	$res = safe_query($sql);
	$row = mysqli_fetch_object($res);

	if(mysqli_num_rows($res)>0) {
		echo "xxx";
		die();
	}
	
	$sql = "INSERT morp_intranet_user SET ".($portal ? "$portal=1," : "")." 
		email='$email', uname='$email', nname='$nname', vname='$vname', 
		website='$website', anrede='$anrede', titel='$titel', organisation='$institution',
		pw='".md5($pw1)."', SID='$SID'";
	
	//echo $sql;
	$res = safe_query($sql);

	$sql = "SELECT * FROM morp_settings WHERE 1";
	$res = safe_query($sql);
	while($row = mysqli_fetch_object($res)) {
		$morpheus[$row->var] = $row->value;
	}

	$betreff 	= textvorlage(38);
	$Empfaenger	= $morpheus["register"];	
	$kundemail 	= $morpheus["email"];
	$name 		= utf8_decode($morpheus["emailname"]); 	

	$betreff_antragsteller 		= textvorlage(38);
	$Empfaenger_antragsteller	= $email;	

    include_once('../inc/send.php');

	// AN DEN PORTALBETREIBER
	$mail_txt .= $morpheus["mail_end"];
	sendMailSMTP($Empfaenger, $betreff, $mail_txt,0);

	// AN DEN ANTRAGSTELLER
	$mail_txt_double_opt_in .= $morpheus["mail_end"];
	sendMailSMTP($Empfaenger_antragsteller, $betreff_antragsteller, utf8_decode($mail_txt_double_opt_in));
}
else echo false;

