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

global $arr_form, $table, $tid, $filter, $nameField, $sortField, $imgFolderShort, $ebene, $parent, $morpheus;

$titel = "Diary";
///////////////////////////////////////////////////////////////////////////////////////
$table = 'morp_note';
$tid = 'idNote';
$nameField = "title";
$sortField = 'title';

$new = '<a href="?neu=1" class="btn btn-info"><i class="fa fa-plus"></i> NEU</a><br><br>';

$output = '<div id=vorschau>
   <h2>' . $titel . ' &nbsp; <img src="images/flag-de.jpg" style="height:30px;"></h2>

	' . ($edit || $neu ? '<p><a href="?">&laquo; zur&uuml;ck</a></p>' : '') . '
	<form action="" onsubmit="" name="verwaltung" method="post">
' . ($edit || $neu ? '' : '') . '
' . (!$edit && !$neu ? '' : '') . '
';
/////////////////////////////////////////////////////////////////////////////////////////////////////
$arr_form = array(
    array("name", "Name", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
);
///////////////////////////////////////////////////////////////////////////////////////
$neuerDatensatz = isset($_GET["neu"]) ? $_GET["neu"] : 0;
$edit = isset($_REQUEST["edit"]) ? $_REQUEST["edit"] : 0;
$save = isset($_REQUEST["save"]) ? $_REQUEST["save"] : 0;
$del = isset($_REQUEST["del"]) ? $_REQUEST["del"] : 0;
$delete = isset($_REQUEST["delete"]) ? $_REQUEST["delete"] : 0;
$back = isset($_POST["back"]) ? $_POST["back"] : 0;

///////////////////////////////////////////////////////////////////////////////////////
function liste()
{
    return showComments();
}

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

// VU: show comment
function showComments()
{
    global $morpheus;

	$url = $morpheus['url'] . 'de/' . $_REQUEST['hn'] . '/?show_comment=' . $show_comment . '';
	
	$echo = '<form method="post" action="' . $url . '"><div class="accordion" id="accordionShowComment">';

    $sql = "SELECT * FROM morp_note WHERE parent = 0 ORDER BY date_time";
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
				' . showCommentOfComment($idNote, 1) . '
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
function showCommentOfComment($parent, $level)
{
    $response = '';

	$defaultMarginLeft = 40;
	$marginLeft = $defaultMarginLeft * $level;

    $level++;

    $sql = "SELECT * FROM morp_note WHERE parent = " . $parent . " ORDER BY date_time";
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

        $response .= showCommentOfComment($parentChild, $level);

        $response .= '<div class="block_comment" id="block_comment_' . $parentChild . '"><textarea class="message_comment" placeholder="Comment"></textarea>
		              <input type="submit" class="btn btn-info" value="Save"></div>
	                 ';
    }

    return $response;
}
// END

function neu() {
	global $arr_form, $table, $tid, $um_wen_gehts, $ebene, $parent;

	$x = 0;

	$echo .= '<a onclick="history.back()"><i class="fa fa-arrow-circle-left"></i> zurück</a><br><br>';

    $echo .= '<input type="Hidden" name="neu" value="1"><input type="Hidden" name="save" value="1">
<input type="hidden" value="'.$ebene.'" class="form-control" name="ebene" readonly="" style="width:120px">
<input type="hidden" value="'.$parent.'" class="form-control" name="parent" readonly="" style="width:120px">

	<table cellspacing="6" style="width:100%;">';

	foreach($arr_form as $arr) {
		if($arr[3]=="GET") $get=$_GET[$arr[0]];
		if ($x < 3) $echo .= '<tr>
			<td>'.$arr[1].':</td>
			<td>'. str_replace(array("#v#", "#n#", "#s#"), array($get, $arr[0], 'width:400px;'), $arr[2]).'</td>
		</tr>';
		$x++;
	}

	$echo .= '<tr>
		<td></td>
		<td>
			<br>
			<button type="submit" id="savebtn" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; '.$um_wen_gehts.' speichern</button>
		</td>
	</tr>
</table>';


	return $echo;
}

function edit($edit)
{
    global $arr_form, $table, $tid, $imgFolder, $imgFolderShort, $um_wen_gehts, $ebene, $parent, $morpheus;

    $sql = "SELECT * FROM $table WHERE $tid=" . $edit . "";
    $res = safe_query($sql);
    $row = mysqli_fetch_object($res);

    //$echo = '<form action="" onsubmit="" name="verwaltung" method="post">';

    $echo .= '<a onclick="history.back()"><i class="fa fa-arrow-circle-left"></i> zurück</a><br><br>';

    $echo .= '
		<input type="Hidden" name="edit" value="' . $edit . '">
		<input type="Hidden" name="save" value="1">
		<input type="hidden" value="0" name="back" id="back" />

		<div class="row">
			<div class="col-md-9">

	';

    foreach ($arr_form as $arr) {
        $echo .= setMorpheusForm($row, $arr, $imgFolderShort, $edit, 'morp_referenzen', $tid);
    }

    $echo .= '</div>
		</div>
 			<button type="submit" id="savebtn" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; ' . $um_wen_gehts . ' speichern / aktualisieren</button>
			<button type="submit" id="savebtn2" value="hier" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; ' . $um_wen_gehts . ' speichern und zurück</button>
		<div class="row mt3">
	';

    $echo .= '
		</div>
    </div>
    </form>
';

    return $echo;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////
if ($save) {
	$neu = isset($_POST["neu"]) ? $_POST["neu"] : 0;

    $edit = saveMorpheusForm($edit, $neu, 0);

    // if(neu) unset($neu);

    $scriptname = $morpheus['url'] . 'de/' . $_REQUEST['hn'] . '/';

    if ($back || $new) {
        ?>
	<script>
		location.href='<?php echo $scriptname; ?>';
	</script>
<?php
} else{
        ?>
	<script>
		location.href='<?php echo $scriptname; ?>?edit=<?php echo $edit ?>';
	</script>
<?php
}
} elseif ($delete) {
    $sql = "DELETE FROM `$table` WHERE $tid=$delete ";
	safe_query($sql);
	
	$output .= $new . liste();
}
///////////////////////////////////////////////////////////////////////////////////////
elseif ($del) {
    $output = '	<h2>Wollen Sie ' . $um_wen_gehts . ' wirklich löschen?</h2>
			<p>&nbsp;</p>
			<p><a href="?delete=' . $del . '" class="btn btn-danger"><i class="fa fa-trash"></i> &nbsp; Ja</a>
			<a href="?" class="btn btn-info"><i class="fa fa-remove"></i> &nbsp; Nein / Abbruch</a></p>

';
} elseif ($neuerDatensatz) {
    $output .= neu("neu");
} elseif ($edit) {
    $output .= edit($edit);
} else
    $output .= $new . liste();

$output .= '
</form>
';
?>