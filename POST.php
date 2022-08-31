<?php
use PHPMailer\PHPMailer\PHPMailer;
require "./inc/mail/PHPMailer.php";
require "./inc/mail/SMTP.php";
require "./inc/mail/Exception.php";

session_start();

// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +

// print_r($_POST);
// $output .= "<h2>FILE UPLOAD</h2>";

if ($_FILES) {		
	$ok = array("jpg", "pdf", "doc", "docx", "rtf", "txt", "jpeg", "zip");
	$int_max_filesize = 15*1024*1024;

	$data = strtolower($_FILES['file']['name']);
	if ($data) {
		$chk = explode(".", $data);
		$c = count($chk);
		$c = $c-1;
		if (!in_array($chk[$c], $ok)) {
			$output .= '<div class="alert alert-dark" role="alert">Wrong FileType</div>';
		}
		else {
			$jetzt = date("Ymdi");
			$str_ziel = './uploads/'.$_POST["E-Mail"].'-'.$jetzt.'-'.$data;
			move_uploaded_file($_FILES['file']['tmp_name'], $str_ziel);
			chmod($str_ziel, 0644);
		}
	}
}

$fid 	= $_POST["fid"];

$query  	= "SELECT * FROM morp_cms_form WHERE fid=".$fid;
$result 	= safe_query($query);
$row 		= mysqli_fetch_object($result);
$formMailAntwort = $row->antwort;
$to			= $row->post;
$subject 	= $row->betreff;
$mailcopy 	= $row->mailcopy;

$output .= '<div class="alert alert-dark" role="alert">'.$formMailAntwort.'</div>';

$query  = "SELECT * FROM morp_cms_form_field WHERE fid=$fid ORDER BY reihenfolge";
$result = safe_query($query);
$mail_txt = $morpheus["mail_start"].'<table>';

while ($row = mysqli_fetch_object($result)) {
	$feld 	= $row->feld;
	$desc 	= $row->desc;
	$art 	= $row->art;
	if($art != "Upload" && $art != "Freitext") $mail_txt .= '<tr><td valign="top"><span class="small">'.utf8_decode($desc).':</span></td><td valign="top"><b>'.utf8_decode(nl2br($_POST[$feld])).'</b></td></tr>';
}
$mail_txt .= '<tr><td>Downloadlink</td><td><a href="'.$dir.substr($str_ziel,2,strlen($str_ziel)).'">'.$dir.substr($str_ziel,2,strlen($str_ziel)).'</a></td></tr>';
$mail_txt .= '</table>'.''.utf8_decode($morpheus["mail_end"]);

sendMailForm($to, $subject, $mail_txt, 0);

if($mailcopy)
	sendMailForm($_POST["email"], $subject, $mail_txt, 0);



// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +

function sendMailForm($to, $subject, $message, $return=1) {
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
		if($return) echo "Mail sent";
	}
	
	// if (!$mail->Send()) {
	// 	$output .= "<p>Mailer Error: Ihre Anfrage konnte <b>nicht</b> gesendet werden</p>";
	// } else {
	// 	$output .= "<p>Mail sent</p>";
	// }
}

