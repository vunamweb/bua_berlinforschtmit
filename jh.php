<?php

////////////////// TRACKING  // TRACKING  // TRACKING  // TRACKING
$uid = $_GET["uid"];
$nlid = $_GET["nl"];
$il = $_GET["il"];
$el = $_GET["el"];

if ($uid>0 && $nlid) {
	include("nogo/config.php");
	include("nogo/db.php");
	dbconnect();
	$kd = date("Y-m-d");
	if($il) $site = $il;
	else if($el) $site = $el;
	else $site = 'unbekannt';
	
	$sql = "SELECT * FROM morp_newsletter_track WHERE vid='$uid' AND nlid='$nlid' AND site='$site'";
	$res = safe_query($sql);
	if (mysqli_num_rows($res) < 1) {
		$sql = "INSERT morp_newsletter_track set vid='$uid', nlid='$nlid', site='$site', kurzdat='$kd'";
		safe_query($sql);
	}
	
	if($site) header("Location: $site"); 
}