<?php
session_start();

global $mylink;

include("../nogo/config.php");
include("../nogo/config_morpheus.inc");
include("../nogo/db.php");
dbconnect();
include("../nogo/funktion.inc");

$todel = $_POST["todel"];
$table = $_POST["table"];
$tid = $_POST["tid"];

echo $sql  = "DELETE FROM $table WHERE $tid=$todel";
safe_query($sql);

