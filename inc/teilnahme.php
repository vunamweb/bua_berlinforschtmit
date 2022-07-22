<?php
global $dir, $cid, $mid, $jsFunc, $navID;

$event = $_GET["event"] ? $_GET["event"] : 0;
$absage = $_GET["absage"] ? $_GET["absage"] : 0;
$eventid = $_POST["eventid"] ? $_POST["eventid"] : 0;

/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

if($eventid) {
	$output .= '
	<div class="container">
		<div class="col-md-12">
';

	$sql = "SELECT * FROM morp_event_zusage WHERE eventid=$eventid AND mid=$mid";
	$res = safe_query($sql);
	$x = mysqli_num_rows($res);

	// print_r($_POST);

	if($x > 0 ) {
		$output .= '<div class="alert alert-danger" role="alert"><i class="fa fa-warning"></i> Sie haben sich bereits für diese Veranstaltung angemeldet</div>
			<p>
				<a href="'.$dir.'?hn=termine&sn2=gaesteliste&cont=gaesteliste&absage='.$eventid.'" class="btn btn-danger"><i class="fa fa-warning"></i> Ich möchte absagen</a><br><br>
			</p>
			';

	}
	else {
		$ichnehmeteil = $_POST["ichnehmeteil"] ? 1 : 0;
		$anzahl = $_POST["anzahl"] ? $_POST["anzahl"] : 0;
		$datum = date("Y-m-d");

		if($ichnehmeteil) {
			$sql = "INSERT morp_event_zusage SET eventid=$eventid , mid=$mid , anzahlBegleitung=$anzahl , datumZusage='$datum'";
			safe_query($sql);

			$output .= '<div class="alert alert-success" role="alert"><i class="fa fa-warning"></i> Vielen Dank für Ihre Zusage</div>
			';
		}
		elseif(!$ichnehmeteil) {
			$output .= '<div class="alert alert-danger" role="alert"><i class="fa fa-warning"></i> Die Zusage konnte nicht angenommen werden</div>
			';
		}

	}


	$output .= '
			<p>
				<a href="'.$dir.$navID[3].'" class="btn btn-info"><i class="fa fa-chevron-right"></i> Zu den Terminen</a>
				<a href="'.$dir.'" class="btn btn-info"><i class="fa fa-chevron-right"></i> Zur Startseite</a>
			</p>

		</div>
	</div>
';
}

/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

elseif($absage) {
	$output .= '
	<div class="container">
		<div class="col-md-12">
';

	$sql = "SELECT * FROM morp_events WHERE eventid=$absage";
	$res = safe_query($sql);
	$row = mysqli_fetch_object($res);

	$nm = $row->eventName;
	$da = euro_dat($row->eventDatum);
	$uhr = $row->eventStartZeit;
	$ort = $row->eventOrt;

	$sql = "SELECT * FROM morp_event_zusage WHERE eventid=$absage AND mid=$mid";
	$res = safe_query($sql);
	$x = mysqli_num_rows($res);

	$confirmed = $_GET["confirm"] ? $_GET["confirm"] : 0;

	// print_r($_POST);

	if($x > 0 && ($confirmed == $absage)) {
		$output .= '<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> Ihre Abmeldung war erfolgreich.</div>';

		$sql = "DELETE FROM morp_event_zusage WHERE eventid=$absage AND mid=$mid";
		safe_query($sql);

	}
	elseif($x > 0 ) {
		$output .= '<div class="alert alert-danger" role="alert"><i class="fa fa-warning"></i> Ich melde mich für die Veranstaltung '.$nm.' am '.$da.' in '.$ort.' ab.</div>
			<p>
				<a href="'.$dir.'?hn=termine&sn2=gaesteliste&cont=gaesteliste&absage='.$absage.'&confirm='.$absage.'" class="btn btn-success"><i class="fa fa-check"></i> Verbindlich absagen</a><br><br><br><br>
			</p>
			';
	}
	else {
		$output .= '<div class="alert alert-danger" role="alert"><i class="fa fa-warning"></i> Sie sind für die Veranstaltung "<b>'.$nm.'</b>" am '.$da.' in '.$ort.' <b>nicht angemeldet</b>.</div>
			';
	}


	$output .= '
			<p>
				<a href="'.$dir.$navID[3].'" class="btn btn-info"><i class="fa fa-chevron-right"></i> Zu den Terminen</a>
				<a href="'.$dir.'" class="btn btn-info"><i class="fa fa-chevron-right"></i> Zur Startseite</a>
			</p>

		</div>
	</div>
';
}

/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

elseif($event) {
	$output .= '
	<div class="container">
		<div class="col-md-6">
';

	$sql = "SELECT * FROM morp_events WHERE eventid=$event";
	$res = safe_query($sql);
	$row = mysqli_fetch_object($res);

	$output .= '

			<h2>Teilnahme an der Veranstaltung<br>'.$row->eventName.'</h2>
			<p class="mb2">'.nl2br($row->eventText).'</p>
			<p>
				Datum: <b>'.euro_dat($row->eventDatum).'</b><br>
				Uhrzeit: <b>'.($row->eventStartZeit).'</b><br>
				Ort: <b>'.$row->eventOrt.'</b><br>
				<br>
				Mögliche Anzahl Personen Begleitung: <b>'.$row->eventBegleitung.'</b><br>
			</p>
		</div>
		<div class="col-md-6">
			<form action="?hn=termine&sn2=gaesteliste&cont=gaesteliste" method="post">
				<input type="hidden" name="eventid" value="'.$row->eventid.'">
				<input type="hidden" name="mid" value="'.$mid.'">

				  <div class="checkbox">
				    <label>
				      <input type="checkbox" name="ichnehmeteil" value="9"> Ich nehme verbindlich teil
				    </label>
				  </div>
'.($row->eventBegleitung > 0 ? '
				 <div class="form-group">
				    <input type="text" class="form-control" id="anzahl" name="anzahl" placeholder="Anzahl" value="0" ref="'.$row->eventBegleitung.'" style="width:50px; float:left; height:inherit; margin-right: 10px; ">
				    <label for="anzahl">Anzahl Personen Begleitung</label>
				  </div>
' : '').'
				  <br class="cls">

				  <button type="submit" class="btn btn-info">Absenden</button>
			</form>
';


	$output .= '

		</div>
	</div>
';

	if($row->eventBegleitung > 0) $jsFunc = '

$( "#anzahl" ).change(function() {
	max = $(this).attr("ref");
	anz = $(this).val();

	if(anz > max) {
		$(this).val(max);
		alert("Die maximale Anzahl Begleitpersonen ist: "+max);
	}
});


';
}

?>