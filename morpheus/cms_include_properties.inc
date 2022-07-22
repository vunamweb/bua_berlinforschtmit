<?php
if(!isset($css)) $css='style_light.css';
define('CMS',1);

include "../nogo/config.php";
include "../nogo/config_morpheus.inc";
include "inc/de.php";
include "../nogo/db.php";
if($useUserDB) {
	include("../nogo/db2.php");
	dbconnect2();
}
dbconnect();

include "../nogo/funktion.inc";
