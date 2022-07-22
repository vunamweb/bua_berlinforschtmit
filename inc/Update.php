<?php
session_start();

global $mylink;

include("../nogo/config.php");
include("../nogo/config_morpheus.inc");
include("../nogo/funktion.inc");
include("../nogo/db.php");
dbconnect();
include("login.php");


// der erste Wert kommt in data // alle folgenden Werte kommen im Array Z

$secure = date("Y")."pixDus".date("m");
$secure = md5($secure);

$table 	= $_POST["table"];
$tid 	= $_POST["tid"];
$id 	= $_POST["id"];
$col 	= $_POST["col"];
$data 	= $_POST["data"];
$ins	= $_POST["ins"];
$sec	= $_POST["sec"];

$col2 	= $_POST["col2"];
$data2 	= $_POST["data2"];

$tbl 	= $_POST["tbl"];

$tbl_arr = array(
	1=>"morp_cms_news_confirmed",
);

if($tbl) $table = $tbl_arr[$tbl];

# print_r($_POST);

if($sec != $secure) die();

if($table && $tid && $id && $col && $col2) {
	if($ins) 	$sql = "INSERT $table SET $col='$data', $col2='$data2'";
	else 		$sql = "UPDATE $table SET $col='$data', $col2='$data2' WHERE $tid=$id";
	safe_query($sql);
}
elseif($table && $tid && $id && $col) {
	if($ins) 	$sql = "INSERT $table SET $col='$data'";
	else 		$sql = "UPDATE $table SET $col='$data' WHERE $tid=$id";
	safe_query($sql);
}

# echo $sql;

?>