<?php
use PHPMailer\PHPMailer\PHPMailer;
require $_SERVER['DOCUMENT_ROOT'] . $morpheus['subFolder'] ."inc/mail/PHPMailer.php";
require $_SERVER['DOCUMENT_ROOT'] . $morpheus['subFolder'] . "inc/mail/SMTP.php";
require $_SERVER['DOCUMENT_ROOT'] . $morpheus['subFolder'] . "inc/mail/Exception.php";


function sendMailSMTP($to, $subject, $message, $return=1) {
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
}