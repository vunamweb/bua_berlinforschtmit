<?php
session_start();
/*
UploadiFive
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
*/

include("../nogo/config.php");
include("../nogo/funktion.inc");
include("../nogo/db.php");
dbconnect();

// print_r($_POST);

$uploadDir 	= $_POST["dir"];
$table 		= $_POST["table"];
$tid 		= $_POST["tid"];
$id 			= $_POST["id"];
$imgrow 		= $_POST["imgrow"];
$imgSize		= $_POST["imgSize"];
$mid			= $_POST["mid"];

$chkmid = $_SESSION["mid"];

if($mid != $chkmid) die();

// Set the allowed file extensions
// $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Allowed file extensions

$imgTypes = array('jpg', 'jpeg', 'png'); // Allowed file extensions
$docFiles = array("gif", "svg");

$fileTypes = array_merge($imgTypes, $docFiles);

$verifyToken = md5('pixeld' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile   	= $_FILES['Filedata']['tmp_name'];
	$file 		=   $mid.'_'.eliminiereIMG($_FILES['Filedata']['name']);

	// copy orginal in subfolder "org"
	$targetFile 	= $uploadDir.'org/'.$file;

	$filesize = filesize($tempFile);
	$filetime = date ("Y-m-d", filectime($tempFile));

	$fileParts = pathinfo($_FILES['Filedata']['name']);
	if (in_array(strtolower($fileParts['extension']), $fileTypes)) {
		// makeImage($tempFile, $uploadDir, $imgSize, 0);

		if(!move_uploaded_file($tempFile, $targetFile)) echo ":(";

		// echo $fileParts['extension'];
		$jpgFile = str_replace('.'.$fileParts['extension'], '.jpg', $file);
		setData ($jpgFile, $table, $tid, $id, $imgrow);

		// resize image
		// echo "$targetFile \n $uploadDir \n $imgSize \n";
		makeImage($targetFile, $uploadDir, $imgSize, 0);

		echo "finish";
	} else {
		echo 'Invalid file type.';

	}
}


function setdata ($file ,$table, $tid, $id, $imgrow) {
	echo $sql = "UPDATE `$table` SET $imgrow='$file' WHERE $tid=$id";
	safe_query($sql);
}

?>