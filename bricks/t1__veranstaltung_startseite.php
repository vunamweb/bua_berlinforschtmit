<?php
/* pixel-dusche.de */
global $templCt, $cid, $dir, $monate, $lang, $month, $navID, $lan;


$table = "morp_events";
$tid = "eventid";
$sql = "SELECT * FROM $table WHERE aktiv=1 ORDER BY eventDatum ASC LIMIT 0,1";
$res = safe_query($sql);

$reg_btn = $lang == 1 ? 'Details anzeigen und registrieren' : 'Details and register';
$archive_btn = $lang == 1 ? 'Im Archiv anzeigen' : 'Details in archive';
$month_arr = $lang == 1 ? $monate : $month;
$event_url_id = $lang == 1 ? 2 : 13;
$cid_lan = $lang == 1 ? "cid" : "cidEn";
$x = 0;

while($row = mysqli_fetch_object($res)) {
	$datum = explode("-",$row->eventDatum);
	$tag = $datum[2];
	$monat = intval($datum[1]);
	$jahr = $datum[0];
	$event_id = $row->$cid_lan;
	
	$eventText = $lang == 1 ? $row->eventText : $row->eventTextEn;
	$eventName = $lang == 1 ? $row->eventName : $row->eventNameEn;
	$eventAnzahlTeilnehmer = $row->eventAnzahlTeilnehmer;
	// $eventAnzahlReserviert = $row->eventAnzahlRest;
	
	$sql = "SELECT * FROM `morp_cms_form_auswertung` WHERE event=".$row->eventid." AND register=1";
	$rs = safe_query($sql);
	$eventAnzahlReserviert = mysqli_num_rows($rs);
	
	$full = 0;
	if($eventAnzahlReserviert >= $eventAnzahlTeilnehmer) $full = 1;
	$x++;
		
	$output .= '

<div class="box_content_items event'.($full ? ' overbooked' : '').'">
	<div class="row">
		<div class="col-12 col-md-4 col-lg-3 offset-lg-1">
			<div class="date_box db'.$x.' flag">
				<span class="tag">'.$tag.'</span>
				<span class="monat">'.$month_arr[$monat].'</span>
				<span class="jahr">'.$jahr.'</span>
			</div>
		</div>
		<div class="col-12 col-md-8 col-lg-7 offset-lg-1 wow animate__animated animate__fadeInLeft animate__delay-1s">
			<h2>'.nl2br($eventName).'</h2>
			<p>'.nl2br($eventText).'</p>
			<p><a href="'.$dir.$lan.'/'.$navID[$event_url_id].eliminiere($eventName).'+'.$row->eventid.'/" class="btn btn-info btn-register">'.($full ? $archive_btn : $reg_btn).'</a></p>
		</div>
	</div>
</div>';

}

$morp = "Veranstaltungen / ";
