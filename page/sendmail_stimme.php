<?php
session_start();
/**
* Filename.......: sendmail
* Author........: pixel-dusche - Bjorn
* Last Modified..: 2022-07-14
*/

//	print_r($_POST);

include("../nogo/config.php");
$pixel = isset($_POST["pixel"]) ? $_POST["pixel"] : 0;
$checkit = isset($_SESSION['evC']) ? $_SESSION['evC'] : '';
$send = 1;

global $morpheus;

// if ($checkit) {
// 	$checkit = explode("-", $checkit);
// 	$checkit = $checkit[1];
// 	$send = $pixel == $checkit ? 1 : 0;
// }

$checkMySec = md5("pd?x".date("ymd"));
$sec = isset($_POST["mystring"]) ? $_POST["mystring"] : 0;

$data = json_decode($_POST['data'],true);

$fid = $data[0];
$fid = $fid["value"];

$x = count($data);
include("../nogo/funktion.inc");

$mail_start = $morpheus["mail_start"].utf8_decode('<h1>Ihre Stimme</h1><p>&nbsp;</p><p>&nbsp;</p><table>');
// $sql = "INSERT morp_cms_form_auswertung SET ";
$sql = "INSERT morp_media SET ";

$customer_mail = '';
$mail_content = '';

for($i=0; $i<($x-1); $i++) {
	if($data[$i]["name"]=="stimme") $stimme = $data[$i]["value"];
	else if($data[$i]["name"]=="public_stimme") $public = $data[$i]["value"];
	else if($data[$i]["name"]=="infos") $infos = $data[$i]["value"];
	else if($data[$i]["name"]=="Name") $name = $data[$i]["value"];
	else if($data[$i]["name"]=="E-Mail") $email = $data[$i]["value"];

	if($data[$i]["name"]!="fid" && $data[$i]["name"]!="myid") {
		$mail_content .= '<tr><td valign="top"><b>'.ucfirst(utf8_decode($data[$i]["name"])).'</b> &nbsp; &nbsp; </td><td valign="top">'.utf8_decode(nl2br($data[$i]["value"])).'</td></tr>';
		// $sql .= " `".$data[$i]["name"]."`='".$data[$i]["value"]."',";
	}
	
	if(isin("mail", $data[$i]["name"])) $customer_mail = trim($data[$i]["value"]);
}

$mail_txt = $mail_start.$mail_content.'</table>'.utf8_decode($morpheus["mail_end"]);

	include("../nogo/db.php");
	dbconnect();
		
	$sql .= " mname='NO FILE ".date("Y-m-d H:i:s")."', text='$stimme', name='$name', email='$email', dsgvo='true', infos=".($infos ? 1 : 0).", public='".($public ? 'true' : 'false')."'";

// echo $mail_txt;
// echo "$sec && ($sec == $checkMySec) && $send ";
// echo $sql;

// echo "$sec == $checkMySec";

if( $sec && ($sec == $checkMySec) && $send ) {
	
	// in Auswertung speichern
	$res = safe_query($sql);
	
	$sql = "SELECT * FROM morp_settings WHERE 1";
	$res = safe_query($sql);
	while($row = mysqli_fetch_object($res)) {
		$morpheus[$row->var] = $row->value;
	}
	$mail_txt .= utf8_decode($morpheus["mail_end"]);
	
	$query  	= "SELECT * FROM morp_cms_form WHERE fid=".$fid;
	$result 	= safe_query($query);
	$row 		= mysqli_fetch_object($result);
	
	//$Empfaenger = $row->post;
	//$Empfaenger	= 'b@7sc.eu';
	$Empfaenger = 'vukynamkhtn@gmail.com';
	
	$betreff 	= $row->betreff;	
	$kundemail 	= $morpheus["email"];
	$name 		= utf8_decode($morpheus["emailname"]); 	

	include_once('../inc/send.php');
	
	sendMailSMTP($Empfaenger, $betreff, $mail_txt, 1);
}
else echo false;

