<?php
/*
UploadiFive
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
*/

include("../nogo/config.php");
include("../nogo/funktion.inc");
include("../nogo/db.php");
dbconnect();

$idMedia = $_POST['id'];

$verifyToken = md5('pixeld' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile   = $_FILES['Filedata']['tmp_name'];
#	$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;
#	$uploadDir  = $uploadDir;

	if(strpos($fileName, '.wav'))
	  $uploadDir = '../wav/';
	else 
	  $uploadDir = '../mp3/';

	echo $targetFile = $uploadDir . $_FILES['Filedata']['name'];

	$fileName = $_FILES['Filedata']['name'];
	  
	if(!move_uploaded_file($tempFile, $targetFile))
	  echo ":(";
	else {
		echo 'ok';
		chmod($targetFile, 0777); 
		UpdateMedia($fileName, $idMedia);
	} 
}

function UpdateMedia($fileName, $idMedia) {
	if(strpos($fileName, '.wav'))
	   $sql = "UPDATE `morp_media` SET mname = '$fileName', mp3 = '' WHERE mediaID = $idMedia";
	else
	   $sql = "UPDATE `morp_media` SET mp3 = '$fileName', mname = '' WHERE mediaID = $idMedia";
	         
    echo '////' . $sql;
	safe_query($sql);
}

?>