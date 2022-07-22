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
#$box = 1;
$myauth = 60;
$event_in = 'in';
$event_active = ' class="active"';

include("cms_include.inc");

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
// print_r($_REQUEST);

global $arr_form;

// NICHT VERAENDERN ///////////////////////////////////////////////////////////////////
$edit 	= $_REQUEST["edit"];
$delimg = $_REQUEST["delimg"];
$neu	= $_REQUEST["neu"];
$save	= $_REQUEST["save"];
$del	= $_REQUEST["del"];
$delete	= $_REQUEST["delete"];
$id		= $_REQUEST["id"];
///////////////////////////////////////////////////////////////////////////////////////


//// EDIT_SKRIPT
$um_wen_gehts 	= "Kategorien";
$titel			= "Veranstaltungs Kategorien";
///////////////////////////////////////////////////////////////////////////////////////
global $imgFolder, $imgFolderShort, $scriptname;

$imgFolder = "../images/event/";
$imgFolderShort = "event/";
$scriptname = basename(__FILE__);


echo '<div id=vorschau>
	<h2>'.$titel.'</h2>

	'. ($edit || $neu ? '<p><a href="?pid='.$pid.'">&laquo; zur&uuml;ck</a></p>' : '') .'
	<form action="" onsubmit="" name="verwaltung" method="post">
';


$new = '<p><a href="?neu=1">&raquo; NEU</a></p>';

//// EDIT_SKRIPT
// 0 => Feldbezeichnung, 1 => Bezeichnung für Kunden, 2 => Art des Formularfeldes
$arr_form = array(
	//array("reihenfolge1", "Reihenfolge", '<input type="Text" value="#v#" name="#n#" style="#s#">'),
	array("bezeichnung", "Phase", '<input type="Text" value="#v#" name="#n#" style="#s#">'),
	array("name", "Name der Veranstaltung", '<input type="Text" value="#v#" name="#n#" style="#s#">'),
	array("ziel", "Ziel", '<input type="Text" value="#v#" name="#n#" style="#s#">'),
	array("format", "Format", '<input type="Text" value="#v#" name="#n#" style="#s#">'),
	array("prozent", "Prozent Phase", '<input type="Text" value="#v#" name="#n#" style="#s#">'),
	array("aktiv", "Aktive Phase", 'chk'),
 	#array("pdf", "Berechtigung (ID: 1 = Zugang)", 'sel', 'image', 'imgname'),
	array("pid", "PDF", 'sel2', 'morp_cms_pdf', 'pname', 'pid'),

);
///////////////////////////////////////////////////////////////////////////////////////

#	array("mberechtigung", "Berechtigung (ID: 1 = Zugang)", '<input type="Text" value="#v#" name="#n#" style="#s#">'),
# 	array("ausbildungen", "<strong>Ausbildung EN</strong>", '<textarea cols="80" rows="5" name="#n#">#v#</textarea>'),

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

function liste() {
	//// EDIT_SKRIPT
	$db = "morp_event_kategorie";
	$id = "kid";
	$ord = "reihenfolge1";
	$anz = "bezeichnung";
	$anz2 = "reihenfolge1";
	////////////////////

	$echo .= '<p>&nbsp;</p><table width="100%" cellspacing="0" cellpadding="0" class="autocol">';

	$sql = "SELECT * FROM $db WHERE 1 ORDER BY ".$ord."";
	$res = safe_query($sql);

	while ($row = mysqli_fetch_object($res)) {
		$edit = $row->$id;
		$echo .= '<tr>
			<td><a href="?edit='.$edit.'">'.$row->$anz.'</strong></a></td>
			<td><a href="?edit='.$edit.'">'.($row->aktiv ? 'active' : '').'</a></td>
			<td><a href="?edit='.$edit.'"><b>'.$row->prozent.'%</b></a></td>
			<td><a href="?edit='.$edit.'">'.$row->name.'</a></td>
<!--			<td><a href="?edit='.$edit.'">'.$row->ziel.'</a></td>-->
			<td><a href="?edit='.$edit.'">'.$row->format.'</a></td>
			<td valign="top"><a href="?edit='.$edit.'"><i class="fa fa-pencil-square-o"></a></td>
			<td valign="top"><a href="?del='.$edit.'"><i class="fa fa-trash-o"></a></td>
		</tr>';
	}

	$echo .= '</table><p>&nbsp;</p>';

	return $echo;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

function edit($edit) {
	global $arr_form, $hide, $table, $tid, $imgFolder, $um_wen_gehts, $scriptname, $mylink;

	//// EDIT_SKRIPT
	$db = "morp_event_kategorie";
	$id = "kid";
	
	$table = 'morp_event_kategorie';
	$tid = 'kid';
	$nameField = "bezeichnung";
	$imgFolder = 'event';
	/////////////////////

	$sql = "SELECT * FROM $db WHERE $id=".$edit."";
	$res = safe_query($sql);
	$row = mysqli_fetch_object($res);

	$echo .= '<input type="Hidden" name="neu" value="'.$neu.'">
		<input type="Hidden" name="edit" value="'.$edit.'">
		<input type="Hidden" name="save" value="1">

<style>
	td { padding: 0 1em 1em 0;  }

</style>
		
	<table>
';

	foreach ($arr_form as $arr) {
		$echo .= setMorpheusFormTable($row, $arr, $imgFolder, $edit, substr($scriptname, 0, (strlen($scriptname) - 4)), $tid);
	}

	$echo .= '
	</table>
		<input type="submit" name="speichern" value="speichern">
';

	return $echo;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

function neu() {
	global $arr_form;

	$x = 0;

	$echo .= '<input type="Hidden" name="neu" value="1"><input type="Hidden" name="save" value="1">

	<table cellspacing="6">';

	foreach($arr_form as $arr) {
		$get = $arr[0];
		if ($x <= 2) $echo .= '<tr>
			<td>'.$arr[1].':</td>
			<td>'. repl(array("#v#", "#n#", "#s#"), array($row->$get, $arr[0], 'width:400px;'), $arr[2]).'</td>
		</tr>';
		$x++;
	}

	$echo .= '<tr>
		<td></td>
		<td><input type="submit" name="speichern" value="speichern"></td>
	</tr>
</table>';

	return $echo;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

if ($save) {
	global $arr_form;

	//// EDIT_SKRIPT
	$sql = '';
	$db = "morp_event_kategorie";
	$id = "kid";
	/////////////////////

	foreach($arr_form as $arr) {
		$tmp = $arr[0];
		$val = $_POST[$tmp];

		if ($tmp != "region") $sql .= $tmp. "='" .trim($val). "', ";
	}

	$sql = substr($sql, 0, -2);

	if ($neu) {
		$sql  = "INSERT $db set $sql";
		$res  = safe_query($sql);
		$edit = mysqli_insert_id($mylink);
		unset($neu);
	}
	else {
		$sql = "update $db set $sql WHERE $id=$edit";
		$res = safe_query($sql);
	}
	// echo $sql;
	unset($edit);
}
elseif ($del) {
	die('<p>M&ouml;chten Sie den '.$um_wen_gehts.' wirklich l&ouml;schen?</p>
	<p><a href="?delete='.$del.'">Ja</a> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href="?">Nein</a></p>
	');
}
elseif ($delete) {
	$sql = "DELETE FROM morp_event_kategorie WHERE sid=$delete";
	$res = safe_query($sql);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

if ($neu) 		echo neu("neu");
elseif ($edit) 	echo edit($edit);
else			echo liste($id).$new;

echo '
</form>
';

include("footer.php");

?>
