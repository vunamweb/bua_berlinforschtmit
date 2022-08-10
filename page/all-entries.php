<?php
# # # # # # # # # # # # # # # # # # # # # # # # # # #
# www.pixel-dusche.de                               #
# björn t. knetter                                  #
# start 12/2003                                     #
# edit 27.11.2006                                   #
# post@pixel-dusche.de                              #
# frankfurt am main, germany                        #
# # # # # # # # # # # # # # # # # # # # # # # # # # #

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

require_once 'morpheus/getid3/getid3.php';

global $arr_form, $table, $tid, $filter, $nameField;

$myauth = 10;
$stimmen_in = 'in';
$css = "style_blue.css";

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

# print_r($_SESSION);
# print_r($_REQUEST);

///////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
//// EDIT_SKRIPT
$um_wen_gehts = "Sprachaufnahmen";
$titel = "Sprachaufnahmen Verwaltung";
///////////////////////////////////////////////////////////////////////////////////////
$table = 'morp_media';
$tid = 'mediaID';
$nameField = "mname";

$imgFolder = 'wav';

$neu = $_REQUEST['new'];
$save = $_REQUEST['save'];
$myNote = $_REQUEST['myNote'];
$show_comment = $_REQUEST['show_comment'];
$mediaId = $_REQUEST['mediaId'];
$parent_comment = $_REQUEST['parent_comment'];
$parent_comment = $_REQUEST['parent_comment'];
$message_comment = $_REQUEST['message_comment'];

// VU: add code for comment
// add comment for media
if ($myNote) {
    $note = $_GET['myNote'];
    $mediaId = $_GET['mediaId'];
    $uid = $_SESSION['mid'];
    $date = date('y-m-d');

    $sql = 'insert into morp_note(uid, mediaID, message, date_time)values(' . $uid . ', ' . $mediaId . ', "' . $note . '", "' . $date . '")';
    echo $sql;
    safe_query($sql);

    die();
}
// END

$output = '<div id=vorschau>
	<h2>' . $titel . '</h2>

	' . ($edit || $neu || $show_comment ? '<p><a href="?">&laquo; zur&uuml;ck</a></p><br>' : '') . '
	<form action="" onsubmit="" name="verwaltung" method="post">
' . ($edit || $neu ? '' : '') . '
' . (!$edit && !$neu ? '' : '') . '
';

// print_r($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////
#$sql = "ALTER TABLE  $table ADD  `textonline` text() NOT NULL";
#safe_query($sql);
/////////////////////////////////////////////////////////////////////////////////////////////////////

$arr_form = array(
    array("mname", "Dateiname WAV", '<input type="Text" value="#v#" class="form-control" name="#n#" disabled />'),
    array("ck01", "Ja, ich stimme der Nutzung meiner Daten gemäß", 'chk'),
    array("ck02", "Ja, ich stimme der Veröffentlichung der obigen Tonaufnahme unter Abgabe", 'chk'),
    array("ck03", "Ja, ich möchte über weitere Aktionen von Forschung von der Straße informiert werden", 'chk'),
    array("mdesc", "Beschreibung", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
    array("mdate", "Datum", '<input type="Text" value="#v#" class="form-control" name="#n#" />', 'date'),
    array("name", "Name", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
    array("email", "Email", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
    array("text", "Übersetzung", '<textarea class="form-control" name="#n#" />#v#</textarea>'),

    array("", "CONFIG", '</div><div class="col-md-6 mb3 mt2">'),

    array("textonline", "Online Version / Text in rechter Textbox", '<textarea class="form-control" name="#n#" />#v#</textarea>'),
    //array("mname", "MP3", 'file'),

    array("dsgvo", "DSGVO", 'dropdown_array', array("true" => "true", "false" => "false")),
    array("public", "Darf veröffenlicht werden", 'dropdown_array', array("true" => "true", "false" => "false")),

//        array("", "CONFIG", '</div><div class="col-md-12 mb3 mt2">'),
//        array("img1", "Foto 1", 'img'),
    array("", "CONFIG", '</div></div>'),
);

$edit = isset($_REQUEST["edit"]) ? $_REQUEST["edit"] : 0;

// VU: show comment
function comment()
{
    global $arr_form, $table, $tid, $filter, $nameField, $morpheus;

    // install get information from file
    $getID3 = new getID3;

    //// EDIT_SKRIPT
    $ord = ' mdate';
    $anz = $nameField;

    ////////////////////
    $where = 1;

    $echo .= '<p>&nbsp;</p>
	<p class="message_info"></p>

	<style>th { text-align:left; font-size:13px; }
  .player
  {
  background-color: rgb(160,220,250);
  padding : 0px;
  font-family: Arial,Helvetica Neue,Helvetica,sans-serif;
  font-color : blue;
  font-size : 8pt;
  font-weight : bold;
  margin : 1px;
  width : 22px;
  height : 22px;
  }
	</style>
	<table class="autocol p20 newTable" style="width:50%">
	<tr>
		<th width="80%">Online Text</th>
		<th width="80%">Datum</th>
	</tr>';

    $sql = "SELECT * FROM $table WHERE $where ORDER BY " . $ord . "";
    $res = safe_query($sql);
    //echo mysqli_num_rows($res); die();

    while ($row = mysqli_fetch_object($res)) {
        $edit = $row->$tid;
        $text = ($row->textonline != '') ? $row->textonline : 'No description';

        $sql = 'select count(idNote) as count from morp_note where mediaID = ' . $edit . ' and parent = 0';
        $res1 = safe_query($sql);
        $row1 = mysqli_fetch_object($res1);
        $count = $row1->count;

        $text = substr($text, 0, 30) . '(' . $count . ')';

        $echo .= '<tr>
			<td width="70%">
				<a href="#">' . $text . '</a>
			</td>
			<td width="30%">
				<a href="#">' . euro_dat($row->mdate) . ' </a>
				<a href="#' . $edit . '" class="add_note" data-toggle="modal" data-target="#add_note"><i class="fa fa-plus" aria-hidden="true"></i></a>
				<a href="?show_comment=' . $edit . '" class="show_note"><i class="fa fa-pencil" aria-hidden="true"></i></a>
			</td>
		</tr>
';
    }

    $echo .= '</table><p>&nbsp;</p>';

    //modal
    $echo .= '<div class="modal" id="add_note" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<textarea name="message" id="message" placeholder="Comment"></textarea>
				<input type="hidden" id="date_note" value="' . date('Y-m-d') . '" />
				<input type="button" ref="" class="btn btn-info" name="save_note" id="save_note" value="Save"/>
				<input type="button" class="btn btn-info hide" name="cancel_note" id="cancel_note" value="Cancel"/>
			</div>
		</div>
	</div>
</div>';

    return $echo;
}
// END

function liste()
{
    global $arr_form, $table, $tid, $filter, $nameField, $morpheus;

    // install get information from file
    $getID3 = new getID3;

    //// EDIT_SKRIPT
    $ord = ' mdate';
    $anz = $nameField;

    ////////////////////
    $where = 1;

    $echo .= '<p>&nbsp;</p>

	<style>th { text-align:left; font-size:13px; }
  .player
  {
  background-color: rgb(160,220,250);
  padding : 0px;
  font-family: Arial,Helvetica Neue,Helvetica,sans-serif;
  font-color : blue;
  font-size : 8pt;
  font-weight : bold;
  margin : 1px;
  width : 22px;
  height : 22px;
  }
	</style>
	<table class="autocol p20 newTable" style="width:100%">
	<tr>
		<th>ID</th>
		<th>Frage</th>
		<th>Dateiname</th>
		<th></th>
		<th>Dauer</th>
		<th>Kommentar</th>
		<th>Online Text</th>
		<th>DSGVO</th>
		<th>Public</th>
		<th>Datum</th>
	</tr>';

    $sql = "SELECT * FROM $table WHERE $where ORDER BY " . $ord . "";
    $res = safe_query($sql);
    //echo mysqli_num_rows($res); die();

    while ($row = mysqli_fetch_object($res)) {
        $edit = $row->$tid;
        $rubrik = $row->rubrik;

        $file = substr($row->$anz, 0, strlen($row->$anz) - 4);
        $wavfile = (strpos($row->mname, 'wav')) ? $morpheus['url'] . 'wav/' . $row->mname : '#';
        $filename = '../mp3/' . $row->mp3;
        $target = (strpos($row->mname, 'wav')) ? 'target="_blank"' : '';
        if (file_exists($filename) && $row->mp3) {
            $ThisFileInfo = $getID3->analyze($filename);
            $dauer = $row->dauer;
            if (!$dauer) {
                $dauer = $ThisFileInfo['playtime_string'];
                //$sql = "UPDATE $table SET mp3='".str_replace(':', '_', $file).'.mp3'."' WHERE $tid=$edit";
                $sql = "UPDATE $table SET dauer='$dauer' WHERE $tid=$edit";
                safe_query($sql);
            }
            $mp3exists = 1;
            $player = '<audio id="A' . $edit . '" src="' . $filename . '" preload="auto"></audio>
			<input class="btn btn-warning player" id="Bt' . $edit . '" value=">" type="button" onclick="af= \'A' . $edit . '\'; bt= \'Bt' . $edit . '\'; abspielen();">';
        } else {
            $filename = '../wav/' . $row->$anz;
            $ThisFileInfo = $getID3->analyze($filename);
            $dauer = $ThisFileInfo['playtime_string'];
            $dauer = duplicate_time($dauer);
            //return 'nambuzz';
            $mp3exists = 0;
            $player = '';
        }

        if ($rubrik) {
            $frage = get_db_field($rubrik, 'frage', 'morp_stimmen_kategorie', 'stkID');
        } else {
            $frage = '';
        }

        $echo .= '<tr>
			<td width="50" align="center">
				<a href="?edit=' . $edit . '">' . $row->$tid . ' </a>
			</td>
			<td align="center">
				<a href="?edit=' . $edit . '" data-toggle="tooltip" title="' . $frage . '">' . ($rubrik ? '<span class="label label-info">' . $rubrik . '</span>' : '-') . ' </a>
			</td>
			<td>
				<a ' . $target . ' href="' . $wavfile . '">' . $file . ($mp3exists ? ' &nbsp; <span class="label label-danger">MP3</span>' : '') . '</a>' . $player . '
			</td>
			<td>
				<a href="?edit=' . $edit . '">' . ($row->online ? 'online' : 'x') . '</a>
			</td>
			<td>
				<a href="?edit=' . $edit . '">' . $dauer . '</a>
			</td>
			<td>
				<a href="?edit=' . $edit . '">' . substr($row->mdesc, 0, 30) . '</a>
			</td>
			<td>
				<a href="?edit=' . $edit . '">' . substr($row->textonline, 0, 30) . '</a>
			</td>
			<td>
				<a href="?edit=' . $edit . '">' . $row->dsgvo . ' </a>
			</td>
			<td>
				<a href="?edit=' . $edit . '">' . $row->public . ' </a>
			</td>
			<td>
				<a href="?edit=' . $edit . '">' . euro_dat($row->mdate) . ' </a>
			</td>
		</tr>
';
    }

    $echo .= '</table><p>&nbsp;</p>';

    //return 'aaaa';
    return $echo;
}

// VU: show tab list and comment
function list_comment()
{
    $echo = '<ul class="nav nav-tabs">
    <li><a data-toggle="tab" href="#view" class="active">View</a></li>
    <li><a data-toggle="tab" href="#comment">Comment</a></li>
   </ul>';

    $echo .= '<div class="tab-content">
   <div id="view" class="tab-pane fade active show">
     ' . liste() . '
   </div>
   <div id="comment" class="tab-pane fade">
     ' . comment() . '
   </div>
 </div>';

    return $echo;
}
// END

// -----------------------------------------------------------------
// getID3 gibt falschen Wert aus. Ausgabe Länge ist nur halb so lang
function duplicate_time($dauer)
{
    //echo $dauer . '/ddddd/';
    //return 'sss';
    if ($dauer) {
        $split = explode(":", $dauer);
        $minute = $split[0];
        $seconds = $split[1];
        $total = (($minute * 60) + $seconds) * 2;
        $total = $total / 60;
        $minutes = floor($total);
        $seconds = $total - $minutes;
        return $minutes . ':' . (60 * $seconds);
    }

    return '';
}
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

function countComment($idNote) {
	$sql = "SELECT * FROM morp_note WHERE parent = " . $idNote . "";
	$res = safe_query($sql);
	
	return mysqli_num_rows($res);
}

function getNameFromID($mid) {
	require_once "nogo/db2.php";
	dbconnect2();

	$sql = "SELECT * FROM morp_intranet_user WHERE mid = " . $mid . "";
    $res = safe_query2($sql);
	$row = mysqli_fetch_object($res);
	
	return $row->vname . ' ' . $row->nname;
}

function edit($edit)
{
    global $arr_form, $table, $tid, $imgFolder, $um_wen_gehts, $neu;

    $sql = "SELECT * FROM $table WHERE $tid=" . $edit . "";
    $res = safe_query($sql);
    $row = mysqli_fetch_object($res);

    $echo .= '
    <a onclick="history.back()"><i class="fa fa-arrow-circle-left"></i> zurück</a>
    <br><br>

		<div class="row">
			<div class="col-md-6">

	';

    foreach ($arr_form as $arr) {
        $echo .= setMorpheusForm($row, $arr, $imgFolder, $edit, 'morp_media', $tid);
    }

    $echo .= '<br>
		</div>
	</div>
';

    return $echo;
}

// VU: show comment
function showComments($show_comment)
{
    global $morpheus;

	$url = $morpheus['url'] . 'de/' . $_REQUEST['hn'] . '/?show_comment=' . $show_comment . '';
	
	$echo = '<form method="post" action="' . $url . '"><div class="accordion" id="accordionShowComment">';

    $sql = "SELECT * FROM morp_note WHERE mediaID = $show_comment and parent = 0 ORDER BY date_time";
	$res = safe_query($sql);
	
	if(mysqli_num_rows($res) == 0)
	  return 'No comments';
    //echo mysqli_num_rows($res); die();

    while ($row = mysqli_fetch_object($res)) {
		$idNote = $row->idNote;
		$comment = $row->message . '('.countComment($idNote).')';
		
		$name = getNameFromID($row->uid); //$_SESSION["vname"] . ' ' . $_SESSION["nname"] = $row->nname;

        $echo .= '<div class="card">
	   <div class="card-header" id="headingThree">
		   <h2 class="mb-0">
			  <div class="title_comment">
				 <i class="fa fa-user" aria-hidden="true"></i>
				 <p class="name_user">'.$name.' &nbsp; &nbsp; &nbsp;'.$row->date_time.'</p>
			  </div> 
		      <a type="button"
				   class="btn btn-link collapsed"
				   data-toggle="collapse"
				   data-target="#collapse' . $idNote . '">
				   <i class="fa fa-plus fa1"></i>
				   ' . $comment . '
			   </a>
		   </h2>
	   </div>
	   <div id="collapse' . $idNote . '" class="collapse"
		   aria-labelledby="headingThree"
		   data-parent="#accordionShowComment">
		   <div class="card-body">
				' . showCommentOfComment($show_comment, $idNote, 1) . '
			   <div class="block_comment open" id="block_comment_' . $idNote . '"><textarea class="message_comment" placeholder="Comment"></textarea>
			   <input type="submit" class="btn btn-info" value="Save"></div>
		   </div>
	   </div>
   </div>';
    }

    $echo .= '</div><input type="hidden" name="save" value="1"><input type="hidden" name="mediaId" value="' . $show_comment . '"><input type="hidden" name="parent_comment" id="parent_comment"><input type="hidden" name="message_comment" id="message_comment"></form>';

    if ($parent_comment > 0) {
        $echo .= '<script>
	                alert("ddd");
			      </script>';
    }

    return $echo;
}
// END

// VU: show comment of comment
function showCommentOfComment($show_comment, $parent, $level)
{
    $response = '';

	$defaultMarginLeft = 40;
	$marginLeft = $defaultMarginLeft * $level;

    $level++;

    $sql = "SELECT * FROM morp_note WHERE mediaID = $show_comment and parent = " . $parent . " ORDER BY date_time";
    //echo $sql . '////';
    $res = safe_query($sql);
    //echo mysqli_num_rows($res); die();

    while ($row = mysqli_fetch_object($res)) {
		$parentChild = $row->idNote;
		
		$name = $name = getNameFromID($row->uid);

		$comment = $row->message . '('.countComment($parentChild).')';
		
		$response .= '<h2 class="mb-0 mb-1" style="margin-left:'.$marginLeft.'px">
		               <a class="btn btn-link btn-link-1" parent="' . $parent . '" data-target="#collapse' . $parentChild . '"><div class="title_comment">
					   <i class="fa fa-user" aria-hidden="true"></i>
					   <p class="name_user">'.$name.' &nbsp; &nbsp; &nbsp;'.$row->date_time.'</p>
					 </div> <i class="fa fa-plus fa1"></i> ' . $comment . '</a>
					  </h2>';

        $response .= showCommentOfComment($show_comment, $parentChild, $level);

        $response .= '<div class="block_comment" id="block_comment_' . $parentChild . '"><textarea class="message_comment" placeholder="Comment"></textarea>
		              <input type="submit" class="btn btn-info" value="Save"></div>
	                 ';
    }

    return $response;
}
// END

if ($save) {
    $uid = $_SESSION['mid'];
    $date = date('y-m-d');

    $sql = 'insert into morp_note(uid, parent, mediaID, message, date_time)values(' . $uid . ', ' . $parent_comment . ', ' . $mediaId . ', "' . $message_comment . '", "' . $date . '")';
    safe_query($sql);

    $output = showComments($show_comment);
} else if ($edit) {
    $output .= edit($edit);
}

// VU: change design to show comment
else if ($show_comment) {
    $output .= showComments($show_comment);
} else {
    $output = list_comment();
}
// END

$output .= '
</form>
';
