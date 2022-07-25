<?php
/* pixel-dusche.de */
global $templCt, $cid, $dir;


$table = "morp_events";
$tid = "eventid";
$sql = "SELECT * FROM $table e, morp_event_orte o WHERE o.oid=e.oid ORDER BY eventDatum ASC";
$res = safe_query($sql);
while($row = mysqli_fetch_object($res)) {

	$output .= '

<div class="box_content_items">
	<div class="row">
		<div class="col-12 col-lg-8">
			<h3>'.$row->eventKat.'</h3>
			<h2>'.nl2br($row->eventName).'</h2>
			'.$row->eventText.'
		</div>
		<div class="col-12 col-lg-4">
			<div class="box_content_items_highlight">
				<h2>Termin: '.euro_dat($row->eventDatum).'</h2>
				<h3>Ort:</h3>
				<p>Familienbildung im Heinrich Pesch Haus Frankenthaler Straße 229 67059 Ludwigshafen am Rhein</p>
				<h3>Uhrzeit:</h3>
				<h4>'.$row->eventzusatz.'</h4>
				<h3>Kosten:</h3>
				<h4>'.$row->preis.'</h4>
				<h3>Anmeldung:</h3>
				<p><a href="mailto:info@beziehungspunkte.de" class="btn-link">'.($row->event_zusage ? $row->event_zusage : 'info@beziehungspunkte.de').'?'.$row->anmeldung.'</a></p>
			</div>
		</div>
	</div>
</div>';

}

$morp = "Veranstaltungen / ";
