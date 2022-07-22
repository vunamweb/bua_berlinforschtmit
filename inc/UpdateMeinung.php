<?php
session_start();

global $mylink;

include("../nogo/config.php");
include("../nogo/funktion.inc");
include("../nogo/db.php");
dbconnect();
include("login.php");


// der erste Wert kommt in data // alle folgenden Werte kommen im Array Z

$deleteAllow = $_SESSION["blogdel"] ? 1 : 0;

$feld = $_POST["feld"];
$table = $_POST["table"];
$id = $_POST["id"];
$delc = $_POST["delc"];

// print_r($_POST);


if(!$deleteAllow) die();

$dat = date("y-m-d");

if($table && $delc && $feld && $id && $deleteAllow) {
	$sql = "DELETE FROM $table WHERE $feld=$id";
	safe_query($sql);
}

?>