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

//include "morpheus/_tinymce.php";

global $arr_form, $table, $tid, $filter, $nameField, $sortField, $imgFolderShort, $ebene, $parent, $morpheus, $show;

$titel = "Diary";
///////////////////////////////////////////////////////////////////////////////////////
$table = 'morp_note';
$tid = 'idNote';
$nameField = "title";
$sortField = 'title';

$new = '<a href="?neu=1" class="btn btn-info"><i class="fa fa-plus"></i> NEU</a>
        <a href="#" class="btn btn-info" data-toggle="modal" data-target="#show_export">EXPORT</a><br><br>
       ';

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
$search_value = $_REQUEST['search_value'];
$hashtags = $_REQUEST['hashtags'];
$categories = $_REQUEST['categories'];
$cid = $_REQUEST['cid'];
$show = $_REQUEST['show'];
$show_list_media = $_REQUEST['show_list_media'];
$idCategory = $_REQUEST['idCategory'];
$action_export = $_REQUEST['action_export'];
$category_select = $_REQUEST['category_select'];
$media_select = $_REQUEST['media_select'];

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

    // hashtag
    $sql = "select idNote from morp_note_hashtag where ( ";
    if (count($hashtags) > 1) {
        for ($count = 0; $count < count($hashtags); $count++) {
            if ($hashtags[$count]) {
                if ($count < (count($hashtags) - 2)) {
                    $sql .= 'idHashtag = ' . $hashtags[$count] . ' or ';
                } else {
                    $sql .= 'idHashtag = ' . $hashtags[$count] . '';
                }

            }
        }
    }

    $sql .= ')';
    $sql .= ' group by idNote';
    $sql .= ' having count(idNote) = ' . (count($hashtags) - 1) . ' ';
    // end

    // category
    $sql1 = "select idNote from morp_note_stimmen where ( ";
    if (count($categories) > 1) {
        for ($count = 0; $count < count($categories); $count++) {
            if ($categories[$count]) {
                if ($count < (count($categories) - 2)) {
                    $sql1 .= 'idStimmen = ' . $categories[$count] . ' or ';
                } else {
                    $sql1 .= 'idStimmen = ' . $categories[$count] . '';
                }

            }
        }
    }

    $sql1 .= ')';
    $sql1 .= ' group by idNote';
    $sql1 .= ' having count(idNote) = ' . (count($categories) - 1) . ' ';
    // end


    //if((string) $GH != 'null' && (string) $BC != 'null')
    $que = "SELECT * FROM `morp_note` g WHERE
			(g.title like '%" . $search_value . "%' OR g.message like '%" . $search_value . "%')
            ";
    if (count($hashtags) > 1) {
        $que .= " AND g.idNote in ($sql)";
    }

    if (count($categories) > 1) {
        $que .= " AND g.idNote in ($sql1)";
    }

    $que .= 'ORDER BY g.date_time DESC';

    echo showComments(0, 0, $que); die();
}
// END

// VU: show list media of category
if($show_list_media) {
    $response = '';

    $sql = "SELECT * FROM morp_media mm, morp_stimmen_media msm WHERE mm.mediaID = msm.mediaID and msm.stID = ".$idCategory."  ORDER BY mm.mdate desc";
    $res = safe_query($sql);
    
    if(mysqli_num_rows($res) == 0) {
        echo 'No Media';
        die();
    }

    while ($row = mysqli_fetch_object($res)) {
		$date = ' (' . $row->mdate . ')';
		$description = ($row->text != '') ? $row->text . $date  : 'No description' . $date;
		$response .= '<div><input type="checkbox" value=' . ($row->mediaID) . ' class="modal_checkbox_properties">&nbsp; &nbsp; &nbsp;<label>' . $description . '</label></div>';
    }

    echo $response;die();
}
// END

// VU: export 
if($action_export) {
   
    $sql = ($media_select != '') ? getSqlMediaExport($media_select) : getSqlCategoryExport($category_select);
    //echo $sql;

    header("Content-type: application/vnd.ms-word");
    header("Content-Disposition: attachment;Filename=detail_comment.doc");

    echo '<html>' . '<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">' . '<body>' . showCommentExport(0, 0, $sql) . '</body>' . '</html>';
    die();
}
// END

// VU: get sql if select media of export
function getSqlMediaExport($media_select) {
    $media_select = explode(',', $media_select);
    $in = '(';

    for($i = 0; $i < count($media_select); $i++)
        if($i < count($media_select) -2)
        $in .= $media_select[$i] . ',';
    else
        $in .= $media_select[$i];

    $in .= ')';    
        
    $sql = ($in != '()') ? "SELECT * FROM morp_note WHERE parent = 0 and mediaID in ".$in." ORDER BY date_time desc" : "SELECT * FROM morp_note WHERE parent = 0 and mediaID in (null) ORDER BY date_time desc";
		    
    return $sql;
}
// END

// VU: get sql category of export
function getSqlCategoryExport($category_select) {
   $sql = "SELECT * FROM morp_note mn, morp_note_stimmen mns WHERE mn.parent = 0 and mns.idStimmen = ".$category_select."
   and mns.idNote = mn.idNote";

   return $sql;
}
// END

///////////////////////////////////////////////////////////////////////////////////////
function liste()
{
    global $show;

    // modal show media
  $modal = '<div class="modal" id="show_list_media" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
          <!-- Modal body -->
          <div class="modal-body">
              <div class="data"></div>
              <br><br>
              <input type="button" class="btn btn-info" name="add_media_category" id="add_media_category" value="ADD"/>
          </div>
      </div>
  </div>
</div>';

    // modal show category
    $modal .= '<div class="modal" id="show_export" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
                '.showExport().'
                <br><br>
                <input type="hidden" id="category_select" name="category_select" />
                <input type="hidden" id="media_select" name="media_select" />
                <input type="hidden" name="action_export" value="1" />
                <input type="submit" class="btn btn-info" name="export_list" id="export_list" value="Export"/>
			</div>
		</div>
	</div>
  </div>';

  if($show) {
        $sql = 'select * from morp_note where parent = 0 and idNote = '.$show.'';
        //echo $sql;

        return showComments(0, 0, $sql) . $modal;
    }

    return showComments(0) . $modal;
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

    $form .= '<div class="row">';
    $form .= '<div class="col-md-2 ui left icon input">
	  <input type="text" name="suche" id="suche" placeholder="Suche nach Name">
	</div>';

	$form .= $hashtag;
	$form .= $categories;

    //$form .= $select_interests;
    $form .= '<div class="col-md-2"><input value="Filter" class="btn btn-info btn-submit-search navbar-form"></div>';
    $form .= '</div>';

    $form .= '<hr class="mt2">';

    return $form;
} 

/////////////////////////////////////////////////////////////////////////////////////////////////////
if ($save) {
    $neu = isset($_POST["neu"]) ? $_POST["neu"] : 0;

	$_POST['uid'] = $_SESSION['mid'];
	$_POST['parent'] = 0;
	$_POST['date_time'] = date("Y-m-d H:i:s");

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
    $date = date("Y-m-d H:i:s");

    $sql = 'insert into morp_note(uid, parent, mediaID, message, add_link, date_time)values(' . $uid . ', ' . $parent_comment . ', ' . $mediaId . ', "' . $message_comment . '", "'.$cid.'", "' . $date . '")';
    //echo $sql; die();
    safe_query($sql);

    updateDateComment($parent_comment);

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
    $output .= $new . search() . '<p class="message_info"></p>' . '<div id="list_comment">' . liste() . '</div>';

$output .= '
</form>
';
?>