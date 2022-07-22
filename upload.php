<?php
// print_r($_FILES); //this will print out the received name, temp name, type, size, etc.

// print_r($_REQUEST);
//print_r($_POST);
// print_r($_GET);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$is_check = $_POST["is_check"];
$public = $_POST["public"];
$rubrik = $_POST["rubrik"];
$name = $_POST["name"];
$email = $_POST["email"];

$size = $_FILES['audio_data']['size']; //the size in bytes
$input = $_FILES['audio_data']['tmp_name']; //temporary name that PHP gave to the uploaded file

if($is_check == "false") echo "nopermission // ";

$file = $_FILES['audio_data']['name'].".wav";

$filename = ($is_check ? '' : 'KEINE_FREIGABE_').($rubrik ? 'thema_'.$rubrik.'_' : 'ohne_vorauswahl_').($public=="true" ? 'zum_veroeffentlichen_' : 'privat_').$file;

$output = 'wav/'.$filename; //letting the client control the filename is a rather bad idea

//move the file from temp name to local folder using $output name

// if($is_check == "true") 
move_uploaded_file($input, $output);


include("nogo/config.php");
include("nogo/funktion.inc");
include("nogo/db.php");
dbconnect();

$table 		= 'morp_media';
$tid 		= 'mediaID';
$nameField 	= "mname";
$heute 		= date("Y-m-d");

$sql = "INSERT $table SET $nameField='$filename', email = '$email', name= '$name', rubrik = '$rubrik', mdate='$heute', mtyp='wav', msize='$size', public='$public', dsgvo='$is_check'";
echo $sql;
$res = safe_query($sql);

