<?php
include_once("../mpdf.php");
include_once("../nogo/config.php");
include_once("../nogo/funktion.inc");
include_once("../nogo/db.php");
dbconnect();
include("send.php");

// $ROOT_PATH = dirname(__FILE__) ;

$dir = $morpheus["url"];
$gestern = date("Y-m-d", strtotime( $d . " -1 days"));
$heute = date("Y-m-d");

$paID = $_POST["id"];

if(!$paID) die("Keine Mail gesendet - Fehler - 999");

$betreff = "ECONECT / Ihre Prüferprotokolle";
	
$sql = "SELECT SID, email FROM prueferprofil_anforderung WHERE paID=$paID";
$res = safe_query($sql); 
$row = mysqli_fetch_object($res);

//$Empfaenger = "vukynamkhtn@gmail.com"; //$row->email;
$Empfaenger = "post@pixel-dusche.de";

$mail_txt = $morpheus["mail_start"].'<tr><td>
	<p>
	<br><br>
	Wir haben den Zugang zu Ihren persönlichen Prüferprotokollen frei geschaltet.
	<br><br>
	<a href="'.$dir.'myportal/?me='.$row->SID.'">'.$dir.'myportal/?me='.$row->SID.'</a>
	<br><br>
	Ihre ECONECT
	<br><br>
	</p>
	</td></tr>'.$morpheus["mail_end"];
	
sendMailSMTP($Empfaenger, utf8_decode($betreff), utf8_decode($mail_txt));

