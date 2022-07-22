<?php

global $dir, $navID, $SID, $acceptCookie, $morpheus;

// print_r($_POST);

$newpass = isset($_POST["newpass"]) ? 1 : 0;
$uname = isset($_POST["uname"]) ? $_POST["uname"] : '';
// $em = isset($_POST["mail"]) ? $_POST["mail"] : '';

$nolog = 1;
$warn = '';

if($newpass && $uname) {
	$pruefe = email_check($uname);
	if($pruefe) {
		// $sql = "SELECT mid FROM `morp_intranet_user` WHERE uname='$uname' AND `email`='$em'";
		// $sql = "SELECT mid FROM `morp_intranet_user` WHERE uname='$uname' AND `email`='$uname' AND optin=1 AND isallowed=1";
		$sql = "SELECT mid FROM `morp_intranet_user` WHERE uname='$uname' AND optin=1 AND isallowed=1";
		$res = safe_query($sql);
		$x = mysqli_num_rows($res);

		if($x > 0) {
			$nolog = 0;
			$row = mysqli_fetch_object($res);
			// echo " YOU ARE IN !!!!";

			$md5 = md5("Stift".$uname."-".date("Ymd"));
			$sql = "UPDATE `morp_intranet_user` SET secure='".$md5."' WHERE `mid`=".$row->mid;
			$res = safe_query($sql);
			if($res) {
				$output = textvorlage(41);
				include_once('inc/send.php');
				// $mailto = $em;

				$mailsubject = textvorlage(42)." ".$morpheus["emailname"];
				$mailbody .= textvorlage(43)."<br/><br/>".$dir."?aktivierung=".$md5."&reset=1\n\n".utf8_decode(strip_tags(trim($footer)));
				$mail_txt .= $morpheus["mail_start"].$mailbody.$morpheus["mail_end"];
				
				sendMailSMTP($uname, $mailsubject, $mail_txt, 0);
			}

		}
		else $output = '<div class="alert alert-danger" role="alert">'.textvorlage(44).'</div><p>&nbsp;</p>';
	}
	else $warn = '<div class="alert alert-danger" role="alert">'.textvorlage(45).'</div><p>&nbsp;</p>';
}
elseif($dat || $un || $em) { $warn = '<h2>'.textvorlage(46).'</h2>'; }

if($nolog) {
	$output .= getform($uname, $em);
}


$output = $warn.$output;

