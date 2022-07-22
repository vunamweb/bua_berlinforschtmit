<?php
session_start();
/**
* Filename.......: example.1.php
* Project........: HTML Mime Mail class
* Last Modified..: 15 July 2002
*/

//  error_reporting(E_ALL);
//	print_r($_POST);

include("../nogo/config.php");


$pixel = isset($_POST["pixel"]) ? $_POST["pixel"] : 0;
$checkit = isset($_SESSION['evC']) ? $_SESSION['evC'] : '';
$send = 1;

// if ($checkit) {
// 	$checkit = explode("-", $checkit);
// 	$checkit = $checkit[1];
// 	$send = $pixel == $checkit ? 1 : 0;
// }

$checkMySec = md5("pixeldusche".date("ymd"));
$sec = isset($_POST["mystring"]) ? $_POST["mystring"] : 0;

$data = json_decode($_POST['data'],true);

$fid = $data[0];
$fid = $fid["value"];

$x = count($data);
include("../nogo/funktion.inc");

$mail_start = $morpheus["mail_start"].utf8_decode('<h1>Registrierung / Registration</h1><p>&nbsp;</p><p>Ein Teilnehmer hat sich registriert. Bitte prüfen und ggf. freischalten.</p><p>&nbsp;</p><table>');
$mail_start_copy = $morpheus["mail_start"].'<h1>Registrierungs Informationen / Registration Information</h1><p>&nbsp;</p>#txt#<table>';
$mail_content = '#start#';

$sql = "INSERT morp_cms_form_auswertung SET ";

$customer_mail = '';

for($i=0; $i<($x-1); $i++) {
	if($data[$i]["name"]=="rest") $rest = $data[$i]["value"];
	else if($data[$i]["name"]=="myid") $mid = $data[$i]["value"];
	else if($data[$i]["name"]=="fid") $fid = $data[$i]["value"];
	else if($data[$i]["name"]=="sum") $max = $data[$i]["value"];
	else if($data[$i]["name"]=="lang") $language = $data[$i]["value"];
	else if($data[$i]["name"]=="event_zusage") $event_zusage = $data[$i]["value"];
	else if($data[$i]["name"]=="eventid") {
		$eventid = $data[$i]["value"];
	}
	else {
		$mail_content .= '<tr><td valign="top"><b>'.ucfirst(utf8_decode($data[$i]["name"])).'</b> &nbsp; &nbsp; </td><td valign="top">'.utf8_decode(nl2br($data[$i]["value"])).'</td></tr>';
		$sql .= " `".$data[$i]["name"]."`='".$data[$i]["value"]."',";
	}

	// if($data[$i]["name"]=="eventName") $eventName = $data[$i]["value"];

	if(isin("mail", $data[$i]["name"])) $customer_mail = trim($data[$i]["value"]);

}

$mail_txt = $mail_start.$mail_content.'</table>'.utf8_decode($morpheus["mail_end"]);

	include("../nogo/db.php");
	dbconnect();
	
$sql_event = "SELECT * FROM morp_events WHERE eventid=$eventid";
$rs = safe_query($sql_event);
$rw = mysqli_fetch_object($rs);
$description = $language == "de" ? 'event_reg_text1' : 'event_reg_text1En';	
$eventname = $language == "de" ? 'eventName' : 'eventNameEn';
$eventName = $rw->$eventname;

$details = '
	<tr>
		<td><b>'.($language == "de" ? "Veranstaltung" : "Event").'</b></td>
		<td>'.$eventName.'</td>
	</tr>
	<tr>
		<td><b>'.($language == "de" ? "Datum" : "Date").'</b></td>
		<td>'.euro_dat($rw->eventDatum).'</td>
	</tr>
	<tr>
		<td></td>
		<td>'.nl2br($rw->$description).'</td>
	</tr>

';	
	
		
$sql .= " register=1, event=$eventid, mid=$mid";

// echo $mail_txt;
// echo "$sec && ($sec == $checkMySec) && $send ";
// echo $sql;

if( $sec && ($sec == $checkMySec) && $send ) {
	
	// in Auswertung speichern
	$res = safe_query($sql);
	
	$sql = "SELECT * FROM morp_settings WHERE 1";
	$res = safe_query($sql);
	while($row = mysqli_fetch_object($res)) {
		$morpheus[$row->var] = $row->value;
	}
	$mail_txt .= utf8_decode($morpheus["mailfooter"]);
	$mail_client = 'mail_client_'.$language;
	$mail_client_text = utf8_decode($morpheus[$mail_client]);
	
	$mail_txt = str_replace("#start#", $details, $mail_txt);
	
	$query  	= "SELECT * FROM morp_cms_form WHERE fid=".$fid;
	$result 	= safe_query($query);
	$row 		= mysqli_fetch_object($result);
	
	$Empfaenger = $row->post;
	$Empfaenger	= $event_zusage;
	$Empfaenger	= 'b@7sc.eu';
	$betreff 	= $row->betreff.' / '.str_replace("\n", "", $eventName);
	
	$kundemail 	= $morpheus["email"];
	// $kundemail 	= "post@pixel-dusche.de";
	$name 		= utf8_decode($morpheus["emailname"]); 	

    include_once('inc/send.php');

	sendMailSMTP($Empfaenger, $betreff, $mail_txt, 0);
	
		// KOPIE DER MAIL

		$Empfaenger = $customer_mail;
		$mail_txt = $mail_start_copy.$mail_content.'</table>';
		$mail_txt .= utf8_decode($morpheus["mail_end"]);
		$mail_txt = str_replace("#txt#", $mail_client_text, $mail_txt);
		$mail_txt = str_replace("#start#", $details, $mail_txt);

	sendMailSMTP($Empfaenger, $betreff, $mail_txt, 1);

			
			$sql = "SELECT eventAnzahlRest FROM morp_events WHERE eventid=$eventid";
			$res = safe_query($sql);
			$row = mysqli_fetch_object($res);
			$value = $row->eventAnzahlRest;
			$value++;
			$sql = "UPDATE morp_events SET eventAnzahlRest=$value WHERE eventid=$eventid";
			$res = safe_query($sql);

			// echo 'Mail xxxxx sent';

}
else echo false;

