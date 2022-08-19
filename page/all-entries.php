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

$neu = $_REQUEST['neu'];
$save = $_REQUEST['save'];
$save_note = $_REQUEST['save_note'];
$myNote = $_REQUEST['myNote'];
$noteId = $_REQUEST['noteId'];
$show_comment = $_REQUEST['show_comment'];
$mediaId = $_REQUEST['mediaId'];
$parent_comment = $_REQUEST['parent_comment'];
$parent_comment = $_REQUEST['parent_comment'];
$message_comment = $_REQUEST['message_comment'];
$listHashtag = $_POST['listHashTag'];
$edit_entry = isset($_REQUEST["edit_entry"]) ? $_REQUEST["edit_entry"] : 0;
$edit = isset($_REQUEST["edit"]) ? $_REQUEST["edit"] : 0;
$cid = $_REQUEST['cid'];

// VU: add code for comment
// add comment for media
if ($myNote) {
    $sql = 'update morp_note set message = "'.$myNote.'" where idNote = '.$noteId.'';
    echo $sql;
    safe_query($sql);

    die();
}
// END

$output = '<div id=vorschau>
	<h2>' . $titel . '</h2>

	' . ($show_comment ? '<p><a href="?">&laquo; zur&uuml;ck</a></p><br>' : '') . '
	<form action="" onsubmit="" name="verwaltung" method="post">
' . ($edit || $neu ? '' : '') . '
' . (!$edit && !$neu ? '' : '') . '
';

// print_r($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////
#$sql = "ALTER TABLE  $table ADD  `textonline` text() NOT NULL";
#safe_query($sql);
/////////////////////////////////////////////////////////////////////////////////////////////////////

if($neu || $edit) {
    $arr_form = array(
        array("title", "Title", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
        array("message", "Message", '<textarea class="summernote form-control" name="#n#" />#v#</textarea>'),
        array("parent", "", '<input type="hidden" value="0" class="form-control" name="#n#" />'),
        array("uid", "", '<input type="hidden" value="#v#" class="form-control" name="#n#" />'),
        array("date_time", "", '<input type="hidden" value="#v#" class="form-control" name="#n#" />'),
        array("mediaID", "", '<input type="hidden" value="#v#" class="form-control" name="#n#" />'),
    );

    $table = 'morp_note';
    $tid = 'idNote';

} else 
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
				<a href="?edit_entry=' . $edit . '">' . $row->$tid . ' </a>
			</td>
			<td align="center">
				<a href="?edit_entry=' . $edit . '" data-toggle="tooltip" title="' . $frage . '">' . ($rubrik ? '<span class="label label-info">' . $rubrik . '</span>' : '-') . ' </a>
			</td>
			<td>
				<a ' . $target . ' href="' . $wavfile . '">' . $file . ($mp3exists ? ' &nbsp; <span class="label label-danger">MP3</span>' : '') . '</a>' . $player . '
			</td>
			<td>
				<a href="?edit_entry=' . $edit . '">' . ($row->online ? 'online' : 'x') . '</a>
			</td>
			<td>
				<a href="?edit_entry=' . $edit . '">' . $dauer . '</a>
			</td>
			<td>
				<a href="?edit_entry=' . $edit . '">' . substr($row->mdesc, 0, 30) . '</a>
			</td>
			<td>
				<a href="?edit_entry=' . $edit . '">' . substr($row->textonline, 0, 30) . '</a>
			</td>
			<td>
				<a href="?edit_entry=' . $edit . '">' . $row->dsgvo . ' </a>
			</td>
			<td>
				<a href="?edit_entry=' . $edit . '">' . $row->public . ' </a>
			</td>
			<td>
				<a href="?edit_entry=' . $edit . '">' . euro_dat($row->mdate) . ' </a>
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
    /*$echo = '<ul class="nav nav-tabs">
    <li><a data-toggle="tab" href="#view" class="active">View</a></li>
    <li><a data-toggle="tab" href="#comment">Comment</a></li>
   </ul>';*/

    $echo .= '<div class="tab-content">
   <div id="view" class="tab-pane fade active show">
     ' . liste() . '
   </div>';

   /*$echo .=
   '<div id="comment" class="tab-pane fade">
     ' . comment() . '
   </div>
 </div>';*/

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

    $echo .= '<p class="area_comment">Comments</p><br>' . '<a href="?neu=1&mediaID='.$edit.'" class="btn btn-info">
              <i class="fa fa-plus"></i> NEU</a><br><br><p class="message_info"></p>' . showComments($edit);

    return $echo;
}

if ($save) {
    global $morpheus;

    $neu = isset($_POST["neu"]) ? $_POST["neu"] : 0;

	$_POST['uid'] = $_SESSION['mid'];
	$_POST['parent'] = 0;
    $_POST['date_time'] = date("Y-m-d");
    $_POST['mediaID'] = $_SESSION['entry'];

	$edit = saveMorpheusForm($edit, $neu, 0);

    // update hashtag list
    updateHashtagNote($listHashtag, $edit);

    $scriptname = $morpheus['url'] . 'de/' . $_REQUEST['hn'] . '/' . '?edit_entry='.$_SESSION['entry'].'';

    ?>
      <script>
		location.href='<?php echo $scriptname; ?>';
	  </script>
    <?php
} 
elseif($save_note) {
    $uid = $_SESSION['mid'];
    $date = date('y-m-d');

    //$sql = 'insert into morp_note(uid, parent, mediaID, message, date_time)values(' . $uid . ', ' . $parent_comment . ', ' . $mediaId . ', "' . $message_comment . '", "' . $date . '")';
    $sql = 'insert into morp_note(uid, parent, mediaID, message, add_link, date_time)values(' . $uid . ', ' . $parent_comment . ', ' . $mediaId . ', "' . $message_comment . '", "'.$cid.'", "' . $date . '")';
    safe_query($sql);

    $output = showComments($mediaId);
}
elseif ($edit_entry) {
    $output .= edit($edit_entry);
    $_SESSION['entry'] = $edit_entry;
}
elseif($edit)
  $output .= editComment($edit, false);

// VU: change design to show comment
else if ($neu) {
    $output .= addComment(false);
} else {
    $output = list_comment();
}
// END

$output .= '
</form>
';
