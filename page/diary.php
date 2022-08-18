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

include "morpheus/_tinymce.php";

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
	array("title", "Title", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
	array("message", "Message", '<textarea class="summernote form-control" name="#n#" />#v#</textarea>'),
	array("parent", "", '<input type="hidden" value="#v#" class="form-control" name="#n#" />'),
	array("uid", "", '<input type="hidden" value="#v#" class="form-control" name="#n#" />'),
	array("date_time", "", '<input type="hidden" value="#v#" class="form-control" name="#n#" />'),
);
///////////////////////////////////////////////////////////////////////////////////////
$neuerDatensatz = isset($_GET["neu"]) ? $_GET["neu"] : 0;
$edit = isset($_REQUEST["edit"]) ? $_REQUEST["edit"] : 0;
$save = isset($_REQUEST["save"]) ? $_REQUEST["save"] : 0;
$save_note = isset($_REQUEST["save_note"]) ? $_REQUEST["save_note"] : 0;
$del = isset($_REQUEST["del"]) ? $_REQUEST["del"] : 0;
$delete = isset($_REQUEST["delete"]) ? $_REQUEST["delete"] : 0;
$back = isset($_POST["back"]) ? $_POST["back"] : 0;
$listHashtag = $_POST['listHashTag'];
$listCategories = $_POST['listCategories'];
$mediaId = $_REQUEST['mediaId'];
$parent_comment = $_REQUEST['parent_comment'];
$message_comment = $_REQUEST['message_comment'];
$myNote = $_REQUEST['myNote'];
$noteId = $_REQUEST['noteId'];
$search_combine = $_REQUEST['search_combine'];
$hashtags = $_REQUEST['hashtags'];
$categories = $_REQUEST['categories'];

// VU: update comment text
if ($myNote) {
    $sql = 'update morp_note set message = "'.$myNote.'" where idNote = '.$noteId.'';
    echo $sql;
    safe_query($sql);

    die();
}
// END

// VU: search
if($search_combine) {
	$hashtags = explode(',', $hashtags);
    $categories = explode(',', $categories);

    $sql = "select mid from morp_intranet_user_allocation where ( ";
    if (count($hashtags) > 1) {
        for ($count = 0; $count < count($hashtags); $count++) {
            if ($hashtags[$count]) {
                if ($count < (count($hashtags) - 2)) {
                    $sql .= 'property = ' . $hashtags[$count] . ' or ';
                } else {
                    $sql .= 'property = ' . $hashtags[$count] . '';
                }

            }
        }
    }

    $sql .= ')';
    $sql .= ' group by mid';
    $sql .= ' having count(mid) = ' . (count($hashtags) - 1) . ' ';

    $where = '';

    // if search for both GH AND BC 
    //echo $BC . '/' . $GH; die();
	$search_project = "";
	if($BC && $GH) $search_project = " AND (BC=$BC AND GH=$GH )";
	else if($BC) $search_project = " AND BC=$BC ";
	else if($GH) $search_project = " AND GH=$GH ";
	
    //if((string) $GH != 'null' && (string) $BC != 'null')
    $que = "SELECT * FROM `morp_intranet_user` g WHERE
			(g.nname like '%" . $search_value . "%' OR g.vname like '%" . $search_value . "%')
            " . $search_project . "
            ";
    if (count($hashtags) > 1) {
        $que .= " AND g.mid in ($sql)";
    }

    $que .= 'ORDER BY g.mid DESC';
}
// END

///////////////////////////////////////////////////////////////////////////////////////
function liste()
{
    return showComments(0);
}

function search()
{
	$hashtag = '<div class="col-md-2 col-filter"><select name="select" class="ui selection hashtag" multiple=""><option value="">HashTag</option>';

    $sql = "SELECT * FROM morp_hashtag WHERE 1";
	$res = safe_query($sql);
	
    while ($row = mysqli_fetch_object($res)) {
        $property = $row->name;
		$mpid = $row->htID;
		
        $hashtag .= '<option value="' . $mpid . '">' . $property . '</option>
	';
	}
	
	$hashtag .= '</select></div>';
	
	$categories = '<div class="col-md-2 col-filter"><select name="select" class="ui selection categories" multiple=""><option value="">Category</option>';

    $sql = "SELECT * FROM morp_stimmen WHERE 1";
	$res = safe_query($sql);
	
    while ($row = mysqli_fetch_object($res)) {
        $property = $row->name;
		$mpid = $row->stID;
		
        $categories .= '<option value="' . $mpid . '">' . $property . '</option>
	';
	}
	
    $categories .= '</select></div>';

    $form = '<hr>';

    $form .= '<div class="row"><form class="navbar-form" role="search" method="get">';
    $form .= '<div class="col-md-2 ui left icon input">
	  <input type="text" name="suche" id="suche" placeholder="Suche nach Name">
	</div>';

	$form .= $hashtag;
	$form .= $categories;

    //$form .= $select_interests;
    $form .= '<div class="col-md-2"><button type="submit" value="Suchen" class="btn btn-info btn-submit-search">Filter</button></div>';
    $form .= '</form></div>';

    $form .= '<hr class="mt2">';

    return $form;
} 

/////////////////////////////////////////////////////////////////////////////////////////////////////
if ($save) {
	$neu = isset($_POST["neu"]) ? $_POST["neu"] : 0;

	$_POST['uid'] = $_SESSION['mid'];
	$_POST['parent'] = 0;
	$_POST['date_time'] = date("Y-m-d");

	$edit = saveMorpheusForm($edit, $neu, 0);

    // update hashtag list
	updateHashtagNote($listHashtag, $edit);
	
	// update categories list
	updateCategoriesNote($listCategories, $edit);

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
}
elseif($save_note) {
	$uid = $_SESSION['mid'];
    $date = date('y-m-d');

    $sql = 'insert into morp_note(uid, parent, mediaID, message, date_time)values(' . $uid . ', ' . $parent_comment . ', ' . $mediaId . ', "' . $message_comment . '", "' . $date . '")';
    safe_query($sql);

    $output = $new . liste();
} 
elseif ($delete) {
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
    $output .= addComment(true);
} elseif ($edit) {
    $output .= editComment($edit, true);
} else
    $output .= $new . search() . '<p class="message_info"></p>' . liste();

$output .= '
</form>
';
?>