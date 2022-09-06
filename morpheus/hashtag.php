<?php
# # # # # # # # # # # # # # # # # # # # # # # # # # #
# www.pixel-dusche.de                               #
# björn t. knetter                                  #
# start 12/2003                                     #
# edit 27.11.2006                                   #
# post@pixel-dusche.de                              #
# frankfurt am main, germany                        #
# # # # # # # # # # # # # # # # # # # # # # # # # # #
global $arr_form, $table, $tid, $filter, $nameField, $sortField, $imgFolderShort, $ebene, $parent, $morpheus;

$titel = "HashTag";
///////////////////////////////////////////////////////////////////////////////////////
$table = 'morp_hashtag';
$tid = 'htID';
$nameField = "name";
$sortField = 'name';

$new = '<a href="?neu=1" class="btn btn-info"><i class="fa fa-plus"></i> NEU</a><br><br>';

$output = '<div id=vorschau>
   <h2>' . $titel . '</h2>

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
    global $arr_form, $table, $tid, $filter, $nameField, $sortField;

    //// EDIT_SKRIPT
    $ord = "$sortField";
    $anz = $nameField;

    ////////////////////
	$where = "1";
	
    $sql = "SELECT * FROM $table WHERE $where ORDER BY " . $ord . "";
    $res = safe_query($sql);

    // VU: if not hashtag
    if (mysqli_num_rows($res) == 0) {
        return '<br><br>No HashTag';
    }
	// END
	
	$echo = '<table class="autocol p20 newTable" style="width:100%">';

    while ($row = mysqli_fetch_object($res)) {
        $edit = $row->$tid;
        $echo .= '
	<tr>
			<td>
				<a href="?edit=' . $edit . '">' . $row->$nameField . ' </a>
			</td>
			<td>
				<a href="?del=' . $edit . '" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
			</td>
	</div>
';
	}
	
	$echo .= '</table>';

    return $echo;
}

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