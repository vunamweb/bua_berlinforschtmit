<?php
# # # # # # # # # # # # # # # # # # # # # # # # # # #
# www.pixel-dusche.de                               #
# björn t. knetter                                  #
# start 12/2003                                     #
# edit 27.11.2006                                   #
# post@pixel-dusche.de                              #
# frankfurt am main, germany                        #
# # # # # # # # # # # # # # # # # # # # # # # # # # #

session_start();
error_reporting(0);

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

$myauth = 60;
$events_in = 'in';
$events_active = ' class="active"';

//echo $_REQUEST["search_value"] . 'ddd'; die();

if ($_REQUEST["search_event"] == '' && $_REQUEST['get_log'] == '' && $_REQUEST['sendMail'] == '') {
    //echo 'ok'; die();
    include "cms_include.inc";
    include "_tinymce.php";
} else {
    include "cms_include_properties.inc";
    include "_tinymce.php";
}

//include "cms_include.inc";
//include "_tinymce.php";

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

# print_r($_SESSION);
# print_r($_REQUEST);

///////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
//// EDIT_SKRIPT
$um_wen_gehts = "Event";
$titel = "Event Verwaltung";
///////////////////////////////////////////////////////////////////////////////////////
$table = 'morp_events';
$tid = 'eventid';
$nameField = "eventName";

$imgFolder = "../images/event/";
$imgFolderShort = "event/";
$scriptname = basename(__FILE__);
///////////////////////////////////////////////////////////////////////////////////////
$unvis = $_REQUEST["unvis"];
$vis = $_REQUEST["vis"];

$search_event = $_REQUEST['search_event'];
$search_value = $_REQUEST['search_value'];
$fromDate = $_REQUEST['fromDate'];
$toDate = $_REQUEST['toDate'];
$eventId = $_REQUEST['eventId'];

$hide = 'hide';

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

// $new = '<a href="?neu=1" class="btn btn-info"><i class="fa fa-plus"></i> NEU</a>';
$new = '<p><a href="?new=1" class="btn btn-info"><i class="fa fa-plus"></i> NEU</a></p>';

if ($_REQUEST["search_event"] == '' && $_REQUEST['get_log'] == '' && $_REQUEST['sendMail'] == '') {
    echo '<div id=vorschau>
		<h2 class="mb4">' . $titel . '</h2>

		' . ($edit || $neu ? '<p><a href="?">&laquo; zur&uuml;ck</a></p>' : '') . '
		<form action="" onsubmit="" name="verwaltung" id="verwaltung" method="post">
	' . ($edit || $neu ? '' : '') . '
	' . (!$edit && !$neu ? '' : '') . '
	';
}

// print_r($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////
#$sql = "ALTER TABLE  $table ADD  `fFirmenFilterID` INT( 11 ) NOT NULL";
#safe_query($sql);
/////////////////////////////////////////////////////////////////////////////////////////////////////

$arr_form = array(
	// array("eventNameEn", "Titel Event EN", '<textarea class="form-control" name="#n#" />#v#</textarea>'),
//        array("eventAbstract", "Art des Wokshop", '<input type="Text" value="#v#" class="form-control" name="#n#"  />'),
//        array("eventKat", "Kategorie", '<input type="Text" value="#v#" class="form-control" name="#n#"  />'),

	array("eventName", "Titel Event", '<textarea class="form-control" name="#n#" />#v#</textarea>'),
	array("kid", "Phase", 'sel2', 'morp_event_kategorie', 'bezeichnung', 'kid'),
	
	array("aktiv", "Online sichtbar", 'chk'),
	
	array("eventText", "Beschreibung", '<textarea class="form-control" name="#n#" />#v#</textarea>'),
	array("event_reg_text1", "Beschreibung Ablauf Veranstaltung DE", '<textarea class="form-control" name="#n#" />#v#</textarea>'),
	// array("event_reg_text2", "Registrierund End Datum DE", '<textarea class="form-control" name="#n#" />#v#</textarea>'),

// array("eventTextEn", "Beschreibung EN", '<textarea class="form-control" name="#n#" />#v#</textarea>'),

	// array("event_reg_text1En", "Beschreibung Ablauf Veranstaltung EN", '<textarea class="form-control" name="#n#" />#v#</textarea>'),
	// array("event_reg_text2En", "Registrierund End Datum EN", '<textarea class="form-control" name="#n#" />#v#</textarea>'),

	array("", "CONFIG", '</div><div class="col-md-6">'),
	
	array("eventDatum", "Datum Start", '<input type="Text" value="#v#" class="form-control" name="#n#" />', 'date'),
	array("event_zusage", "Empfänger E-Mail Registrierung", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),

	array("eventAnzahlTeilnehmer", "Anzahl Teilnehmer", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),

    array("event_mail_confirm", "Confirmation E-Mail", '<textarea class="summernote form-control" name="#n#" />#v#</textarea>'),

	//array("event_mail_confirm", "Confirmation E-Mail", '<textarea class="summernote form-control" name="#n#" />#v#</textarea>'),
	//array("mail_text_user", "User E-Mail", '<textarea class="summernote form-control" name="#n#" />#v#</textarea>'),
	
//        array("oid", "Ort", 'sel2m', 'morp_event_orte', 'stadt', 'veranstOrt', 'oid'),
//        array("mid", "Ansprechpartner", 'sel2m', 'morp_mitarbeiter', 'name', 'vorname', 'mid'),

#        array("zusatz2", "Datum Anzeige", '<textarea class="form-control" name="#n#" />#v#</textarea>'),
#        array("zusatz", "Anzahl Tage", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
#        array("preis", "Preis", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),

#        array("referenten", "Referenten", '<textarea class="form-control" name="#n#" />#v#</textarea>'),
#        array("hinweis", "Hinweise", '<textarea class="form-control" name="#n#" />#v#</textarea>'),

#        array("event_zusage", "E-Mail Adresse", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
#        array("anmeldung", "E-Mail Betreff", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),

//        array("eventStartZeit", "Uhrzeit Beginn", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),

//        array("eventBegleitung", "Anzahl Begleitpersonen je Mitarbeiter", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),

	// array("", "CONFIG", '</div><div class="col-md-12">'),


//        array("eventAnzahlRest", "Bereits belegt/reserviert", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),

//        array("eventText", "Beschreibung", '<textarea class="form-control" name="#n#" />#v#</textarea>'),

	// array("", "CONFIG", '</div><div class="col-md-12 mb3 mt2">'),

	// array("img1", "Referent 1", 'fotoG', 'image', 'imgname', 6, 'gid'),
	// array("img2", "Referent 2", 'fotoG', 'image', 'imgname', 6, 'gid'),
	// array("img3", "Referent 3", 'fotoG', 'image', 'imgname', 6, 'gid'),
	// array("img4", "Referent 4", 'fotoG', 'image', 'imgname', 6, 'gid'),
	// array("", "CONFIG", '</div></div>'),
);
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

$neuerDatensatz = isset($_GET["new"]) ? $_GET["new"] : 0;
$edit = isset($_REQUEST["edit"]) ? $_REQUEST["edit"] : 0;
$save = isset($_REQUEST["save"]) ? $_REQUEST["save"] : 0;
$del = isset($_REQUEST["del"]) ? $_REQUEST["del"] : 0;
$delete = isset($_REQUEST["delete"]) ? $_REQUEST["delete"] : 0;
$back = isset($_POST["back"]) ? $_POST["back"] : 0;
$delguest = isset($_GET["delguest"]) ? $_GET["delguest"] : 0;
$delguestconfirm = isset($_GET["delguestconfirm"]) ? $_GET["delguestconfirm"] : 0;
$get_log = $_REQUEST['get_log'];
$typeEvent = $_REQUEST['typeEvent'];

$ilink = isset($_POST["ilink"]) ? $_POST["ilink"] : 1;
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

if ($get_log) {
    //echo $typeEvent;
    echo getLogEvent($typeEvent);
    die();
} elseif ($vis || $unvis) {
    if ($vis) {
        $sql = "UPDATE $table SET aktiv=1 WHERE $tid=" . $vis;
    } elseif ($unvis) {
        $sql = "UPDATE $table SET aktiv=0 WHERE $tid=" . $unvis;
    }

    // echo $sql;
    safe_query($sql);
    $jsSAVE = 1;
} else if ($delguest) {
    $kunde = get_db_field($delguest, 'name', 'morp_cms_form_auswertung', 'aid');
    die('<p>&nbsp;</p><p><font color=#ff0000><b>Wollen Sie den Kunden <u>' . $kunde . '</u> wirklich vom Event  l&ouml;schen?</b></font></p>
	<p class="mt4">
		<a href="?edit=' . $edit . '" class="btn btn-info">Nein</a> &nbsp;  &nbsp; &nbsp;
		<a href="?delguestconfirm=' . $delguest . '&edit=' . $edit . '" class="btn btn-danger">JA</a>
	</p>

	</body></html>
	');
} else if ($delguestconfirm) {
    $sql = "DELETE FROM morp_cms_form_auswertung WHERE aid=$delguestconfirm";
    $res = safe_query($sql);
    echo '<script> document.location.href="?edit=' . $edit . '"; </script>';
}
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

function liste()
{
    global $arr_form, $table, $tid, $filter, $nameField;

    //// EDIT_SKRIPT
    $ord = 'kid ASC, eventDatum ASC';
    $anz = $nameField;

    ////////////////////
    $where = 1;
    $heute = date("Y-m-d");

    $echo .= '<p>&nbsp;</p>
	<table class="autocol p20 newTable" style="width:100%">
		<tr>
			<th></th>
			<th>ID</th>
			<th>DE</th>
			<th>Datum<br></th>
			<th>Anzahl<br>Gesamt</th>
			<th>Anzahl<br>Registriert</th>
			<th></th>
			<th></th>
		</tr>
';

    $sql = "SELECT * FROM $table WHERE $where ORDER BY " . $ord . "";
    $res = safe_query($sql);
    // echo mysqli_num_rows($res);

    $oldKat = '';

    while ($row = mysqli_fetch_object($res)) {
        $edit = $row->$tid;

        $kid = $row->kid;

        if($oldKat != $kid) {
            $kat = get_db_field($row->kid, 'bezeichnung', 'morp_event_kategorie', 'kid');

            $echo .= '            <tr>
            <th colspan="6">
                <h5>'.$kat.'</h5>
            </th>
        </tr>
';
            $oldKat = $kid;
        }


        $ort = get_2_db_field($row->oid, 'stadt', 'veranstOrt', 'morp_event_orte', 'oid');

        $sql = "SELECT * FROM `morp_cms_form_auswertung` WHERE event=$edit AND register=1";
        $rs = safe_query($sql);
        $eventAnzahlRest = mysqli_num_rows($rs);

        $si = $row->aktiv;
        if ($si == 1) {
            $si = '<a href="?unvis=' . $edit . '" class="btn btn-success"><i class="fa fa-eye vis" ref="0"></i></a>';
        } else {
            $si = '<a href="?vis=' . $edit . '" class="btn btn-info"><i class="gray fa fa-eye-slash vis" ref="1"></i></a>';
        }

        $echo .= '			<tr' . ($row->eventDatum < $heute ? ' class="warn"' : '') . '>
			<td width="50" align="center">
				<a href="?edit=' . $edit . '" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i></a>
			</td>
			<td width="50" align="center">
				<a href="?edit=' . $edit . '">' . $row->eventid . ' </a>
			</td>
			<td>
				<a href="?edit=' . $edit . '">' . $row->eventName . ' </a>
			</td>
			<td>
				<a href="?edit=' . $edit . '">' . euro_dat($row->eventDatum) . '</a>
			</td>
			<td>' . $row->eventAnzahlTeilnehmer . ' &nbsp; &nbsp; </td>
			<td>' . $eventAnzahlRest . ' &nbsp; &nbsp; </td>
			<td>
				' . $si . '
			</td>
			<td>
				<a href="?del=' . $edit . '" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
			</td>
		</tr>
';
    }

    $echo .= '</table><p>&nbsp;</p>';

    return $echo;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

function seachEvent()
{
    global $eventId, $fromDate, $toDate, $search_value;

    $echo = '
	<table class="autocol p20 newTable" style="width:100%">
		<tr>
			<td>Name</td>
			<td>Organisation</td>
			<td>Function</td>
			<td>Address</td>
			<td>Phone</td>
			<td>E-Mail</td>
			<td>Date</td>
			<td>Confirm</td>
			<td>Register</td>
		</tr>
		';

    if ($fromDate == '' || $toDate == '') {
        $sql = "SELECT * FROM `morp_cms_form_auswertung` WHERE event = $eventId AND register =1 and name like '%$search_value%'";
    } else {
        $sql = "SELECT * FROM `morp_cms_form_auswertung` WHERE event = $eventId AND register =1 and datum >= '$fromDate'
		and datum <= '$toDate' and name like '%$search_value%'";
    }

    //return $sql; die();

    $res = safe_query($sql);
    $mail = "E-Mail";
    $all_mails = '';
    while ($row = mysqli_fetch_object($res)) {

        $all_mails .= $row->$mail . ',';

        $checkConfirm = ($row->confirm) ? 'checked' : '';
        $checkCancel = ($row->register) ? 'checked' : '';

        $echo .= '
	<tr>
		<td><a href="morp_veranstaltung_bookings.php?edit=' . $row->aid . '">' . $row->name . '</a></td>
		<td>' . $row->Organisation . '</td>
		<td>' . $row->Function . '' . $row->Funktion . '</td>
		<td>' . $row->Address . '' . $row->Addresse . '</td>
		<td>' . $row->Phone . '' . $row->Telefon . '</td>
		<td>' . $row->$mail . '</td>
		<td>' . $row->datum . '</td>
		<td><input type="checkbox" ' . $checkConfirm . '></td>
		<td><input type="checkbox" ' . $checkCancel . '></td>
		<td><a href="?delguest=' . $row->aid . '&edit=' . $edit . '" class="btn btn-danger"><i class="fa fa-trash-o"></i></a></td>
	</tr>';
    }

    $echo .= '</table>';

    return $echo;
}

function getLogEvent($typeEvent)
{
    global $edit;

    $log = '<div id="log_event">';

    $sql = "SELECT * FROM morp_event_user_mail WHERE idEvent = " . $edit . " and type_event = " . $typeEvent . "  order by date_create desc";
    //echo $sql;
    $res = safe_query($sql);

    $first = true;
    $text_mail = '';

    while ($row = mysqli_fetch_object($res)) {
        $idusm = $row->idusm;

        $title = '';

        $sql = "select * from morp_log_sendmail_event_user where idusm = $idusm";
        $res_1 = safe_query($sql);

        while ($row_1 = mysqli_fetch_object($res_1)) {
            $title .= $row_1->email . ",";
        }

        if ($title == '') {
            $title = 'No data';
        }

        if ($first) {
            $first = false;
            $text_mail = $row->mail_text;
        }
        $log .= '<a href="#" data-toggle="modal" data-target="#myModal_log" title="' . $title . '" class="text_log text_log_' . $idusm . '">' . $row->mail_text . '</a>';
        $log .= '<p class="text_log">' . $row->date_create . '</p>';
        $log .= '<a href="#' . $idusm . '" class="edit_mail_event"><i class="fa fa-pencil-square-o"></i></a>';
        $log .= '<a href="#' . $idusm . '" class="send_mail_event_confirm" data-toggle="modal" data-target="#myModal_send_mail"><i class="fa fa-paper-plane"></i></a>';

        $log .= '<br>';
    }

    $log .= '<a href="#" class="add_mail_event"><i class="fa fa-plus small"></i></a>';

    $log .= '<textarea class="summernote form-control" name="text_email" id="text_email">' . $text_mail . '</textarea>';

    $log .= '</div>';

    return $log;
}

function edit($edit)
{
    global $arr_form, $hide, $table, $tid, $imgFolder, $um_wen_gehts, $scriptname, $mylink, $table2, $tid2;

    $sql = "SELECT * FROM $table WHERE $tid=" . $edit . "";
    $res = safe_query($sql);
    $row = mysqli_fetch_object($res);
    $cid = $row->cid;
    $cidEn = $row->cidEn;
	$ilink = $row->ilink;

    /*// get mail text of user event
    $sql = "SELECT * FROM morp_event_user_mail WHERE idEvent = " . $edit . " order by date_send_mail desc";
    $res = safe_query($sql);
    $row_1 = mysqli_fetch_object($res);

    $row->mail_text_user = $row_1->mail_text; */

    // if (!$cid) {
    //     $sql = "INSERT `morp_cms_content` SET vorlage=1, `pos`='$pos', vorl_name='$tname',content='t1__fliesstext@@##t1__register@@##t1__fliesstext@@##t1__aufzaehlung_dots@@##t1__fliesstext@@About the instructor##t1__aufzaehlung_dots@@<strong>Contact Objective 2/Research Forums: Dr. Melanie Kryst | <a:melanie.kryst@berlin-university-alliance.de:>melanie.kryst@berlin-university-alliance.de</a></strong>##', edit=1";
    //     $res = safe_query($sql);
    //     $cid = mysqli_insert_id($mylink);
    //     $sq = "UPDATE $table SET cid=$cid WHERE $tid=" . $edit . "";
    //     // $sql    = "INSERT `morp_cms_content_live` SET vorlage=1, `pos`='$pos', vorl_name='$tname', edit=1";
    //     $rs = safe_query($sq);
    // }
    // if (!$cidEn) {
    //     $sql = "INSERT `morp_cms_content` SET vorlage=1, `pos`='$pos', vorl_name='$tname', content='t1__fliesstext@@##t1__register@@##t1__fliesstext@@##t1__aufzaehlung_dots@@##t1__fliesstext@@About the instructor##t1__aufzaehlung_dots@@<strong>Contact Objective 2/Research Forums: Dr. Melanie Kryst | <a:melanie.kryst@berlin-university-alliance.de:>melanie.kryst@berlin-university-alliance.de</a></strong>##', edit=1";
    //     $res = safe_query($sql);
    //     $cidEn = mysqli_insert_id($mylink);
    //     $sq = "UPDATE $table SET cidEn=$cidEn WHERE $tid=" . $edit . "";
    //     // $sql    = "INSERT `morp_cms_content_live` SET vorlage=1, `pos`='$pos', vorl_name='$tname', edit=1";
    //     $rs = safe_query($sq);
    // }

    $echo .= '
		<input type="Hidden" name="edit" id="edit" value="' . $edit . '">
        <input type="Hidden" name="save" value="1">
        <input type="hidden" value="0" name="back" id="back" />
        <input type="hidden" value="0" name="idusm" id="idusm" />
        <div class="row">
            <div class="col-md-6">
            <div class="alert alert alert-success ' . $hide . ' alert_event_user" role="alert">Save Successfully</div>
    ';

    foreach ($arr_form as $arr) {
        $echo .= setMorpheusForm($row, $arr, $imgFolder, $edit, substr($scriptname, 0, (strlen($scriptname) - 4)), $tid);
    }


	// $echo .= '
	// <p>&nbsp;</p>
	// <p><b>Auswahl Seite Dokumentation</b></p>
	// <select id="ilink" name="ilink"><option value="0">Bitte Zielseite wählen</option>';
	// $sql = "SELECT * from morp_cms_nav WHERE `parent`=3";
	// $rs = safe_query($sql);
	// while($rw = mysqli_fetch_object($rs)) {
	// 	$navid = $rw->navid;
	// 	$name = $rw->name;
	// 	$echo .= '<option value="'.$navid.'"'.($ilink == $navid ? ' selected' : '').'>'.$name.'</option>';
	// 	
	// }
	// $echo .= '</select>
	
	$echo .= '
	</div><div class="col-md-12 mb3 mt2">	
	';
	
	
    $echo .= '
	<!--
<p style="margin-bottom:1em;"><a href="content_edit.php?edit=' . $cidEn . '&vorlage=1&event=' . $edit . '"><i class="fa fa-chevron-right"></i> &nbsp; Langtext EDIT English</a></p>
<p><a href="content_edit.php?edit=' . $cid . '&vorlage=1&event=' . $edit . '"><i class="fa fa-chevron-right"></i> &nbsp; Langtext EDIT Deutsch</a></p>
-->
			<br>
				<button type="submit" id="savebtn" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; ' . $um_wen_gehts . ' speichern / aktualisieren</button>
                <a id="savebtn1" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-save"></i> &nbsp; ' . $um_wen_gehts . ' Send Mail</a>
				<button type="submit" id="savebtn2" value="hier" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; ' . $um_wen_gehts . ' speichern und zurück</button>
		</div>
	</div>
';

    $echo .= '<!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p>Type Event</p>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="alert alert alert-success  alert_event_user hide" role="alert"></div>
          <select name="type_event" id="type_event">
              <option value="1">Confirm</option>
              <option value="2">Register AND Confirm</option>
              <option value="3">Register</option>
           </select>
           <br><br>
           ' . getLogEvent(1) . '
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <a class="btn cancel_back">Cancel</a>
            <a class="btn send_mail_event_user">Save</a>
        </div>
      </div>
    </div>
  </div>';

  $echo .= '<!-- The Modal log -->
  <div class="modal" id="myModal_log">
    <div class="modal-dialog modal-dialog_new">
      <div class="modal-content modal-content_new">

        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p>Log Mail Event</p>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <a class="btn cancel_back">Cancel</a>
            <a class="btn send_mail_event_user">Save</a>
        </div>
      </div>
    </div>
  </div>';

  $echo .= '<!-- The Modal send mail -->
  <div class="modal" id="myModal_send_mail">
    <div class="modal-dialog modal-dialog_new">
      <div class="modal-content modal-content_new">

        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p>Please select type Event</p>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <center><i class="fa fa-spinner" aria-hidden="true"></i></center>
            <select name="type_event_send_mail" id="type_event_send_mail">
                <option value="1">Confirm</option>
                <option value="2">Register AND Confirm</option>
                <option value="3">Register</option>
            </select>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <a class="btn cancel_back_send_mail">Cancel</a>
            <a class="btn send_mail">Send</a>
        </div>
      </div>
    </div>
  </div>';

    $form = '<hr>';

    $form .= '<div class="row"><form class="navbar-form-veranstaltung" role="search" method="get">';
    $form .= '<div class="col-md-2 ui left icon input">
	  <input type="text" name="suche" id="suche" placeholder="Suche">
	</div>';

    $form .= '<div class="col-md-2 ui left icon input">
	  <input type="text" name="from-date" id="from-date" class="datepicker" placeholder="From date">
	</div>';

    $form .= '<div class="col-md-2 ui left icon input">
	  <input type="text" name="to-date" id="to-date" class="datepicker" placeholder="To date">
	</div>';

    $form .= '<div class="col-md-2"><button type="button" value="Suchen" class="btn btn-info search-event">Filter</button></div>';
    $form .= '</form></div>';

    $form .= '<hr class="mt2">';

    $echo .= $form;

    $echo .= '
<div id="list_user_search"><table class="autocol p20 newTable" style="width:100%">
	<tr>
		<td>Name</td>
		<td>Organisation</td>
		<td>Function</td>
		<td>Address</td>
		<td>Phone</td>
		<td>E-Mail</td>
		<td>Date</td>
		<td>Confirm</td>
		<td>Register</td>
	</tr>';

    $sql = "SELECT * FROM `morp_cms_form_auswertung` WHERE event=$edit AND register=1";
    $res = safe_query($sql);
    $mail = "E-Mail";
    $all_mails = '';
    while ($row = mysqli_fetch_object($res)) {

        $all_mails .= $row->$mail . ',';

        $checkConfirm = ($row->confirm) ? 'checked' : '';
        $checkCancel = ($row->register) ? 'checked' : '';

        $echo .= '
	<tr>
		<td><a href="morp_veranstaltung_bookings.php?edit=' . $row->aid . '">' . $row->name . '</a></td>
		<td>' . $row->Organisation . '</td>
		<td>' . $row->Function . '' . $row->Funktion . '</td>
		<td>' . $row->Address . '' . $row->Addresse . '</td>
		<td>' . $row->Phone . '' . $row->Telefon . '</td>
		<td>' . $row->$mail . '</td>
		<td>' . $row->datum . '</td>
		<td><input type="checkbox" ' . $checkConfirm . '></td>
		<td><input type="checkbox" ' . $checkCancel . '></td>
		<td><a href="?delguest=' . $row->aid . '&edit=' . $edit . '" class="btn btn-danger"><i class="fa fa-trash-o"></i></a></td>
	</tr>';
    }
    $echo .= '</table></div><br><br><h3>Alle E-Mail Adressen mit Komma Trennung:</h3>' . substr($all_mails, 0, strlen($all_mails) - 1);

    $echo .= '<div id="waitbg" class="hide"></div>';
    $echo .= '<div id="wave1" class="hide"></div>';
    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    return $echo;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

function neu()
{
    global $arr_form, $table, $tid, $um_wen_gehts;

    $x = 0;

    $echo .= '<input type="Hidden" name="neu" value="1"><input type="Hidden" name="save" value="1">

	<table cellspacing="6" style="width:100%;">';

    foreach ($arr_form as $arr) {
        if ($x < 1) {
            $echo .= '<tr>
			<td>' . $arr[1] . ':</td>
			<td>' . str_replace(array("#v#", "#n#", "#s#"), array($get, $arr[0], 'width:400px;'), $arr[2]) . '</td>
		</tr>';
        }

        $x++;
    }

    $echo .= '<tr>
		<td></td>
		<td>
			<br>
			<button type="submit" id="savebtn" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; ' . $um_wen_gehts . ' speichern</button>
		</td>
	</tr>
</table>';

    return $echo;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

if ($save) {
    $neu = isset($_POST["neu"]) ? $_POST["neu"] : 0;
    $hide = '';
    $date = date('Y-m-d H:i:s');
    $eventId = $_REQUEST['edit'];
    $userMail = $_REQUEST['value_text_mail'];
    $typeEvent = $_REQUEST['value_type_event'];
    $idusm = $_REQUEST['idusm'];

    if ($back == 2) {
        //echo 'send mail';
        if ($_REQUEST['sendMail']) {
            include '../inc/send.php';
            include "../nogo/config.php";

            global $morpheus, $hide;

            // send mail to user
            switch ($typeEvent) {
                case 2:
                    $sql = 'select * from morp_cms_form_auswertung where register = 1 and confirm = 0 and event = ' . $eventId . '';
                    break;
                case 3:
                    $sql = 'select * from morp_cms_form_auswertung where register = 1 and event = ' . $eventId . '';
                    break;
                default:
                    $sql = 'select * from morp_cms_form_auswertung where confirm = 1 and event = ' . $eventId . '';

            }

            //echo $sql; die();

            $subject = 'Event';

            $headerMail = $morpheus["mail_start"];
            $footerMail = $morpheus["mail_end"];

            $mail_txt = $headerMail . $userMail . $footerMail;

            $obj = new \stdClass;
            $obj->data = array();

            $result = safe_query($sql);

            while ($row = mysqli_fetch_object($result)) {
                $field = 'E-Mail';
                $to = $row->$field;

                //$to_ = 'vukynamkhtn@gmail.com';
                $to_ = 'post@pixel-dusche.de';

                $subject = "Event";

                sendMailSMTP($to_, utf8_decode($subject), utf8_decode($mail_txt));

                // log 
                $query = "insert into morp_log_sendmail_event_user(idusm, email) values($idusm, '".$to."')";
                //echo $query;
                safe_query($query);

                $obj->data[] = $to;
            }

            echo json_encode($obj); die();
        } else {
            $sql = (!$idusm) ? 'insert into morp_event_user_mail(idEvent, mail_text, type_event, date_create) values(' . $eventId . ', "' . $userMail . '", ' . $typeEvent . ', "' . $date . '")' :
            'update morp_event_user_mail set mail_text = "' . $userMail . '" where idusm = ' . $idusm . '';
            echo $sql;
            safe_query($sql);
        }
    } else {
        // echo "save";
		$zusatz = ", ilink=$ilink";
		
        $edit = saveMorpheusForm($edit, $neu, 0, $zusatz);

        // if(neu) unset($neu);

        $scriptname = basename(__FILE__);

        if ($back) {
            ?>
        <script>
            location.href='<?php echo $scriptname; ?>';
        </script>
        <?php
} elseif ($neu) {
            ?>
        <script>
            location.href='<?php echo $scriptname; ?>?edit=<?php echo $edit; ?>';
        </script>
        <?php
}
    }

    // unset($edit);
} elseif ($delimg) {
    deleteImage($delimg, $edit, $imgFolder);
} elseif ($delete) {
    $sql = "DELETE FROM `$table` WHERE $tid=$delete ";
    safe_query($sql);
}

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

if ($del) {
    echo '	<h2>Wollen Sie ' . $um_wen_gehts . ' wirklich löschen?</h2>
<br><br>
			<a href="?delete=' . $del . '" class="btn btn-danger"><i class="fa fa-trash"></i> &nbsp; Ja</a>
			<a href="?" class="btn btn-info"><i class="fa fa-remove"></i> &nbsp; Nein / Abbruch</a>

';
} elseif ($neuerDatensatz) {
    echo neu("neu");
} elseif ($edit) {
    echo edit($edit);
} elseif ($search_event) {
    echo seachEvent();
    die();
} else {
    echo liste() . $new;
}

echo '
</form>
';

include "footer.php";

?>

<script>
      $(".form-control").on("change", function() {
	  	$("#savebtn").addClass("btn-danger");
          $("#savebtn2").addClass("btn-danger");
      });

      $("#savebtn").on("click", function() {
	  	$("#back").val('');
      });

      $("#savebtn2").on("click", function() {
	  	$("#back").val(1);
      });

      $("#savebtn1").on("click", function() {
          $("#back").val(2);

          $('.add_mail_event').show();

          hideEditor();
          hideButton();

          $('#myModal .alert_event_user').addClass('hide');

          AddMailEvent();
          EditMailEvent();
          sendMailEvent();
        });

     $('.cancel_back').click(function(){
        /*$('.add_mail_event').show();
        hideEditor();
        hideButton();*/
        $('#myModal .close').click();
     })

     $('a.text_log').click(function(){
         var emailList = $(this).attr('title');

         var log = 'No data';

         if(emailList != 'No data') {
            emailList = emailList.split(',');

            log = '';

            for ( i = 0; i < emailList.length; i++){
                if(emailList[i] != '')
                  log = log + emailList[i] + '<br>'; 
            }
         }

         $('#myModal_log .modal-body').html(log);
     })

</script>