<?php
session_start();

global $mylink;

include("../nogo/config.php");
include("../nogo/config_morpheus.inc");
include("../nogo/funktion.inc");
include("../nogo/db.php");
dbconnect();

// print_r($_POST);


$mid = $_SESSION["mid"];
$pw = $_SESSION["pd"];

$check = get_db_field($mid, 'pw', 'morp_intranet_user', 'mid');

if($pw != $check) die();

// $secure = date("Y")."pixDus".date("m");
// $secure = md5($secure);

// $table 	= $_POST["table"];
// $tid 	= $_POST["tid"];

$table = 'morp_stimmen_media';
$tid 	= 'idstmedia';
$col1 = "stID";
$col2 = "mediaID";
$id 	= $_POST["id"];
$media 	= $_POST["media"];

$sql = "DELETE FROM $table WHERE $col1=$id AND $col2=$media";
safe_query($sql);

