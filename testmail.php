<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<head>
	<title>content-management-system - pixel-dusche.de, pixeldusche.com</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link rel="stylesheet" type="text/css" href="morpheus/css/font-awesome.min.css">
	<link rel="stylesheet" href="morpheus/css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="morpheus/css/style_light.css" type="text/css">
</head>
<body >
	<div class="brand-name-wrapper">
    	<a class="navbar-brand" href="morpheus/index.php">
        	<img src="morpheus/images/Logo-Morpheus.svg" class="logo" alt="">
    	</a>
	</div>
	
	<div class="container">
		<div class="row">
			<div class="col-md-12 mt4 text-center">
				<h1>Mail Versand</h1>
			</div>
		</div>
	</div>
	
<?php
global $files, $dir, $testmail, $navID;

$testmail = 1;

$db = "morp_newsletter_cont";
$id = "nlid";
$nlid = $_GET["nlid"];
$verteiler = $_GET["verteiler"];

include("nogo/config.php");
include("nogo/navID_de.inc");
include("nogo/funktion.inc");
include("nogo/db.php");
include("morpheus/newsletter/function.php");
dbconnect();

$dir = $morpheus["url"];
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


// echo $verteiler;


	$sql = "SELECT * FROM morp_newsletter_cont WHERE $id=".$nlid." ORDER BY nlsort";
	$res = safe_query($sql);
	
	/* * * * *  VAR * * * * */
	$getHTML = '';
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


	/* * * * * * GRUNDEINSTELLUNGEN Mailing * * * * * * * * * */
	$sql = "SELECT nlart, nlpreheader, nlname, nlsubj FROM morp_newsletter WHERE nlid=".$nlid;
	$rs = safe_query($sql);
	$rw = mysqli_fetch_object($rs);

	/* * * * get Content of Mailing * * * * */
	$container = getContMailing($res, $nlid);
	$file = "design";
	$preheader = $rw->nlpreheader;
	$ct = strlen($preheader);
	$leer = '';
	for($i=$ct; $i<=125; $i++) {
		$leer .= ' &nbsp;';
	}
	$Betreff 	= $rw->nlsubj;

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	/****** PLATZHALTER ******************************/
	// $platzhalter = $row->platzhalter;
	// $platzhalter = explode(",", $platzhalter);

	$raus = array('/#here_comes_the_message#/', '/#preheader#/', '/#title#/');
	$rein = array($container, $preheader, $Betreff);

	// foreach($platzhalter as $val) {
	// 	$val = trim($val);
	// 	if($val) {
	// 		$rein[] = $verteiler[$val];
	// 		$raus[] = '/#'.$val.'#/';
	// 	}
	// }

	// 	$raus[] = "/\"img\/cta.png\"/";
	// 	$rein[] = '"'.$dir.'img/cta.png"';
	// 
	// 	$raus[] = "/\"img\/cta.png\"/";
	// 	$rein[] = '"'.$dir.'img/cta.png"';
	// 
	// 	$raus[] = "/#weblink#/";
	// 	$rein[] = 'http://www.apothekerkammer.de/service/lak+aktuell/lak+aktuell+ausgabe-'.$nlid.'-prev/';
	// 
	// 	$raus[] = "/#spacer#/";
	// 	$rein[] = '';


	$data = create_html_doc($row->text, $nlid, $file);
	$data = preg_replace($raus, $rein, $data);
	$pure = preg_replace($raus, $rein, $row->text);

if($verteiler == "live1") {
		echo '
	
	<p style="text-align:center; margin: 50px auto;">
			
		<a href="?verteiler=live&nlid='.$nlid.'" class="btn btn-success" style="background:yellow;color:red !important;font-weight:600;padding:20px 60px;">Den LIVE Versand starten !!!</b></a>
	
	</p>
	
	<hr></hr>
	';
	
	
	echo $data;
}
else if($verteiler) {
	// print_r($verteiler);
	include("page/sendMailSMTP.php");
	$jetzt = date("Y-m-d");
	$table = $verteiler == "live" ? "morp_newsletter_vt_liveXXX" : "morp_newsletter_vt";
	$sql = "SELECT * FROM $table WHERE 1";
	$res = safe_query($sql);
	
	echo "Start Versand an:<br><br>";
	
	while($row = mysqli_fetch_object($res)) {
		echo $to = $row->email;
		$vid = $row->vid;
		echo "<br>";
		
		if($verteiler == "live") {
			$sql_track = "INSERT morp_newsletter_vt_track SET email='$to', nlid=$nlid, vdat='$jetzt', vid=$vid";
			$res_track = safe_query($sql_track);
		}
		
		// $anrede = $row->anrede;
		// $Empfaenger = 'post@pixel-dusche.de';
		#include("morp_edm/newsletter/mail.php");
		$raus = array('/#uid#/', '/#nlid#/');
		$rein = array($row->vid, $nlid);
		$send_data = preg_replace($raus, $rein, $data);
		sendMailSMTP($to, utf8_decode($Betreff), utf8_decode($send_data), 0);
	}

	echo '<br> # # # # # # END MAILING # # # # # #<br><br><br>';
	echo $data;

}
else {
	
	echo '
	
	<p style="text-align:center; margin: 50px auto;">
	
		<a href="?verteiler=test&nlid='.$nlid.'" class="btn btn-info">Start <b>Testmail</b></a>
		
		<br/>
		<br/>
		<br/>
		<br/>
		
		<a href="?verteiler=live1&nlid='.$nlid.'" class="btn btn-danger">Start <b>Versand LIVE</b></a>
	
	</p>
	
	<hr></hr>
	';
	
	
	echo $data;
}