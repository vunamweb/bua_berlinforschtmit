<?php
global $files, $dir, $testmail, $navID;

error_reporting(0);

$testmail = 1;

$db = "morp_newsletter_cont";
$id = "nlid";
$nlid = $_GET["nlid"];

include("nogo/config.php");
include("nogo/navID_de.inc");
include("nogo/funktion.inc");
include("nogo/db.php");
include("morpheus/newsletter/function.php");
dbconnect();

$dir = $morpheus["url"];
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// SETTINGS KUNDEN LADEN
// $sql = "SELECT * FROM morp_settings WHERE 1";
// $res = safe_query($sql);
// while($row = mysqli_fetch_object($res)) {
// 	$morpheus[$row->var] = $row->value;
// }
 
# print_r($morpheus);

$sql = "SELECT * FROM morp_newsletter_cont WHERE $id=".$nlid." ORDER BY nlsort";
$res = safe_query($sql);

/* * * * *  VAR * * * * */
$getHTML = '';

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
/* * * * * * GRUNDEINSTELLUNGEN Mailing * * * * * * * * * */
$sql = "SELECT nlart, nlpreheader, nlname FROM morp_newsletter WHERE nlid=".$nlid;
$rs = safe_query($sql);
$rw = mysqli_fetch_object($rs);

/* * * * get Content of Mailing * * * * */

$container = getContMailing($res, $nlid);
$file = "design";
$preheader = $rw->nlpreheader;

$raus = array('/#here_comes_the_message#/', '/#preheader#/', '/#inhalt#/', '/#spacer#/', '/#uid#/', '/#nlid#/');
$rein = array($container, $preheader, $nav, '', '9999', $nlid);

# print_r($raus);
# print_r($rein);
// $txt = preg_replace($raus, $rein, $row->text);
# $text = read_data("text.txt");
/******* _____ PLATZHALTER ******************************/
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

$data = create_html_doc($row->text, $nlid, $file);

echo $data = preg_replace($raus, $rein, $data);
