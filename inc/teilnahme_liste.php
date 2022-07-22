<?php
global $dir, $cid, $mid, $jsFunc, $navID;

	$output .= '
	<div class="container">
		<div class="col-md-12">

		<h2>Meine Veranstaltungen</h2>
';
	$sql = "SELECT * FROM morp_event_zusage t1, morp_events t2 WHERE t1.eventid=t2.eventid AND mid=$mid ORDER BY eventDatum ASC";
	$res = safe_query($sql);
	$x = mysqli_num_rows($res);

	if($x) {
		$output .= '
		<table  class="table table-hover teilnahme">
			<thead>
			<tr>
				<th>Datum</th>
				<th>Beginn</th>
				<th>Veranstaltung</th>
				<th>Ort</th>
				<th>Anzahl Begleitperson</th>
				<th></th>
			</tr>
			</thead>
		';

		while($row = mysqli_fetch_object($res)) {
			$nm = $row->eventName;
			$da = euro_dat($row->eventDatum);
			$uhr = $row->eventStartZeit;
			$ort = $row->eventOrt;
//
			$output .= '
			<tr>
				<td>'.$da.'</td>
				<td>'.$uhr.'</td>
				<td>'.$nm.'</td>
				<td>'.$ort.'</td>
				<td align="center">'.$row->anzahlBegleitung.'</td>
				<td><a href="'.$dir.'?hn=termine&sn2=gaesteliste&cont=gaesteliste&absage='.$row->eventid.'" class="btn btn-danger"><i class="fa fa-warning"></i> Ich möchte absagen</a></td>
			</tr>
';
		}
		$output .= '</table>';
	}
	else {
		$output .= "<p>Im Moment sind Sie für keine zukünftige Veranstaltung angemeldet</p>";
	}

	$output .= '
		</div>
	</div>
';

?>