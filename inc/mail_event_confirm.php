<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

include_once("../mpdf.php");
include_once("../nogo/config.php");
include_once("../nogo/funktion.inc");
include_once("../nogo/db.php");
dbconnect();
include("send.php");

// $ROOT_PATH = dirname(__FILE__) ;

$dir = $morpheus["url"];
$gestern = date("Y-m-d", strtotime( $d . " -1 days"));
$heute = date("Y-m-d");

$id = $_POST["id"];
$confirm = $_POST["confirm"];

$betreff = "BUA / Confirm Event";

$seperate = "-----";

$nameUser = '';

$headerMail = $morpheus["mail_start"];
$footerMail = $morpheus["mail_end"];

$mail_txt_confirm_yes = '
Dear {name}

event {event} has approved

You can cancel the event by clicking link below
';
$mail_txt_confirm_no = '
Dear {name}

event {event} has not approved
';

$sql = "select * from morp_cms_form_auswertung t1, morp_events t2 where t1.event = t2.eventid and t1.aid = ". $id ."";

//echo $sql; die();

$res = safe_query($sql); 
$row = mysqli_fetch_object($res);

//$number = mysqli_num_rows($res);

//if($number > 0) {
    $nameUser = $row->name;

    $textConfirm = $row->event_mail_confirm;
    $textConfirm = explode($seperate, $textConfirm);

    $mail_txt_confirm_yes = $textConfirm[0];
    $mail_txt_confirm_no = $textConfirm[1];
//}

//$Empfaenger = $row->E-Mail;
//$Empfaenger = "vukynamkhtn@gmail.com";
$Empfaenger = "post@pixel-dusche.de";

$linkEvent = '<a href="'.$dir.'event/'.($row->aid).'">'.($row->eventName).'</a>';
$linkCancelEvent = '<a href="'.$dir.'?cancelEvent='.($row->aid).'">Cancel Event</a>';

$mail_txt = ($confirm) ? $mail_txt_confirm_yes : $mail_txt_confirm_no;
$mail_txt = str_replace("{name}", $nameUser, $mail_txt);
$mail_txt = str_replace("{event}", $linkEvent, $mail_txt);

// if contains cancel link, then add it
if($confirm)
  $mail_txt .= $linkCancelEvent;

$mail_txt_send = $headerMail . $mail_txt . $footerMail;
//echo $mail_txt_send; die();

sendMailSMTP($Empfaenger, utf8_decode($betreff), utf8_decode($mail_txt_send));

