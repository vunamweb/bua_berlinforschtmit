<?php
use PHPMailer\PHPMailer\PHPMailer;
require "PHPMailer.php";
require "SMTP.php";
require "Exception.php";

session_start();

//  error_reporting(E_ALL);
//	print_r($_POST);

$pixel = isset($_POST["pixel"]) ? $_POST["pixel"] : 0;
$checkit = isset($_SESSION['evC']) ? $_SESSION['evC'] : '';
$send = 1;

include("../nogo/funktion.inc");
include("../nogo/config.php");

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

$x = count($data);
$mail_txt = $morpheus["mail_start"];

for($i=1; $i<($x); $i++) {
	if(isin('datenschutz',$data[$i]["name"]))
		$mail_txt .= '';
	
	else if(isin('cb_',$data[$i]["name"]))
		$mail_txt .= '<tr><td colspan="2">'.str_replace("_", " ", $data[$i]["value"]).'</td></tr>';
		
	else
		$mail_txt .= '<tr><td valign="top"><span class="small">'.utf8_decode($data[$i]["name"]).':</span></td><td valign="top"><b>'.utf8_decode(nl2br($data[$i]["value"])).'</b></td></tr>';

}
$mail_txt .= ''.utf8_decode($morpheus["mail_end"]);

// echo($mail_txt);

if( $sec && ($sec == $checkMySec) && $send ) {
	include("../nogo/db.php");
	dbconnect();

	$sql = "SELECT * FROM morp_settings WHERE 1";
	$res = safe_query($sql);
	while($row = mysqli_fetch_object($res)) {
		$morpheus[$row->var] = $row->value;
	}

	$query  	= "SELECT * FROM morp_cms_form WHERE fid=".$fid;
	$result 	= safe_query($query);
	$row 		= mysqli_fetch_object($result);
	$betreff 	= $row->betreff;
	$Empfaenger = $row->post;
	// $Empfaenger	= "post@pixel-dusche.de";
	$kundemail 	= $morpheus["email"];
	$name 		= $morpheus["emailname"]; 
	// $kundemail	= "post@pixel-dusche.de";

	sendMailSMTP($Empfaenger, $betreff, $mail_txt);
}
else echo false;



function sendMailSMTP($to, $subject, $message) {
	global $morpheus;
	
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0; 	// enables SMTP debug information (for testing)
    						// 1 = errors and messages
    						// 2 = messages only
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = "ssl";
    $mail->Host = $morpheus["Host"]; 
    $mail->Port = $morpheus["Port"];
    $mail->Username = $morpheus["Username"];
    $mail->Password = $morpheus["Password"];
    // $mail->addBcc("post@pixel-dusche.de");
    $mail->AddAddress($to);
    $mail->Subject = $subject;
    $mail->FromName = $morpheus["FromName"];
    $mail->From = $morpheus["From"];
    $mail->IsHTML(true);
    $mail->Body = $message;

    if (!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Mail sent";
    }
}