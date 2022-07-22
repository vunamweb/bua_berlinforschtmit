<?php
// session_start();
// print_r($_SESSION);
// print_r($_POST);
include("nogo/funktion.inc");
include("nogo/config.php");
include("nogo/db.php");
dbconnect();

$token = md5("pixeldusche".date("ymd"));

$pwA = isset($_POST["pw1"]) ? $_POST["pw1"] : '';
$pwB = isset($_POST["pw2"]) ? $_POST["pw2"] : '';
$sec = isset($_POST["sec"]) ? $_POST["sec"] : '';
$pruefe = isset($_POST["mystring"]) ? $_POST["mystring"] : '';
$min  = isset($_POST["min"]) ? $_POST["min"] : 6;

if($pruefe==$token) {
	if(($pwA || $pwB)) {
		// $mid = holeID($sec);
		if($pwA != $pwB) echo textvorlage(53);
		elseif(strlen($pwA) < $min) echo str_replace('#MIN#', $min, textvorlage(54));
		else {
			$zahl = 0;
			$zeichen = 0;
			if(preg_match("/\d/", $pwA)) $zahl = 1;
			if(preg_match("/[a-zA-Z]/", $pwA)) $zeichen = 1;
			
			if(!$zahl) 			echo textvorlage(55);
			elseif(!$zeichen) 	echo textvorlage(56);
			elseif($sec) {
				$sql = "UPDATE `morp_intranet_user` SET kontrolle='1', secure='', pw='".md5($pwA)."', newpass=0 WHERE secure='".$sec."'";
				$res = safe_query($sql);
				// echo  textvorlage(57);newpwsuccess
				echo "newpwsuccess";
				$_SESSION["pd"] = md5($pwA);
			}
			else echo "FEHLER";
		}
	}
}
