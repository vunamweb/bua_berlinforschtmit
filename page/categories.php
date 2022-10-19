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

global $arr_form, $table, $tid, $filter, $nameField, $sortField, $imgFolderShort, $ebene, $parent, $morpheus, $cid, $navID;

$myauth = 10;
$stimmen_in = 'in';
$css = "style_blue.css";

$um_wen_gehts 	= "Chart";
$titel			= "Charts / Statistik";
///////////////////////////////////////////////////////////////////////////////////////
$table 		= 'morp_stimmen';
$tid 		= 'stID';
$nameField 	= "name";
$sortField 	= 'reihenfolge';

///////////////////////////////////////////////////////////////////////////////////////
$ebene = isset($_GET["ebene"]) ? $_GET["ebene"] : 1;
$parent = isset($_GET["parent"]) ? $_GET["parent"] : 0;

// VU: add request properties and base on that to add/delete audio
$add_properties = $_REQUEST['add_properties'];
$list_properties = $_REQUEST['list_properties'];
// END

// VU: add comment of comment
$save_note = $_REQUEST['save_note'];
$parent_comment = $_REQUEST['parent_comment'];
$message_comment = $_REQUEST['message_comment'];
$cid = $_REQUEST['cid'];
// END

// VU: show/add/delete audio
if ($add_properties) {
    $response = '';

    $sql = "SELECT * FROM `morp_media` WHERE 1 ORDER BY mediaID DESC";
    $res = safe_query($sql);

    while ($row = mysqli_fetch_object($res)) {
		$date = explode(" ", $row->mdate);
		$date = ' (' . euro_dat($date[0]) . ')';
		$description = ($row->mdesc != '') ? $row->mdesc . $date  : $row->mname . $date;
		$response .= '<div class="mrow"><input type="checkbox" value=' . ($row->mediaID) . ' id="m' . ($row->mediaID) . '" class="modal_checkbox_properties">&nbsp; &nbsp; &nbsp;<label for="m' . ($row->mediaID) . '">' . $description . '</label></div>';
    }

    echo $response;die();
} elseif ($list_properties) {
    $list = $_REQUEST['list'];
    $list = explode(";", $list);

    $delete = $_REQUEST['delete'];

    //print_r($list_user); die();

    foreach ($list as $item) {
        if ($item != '') {
            if (!$delete) {
                updateProperties($list_properties, $item);
            } else {
                deleteProperties($list_properties, $item);
            }

        }
    }

    die();
} 
// END


// $new = '<a href="?neu=1" class="btn btn-info"><i class="fa fa-plus"></i> NEU</a>';
$new = '<p class="button_add"><a href="?new=1&ebene='.$ebene.'&parent='.$parent.'" class="btn btn-info"><i class="fa fa-plus"></i> NEU</a></p>';
// VU: create audio add button and modal
$audio = '<p class="button_add"><a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-info add_properties"><i class="fa fa-plus"></i>AUDIO</a></p>';
$modal = '
<!-- The Modal -->
	<div class="modal" id="myModal">
	  <div class="modal-dialog">
		<div class="modal-content">

		  <!-- Modal Header -->
		  <div class="modal-header">
			<button type="button" class="btn close" data-dismiss="modal">&times;</button>
		  </div>

		  <!-- Modal body -->
		  <div class="modal-body">

		  </div>

		  <!-- Modal footer -->
		  <div class="modal-footer">
			<button type="submit" class="btn btn-info save_properties" data-dismiss="modal">Add</button>
			<button type="submit" class="btn btn-info delete_properties" data-dismiss="modal">Delete</button>
			<input type="hidden" value="" id="list">
		  </div>

		</div>
	  </div>
	</div>
';
// END

$output = '<div id=vorschau>
   <h2>'.$titel.'</h2>

	'. ($edit || $neu ? '<p><a href="?" class="btn btn-success">&laquo; zur&uuml;ck</a></p>' : '') .'
	<form action="" onsubmit="" name="verwaltung" method="post">
'.($edit || $neu ? '' : '').'
'.(!$edit && !$neu ? '' : '').'
';

// print_r($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////
#$sql = "ALTER TABLE  $table ADD  `fFirmenFilterID` INT( 11 ) NOT NULL";
#safe_query($sql);
/////////////////////////////////////////////////////////////////////////////////////////////////////

$arr_form = array(
//	array("reihenfolge", "Reihenfolge", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
	array("name", "Name", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
 	array("einfuehrungstext", "Einführungstext", '<textarea class="form-control" id="summernote" name="#n#">#v#</textarea>'),
 	array("text", "Aussagen", '<textarea class="form-control" id="summernote" name="#n#">#v#</textarea>'),
	 array("wert", "Gewichtung", '<input type="Text" value="#v#" class="form-control" name="#n#" style="width:120px;" />'),
 	
	array("", "CONFIG", '</div><div class="col-md-3 mb3 mt2">'),
	array("ebene", "Ebene", '<input type="Text" value="#v#" class="form-control" name="#n#"  style="width:120px" />', 'GET'),
	array("parent", "Parent", '<input type="Text" value="#v#" class="form-control" name="#n#"  style="width:120px" />', 'GET'),
	// VU: add mid
	array("mid", "", '<input type="hidden" value="#v#" class="form-control" name="#n#" />'),
	// END

#	array("word", "Buchstabe", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),

#	array("img2", "Foto 2", 'sel', 'image', 'imgname', 6, 'gid'),
#	array("img3", "Foto 3", 'sel', 'image', 'imgname', 6, 'gid'),

	array("", "CONFIG", '</div>'),
);

/*
//		array("", "CONFIG", '</div><div class="col-md-12 mb3 mt2">'),
//		array("img1", "Foto 1", 'img'),
		array("", "CONFIG", '</div></div>'),
*/

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

$neuerDatensatz = isset($_GET["new"]) ? $_GET["new"] : 0;
$edit = isset($_REQUEST["edit"]) ? $_REQUEST["edit"] : 0;
$save = isset($_REQUEST["save"]) ? $_REQUEST["save"] : 0;
$del = isset($_REQUEST["del"]) ? $_REQUEST["del"] : 0;
$delete = isset($_REQUEST["delete"]) ? $_REQUEST["delete"] : 0;
$back = isset($_POST["back"]) ? $_POST["back"] : 0;

$delimg = isset($_GET["delimg"]) ? $_GET["delimg"] : 0;

$down = isset($_GET["down"]) ? $_GET["down"] : 0;
$up = isset($_GET["up"]) ? $_GET["up"] : 0;
$col = isset($_GET["col"]) ? $_GET["col"] : 0;
$copy = isset($_GET["copy"]) ? $_GET["copy"] : 0;
$imgFolder = "../images/referenzen/";
$imgFolderShort = "referenzen/";

$repair = isset($_GET["repair"]) ? $_GET["repair"] : 0;
$vis = isset($_GET["vis"]) ? $_GET["vis"] : 0;
$sichtbar = isset($_GET["sichtbar"]) ? $_GET["sichtbar"] : 0;


///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

function liste() {
	global $arr_form, $table, $tid, $filter, $nameField, $sortField, $imgFolderShort, $ebene, $parent;

	//// EDIT_SKRIPT
	$ord = "$sortField";
	$anz = $nameField;

	////////////////////
	$where = "ebene=$ebene".($parent ? " AND parent=$parent " : "");
	// VU: select category of log in user
	//$where .= ' AND mid = '.$_SESSION["mid"].'';
	// END

	$echo .= '
	
	<p>&nbsp;</p>

	<p><a href="?repair=1&edit='.$edit.'&ebene='.$ebene.($parent ? "&parent=$parent" : "").'" class="button"><i class="fa fa-refresh"></i> repariere Sortierung</a></p>
	<!-- VU: add message information !-->
	<br><br>
	<p class="message_info"></p>
	<!-- END !-->

	</form>
<nav aria-label="breadcrumb" >
  <ul class="breadcrumb">
  ';
  
  	$bc_start = '<li class="breadcrumb-item"><a href="?ebene=1&parent=0">Start</a></li>';
	  
	if($ebene>1 && $parent) {		  
		$sql = "SELECT * FROM $table WHERE $tid=$parent";
		$res = safe_query($sql);
		$row = mysqli_fetch_object($res);
		$par = $row->parent;
		$breadcrumb = '<li class="breadcrumb-item""><a href="?ebene='.($ebene-1).'&parent='.$par.'">'.$row->name.'</a></li>';
		
		for($n=($ebene-1); $n>=2; $n--) {
			$sql = "SELECT * FROM $table WHERE $tid=$par";
			$res = safe_query($sql);
			$row = mysqli_fetch_object($res);
			$par = $row->parent;
			$breadcrumb = '<li class="breadcrumb-item"><a href="?ebene='.($n-1).'&parent='.$par.'">'.$row->name.'</a></li>'.$breadcrumb;
		}
	}

	$echo .= $bc_start.$breadcrumb.'
  </ul>
</nav>

<p>&nbsp;</p>

<div id="sortable" class="grid muuri">

';

	$sql = "SELECT * FROM $table WHERE $where ORDER BY ".$ord."";
	$res = safe_query($sql);
	
	// VU: if not categories
	if(mysqli_num_rows($res) == 0)
	  return '<br><br>No Categories';
	// END 

	while ($row = mysqli_fetch_object($res)) {
		$edit = $row->$tid;
		$echo .= '
	<div class="zeile item row"  id="'.$row->$tid.'">
			<div class="col-md-1 pull-left">
			    <!-- VU: add checkbox  !-->
			    <input type="checkbox" value="'.$edit.'" class="td_checkbox">
				<!-- END !-->
			</div>
			<div class="col-md-1 pull-left">
				<a href="?ebene='.($ebene+1).'&parent='.$edit.'" class="btn btn-info btn-smal"><i class="fa fa-level-down"></i></a>
			</div>
			<div class="col-md-1 pull-left">
				<a href="?edit='.$edit.'" class="btn btn-info btn-smal">
					<i class="fa fa-pencil-square-o"></i>
				</a>
			</div>			
			<div class="col-md-5 pull-left"> &nbsp; 
				<a href="?edit='.$edit.'">'.$row->$anz.' </a>
			</div>
			<div class="col-md-1 pull-left">
				'.$row->wert.'%
			</div>
			<div class="col-md-2pull-left"></div>
			<div class="col-md-1 text-right pull-right">
				<a href="?del='.$edit.'" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
			</div>
	</div>
';
	}

	$_SESSION["par"] = $parent;
	
	$echo .= '
</div>
<p>&nbsp;</p>
';
	
	
	$data = '
	<div class="container">
	<ul class="liste">';
	
		  
		// VU: select category of log in user
		//$sql = "SELECT * FROM $table WHERE ebene=1 AND mid = ".$_SESSION['mid']." ORDER BY $sortField";
		$sql = "SELECT * FROM $table WHERE ebene=1 ORDER BY $sortField";
		// END
		$res = safe_query($sql);
		$n = mysqli_num_rows($res);
		$percent = 100 / $n;
		$y = 0;
	// 		while ($row = mysqli_fetch_object($res)) {
	// 			if ($y) {
	// 				$data .= '
	// 				</ul>
	// ';
	// 			}
	// 			$wert = $row->wert;
	// 			$color = 'color'.$row->$tid;
	// 			$hover = 'hover'.$row->$tid;
	// 			$data .= '
	// 				<li class="row">
	// 					<div class="col-md-8">
	// 						<a href="?edit='.$row->$tid.'">'.$row->name.'<span> => '.$wert.'</span></a>
	// 					</div>
	// 					<div class="col-md-2 text-right">
	// 						<a href="?new=1&ebene=2&parent='.$row->$tid.'" class="btn btn-info"><i class="fa fa-plus"></i></a>
	// 					</div>						
	// 					<div class="col-md-2 text-right">
	// 						<a href="?del='.$row->$tid.'" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
	// 					</div>						
	// 				</li><ul>';
	// 			$data .= get_par($row->$tid, 2, $wert, $$color, $$hover);
	// 	  
	// 			$y++;
	// 		}
			
			
			$echo .= $data.'</ul></div>';

			if($_REQUEST['ebene'])
			  $echo .= showCategory(0);
	
	return $echo;
}

// VU: add function update/delete audio for each categories
function updateProperties($list_properties, $stID)
{
	$table = 'morp_stimmen_media';
	$field1 = 'stID';
	$field2 = 'mediaID';
	
	$list_properties = explode(";", $list_properties);

    foreach ($list_properties as $property) {
        if ($property != '') {
            // delete if exist
            $sql = 'delete from '.$table.' where '.$field1.' = ' . $stID . ' and '.$field2.' = ' . $property . '';
            //echo $sql; die();
            safe_query($sql);

            // insert
            $sql = 'insert into '.$table.'('.$field1.', '.$field2.')values(' . $stID . ', ' . $property . ')';
            echo $sql . '<br>';
            safe_query($sql);
        }
    }
}

function deleteProperties($list_properties, $stID)
{
	$table = 'morp_stimmen_media';
	$field1 = 'stID';
	$field2 = 'mediaID';

	$list_properties = explode(";", $list_properties);

    foreach ($list_properties as $property) {
        if ($property != '') {
            $sql = 'delete from '.$table.' where '.$field1.' = ' . $stID . ' and '.$field2.' = ' . $property . '';
            //echo $sql; die();
            safe_query($sql);
        }
    }
}
// END

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

function get_par($id, $ebene, $percent, $color, $hover)
{
	global $table, $tid, $sortField, $nameField, $dropdown;
	
	$sql = "SELECT * FROM $table WHERE ebene=$ebene AND parent=$id";
	$res = safe_query($sql);
	$n = mysqli_num_rows($res);
	
	if ($n) {
		$data = '';
		$next_ebene = $ebene+1;
  
		while ($row = mysqli_fetch_object($res)) {
			$this_id = $row->$tid;
 
			$wert = $row->wert / 100;
			$parent_percent = $percent * $wert;

			// is children?
			$sql = "SELECT * FROM $table WHERE ebene=$next_ebene AND parent=$this_id";
			$rs = safe_query($sql);
			$ebene_exists = mysqli_num_rows($rs);

			$dropdown .= '<option value="'.$row->name.'">'.$row->name.'</option>';

			if ($ebene_exists) {
				$data .= '
					<li class="row">
					<div class="col-md-8">
					   <!-- VU: add checkbox  !-->
					   <input type="checkbox" value="'.($row->$tid).'" class="td_checkbox">	
					   <!--  !-->
					   <a href="?edit='.$row->$tid.'">'.$row->name.'<span> => '.$parent_percent.'</span></a>
					</div>

					<div class="col-md-2 text-right">
						<a href="?new=1&ebene='.($ebene+1).'&parent='.$this_id.'" class="btn btn-info"><i class="fa fa-plus"></i></a>
					</div>						

					<div class="col-md-2 text-right">
						<a href="?del='.$row->$tid.'" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
					</div>						
				</li><ul>';
				$data .= get_par($this_id, $next_ebene, $parent_percent, $color, $hover);
				$data .= '
				</ul>
';
			} else {
				$data .= '
					<li class="row">
					<div class="col-md-8">
					   <!-- VU: add checkbox  !-->
					   <input type="checkbox" value="'.($row->$tid).'" class="td_checkbox">		
					   <!-- END !-->
					   <a href="?edit='.$row->$tid.'">'.$row->name.'<span> => '.$parent_percent.'</span></a>
					</div>
					<div class="col-md-2 text-right">
						<a href="?new=1&ebene='.($ebene+1).'&parent='.$this_id.'" class="btn btn-info"><i class="fa fa-plus"></i></a>
					</div>						
					<div class="col-md-2 text-right">
						<a href="?del='.$row->$tid.'" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
					</div>						
				</li>';
			}
		}
	}
	
	return $data;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

function edit($edit) {
	global $arr_form, $table, $tid, $imgFolder, $imgFolderShort, $um_wen_gehts, $ebene, $parent, $morpheus;

	$sql = "SELECT * FROM $table WHERE $tid=".$edit."";
	$res = safe_query($sql);
    $row = mysqli_fetch_object($res);
    
	//$echo = '<form action="" onsubmit="" name="verwaltung" method="post">';
	
	$echo .= '<a href="?" class="btn btn-success"><i class="fa fa-arrow-circle-left"></i> zurück</a><br><br>';

	$echo .= '
		<input type="Hidden" name="edit" value="'.$edit.'">
		<input type="Hidden" name="save" value="1">
		<input type="hidden" value="0" name="back" id="back" />

		<div class="row">
			<div class="col-md-9">

	';

	foreach($arr_form as $arr) {
		$echo .= setMorpheusForm($row, $arr, $imgFolderShort, $edit, 'morp_referenzen', $tid);
	}
	

	$echo .= '</div>
		</div>
 			<button type="submit" id="savebtn" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; '.$um_wen_gehts.' speichern / aktualisieren</button>
			<button type="submit" id="savebtn2" value="hier" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; '.$um_wen_gehts.' speichern und zurück</button>
		<div class="row mt3">
			<div class="col-md-12"><h5>zugewiesene Audiofiles</h5><hr></div>
		</div>
		<div class="row">
	';
	
	// BJORN: this is original - 
	// $medias = $row->media;
	// $medias = explode(",", $medias);
	// $sql = "SELECT * FROM `morp_media` WHERE ck02=1";
	// $res = safe_query($sql);
	// while($row = mysqli_fetch_object($res)) {
	// 	$echo .= '
	// 		<div class="col-md-1 mb2">
	// 			<label for="m'.$row->mediaID.'">
	// 				<input type="checkbox" name="media[]" id="m'.$row->mediaID.'" value="'.$row->mediaID.'"'.(in_array($row->mediaID, $medias) ? ' checked' : '').' />
	// 				'.$row->mediaID.'
	// 			</label>
	// 		</div>';
	// }
	
	$echo .= '
		
	</div>
	<div class="row">';
	
	
	// VU: get audio list of this category
	$sql = "SELECT * FROM morp_media m, morp_stimmen_media sm WHERE sm.mediaID = m.mediaID and sm.stID = ".$edit."";
	$res = safe_query($sql);
	while($row = mysqli_fetch_object($res)) {
		$date = ' (' . $row->mdate . ')';
		$description = ($row->text != '') ? $row->text . $date  : 'No description' . $date;
		
		$mediaID = $row->mediaID;
		$url = $morpheus['url'] . 'de/all-entries/?edit='.$mediaID.'';

		$echo .= '
			<div class="col-md-3 mb2" id="M'.$mediaID.'">
				<a href='.$url.' target="_blank">'.$description.'</a>
				<span class="delMediaFromCat btn btn-danger btn-small ml10" data-id="'.$edit.'" data-media="'.$mediaID.'"><i class="fa fa-trash-o"></i></span>
			</div>';
	}
	// END
	
	$echo .= '<hr>
		</div>
    </div>
    </form>	
';

   // VU: show comment list of this category
   $echo .= '<div class="row"><div class="col-md-12">
   		<h1 class="text-center small"><i>Diary</i></h1>' . '
   		<p><a href="'.$morpheus["url"].'de/diary/?neu=1&category='.$edit.'" class="btn btn-info"><i class="fa fa-plus"></i> Kommentar hinzufügen</a><br><br><p class="message_info"></p>
   		'.showComments(0, $edit).'
	</div></div>'; 
   // END

	return $echo;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

function neu() {
	global $arr_form, $table, $tid, $um_wen_gehts, $ebene, $parent;

	$x = 0;

	$echo .= '<a onclick="history.back()" class="btn btn-success"><i class="fa fa-arrow-circle-left"></i> zurück</a><br><br>';

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

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

if($save_note) {
	$uid = $_SESSION['mid'];
	$date = date("Y-m-d H:i:s");

	//$sql = 'insert into morp_note(uid, parent, mediaID, message, date_time)values(' . $uid . ', ' . $parent_comment . ', ' . $mediaId . ', "' . $message_comment . '", "' . $date . '")';
	$sql = 'insert into morp_note(uid, parent, mediaID, message, add_link, date_time)values(' . $uid . ', ' . $parent_comment . ', 0, "' . $message_comment . '", "'.$cid.'", "' . $date . '")';
	safe_query($sql);

	updateDateComment($parent_comment);

	$scriptname = $morpheus['url'] . 'de/' . $_REQUEST['hn'] . '/' . '?edit='.$_SESSION['category'].'';

	?>
	   <script>
		location.href='<?php echo $scriptname; ?>';
	  </script> 
	<?php
}

else if ($save) {
	$neu = isset($_POST["neu"]) ? $_POST["neu"] : 0;
	$edit = saveMorpheusForm($edit, $neu, 0, $zusatz);
	$scriptname = $morpheus['url'] . 'de/' . $_REQUEST['hn'] . '/';	
	$ebene = isset($_POST["ebene"]) ? $_POST["ebene"] : 1;
	$parent = isset($_POST["parent"]) ? $_POST["parent"] : 0;

	if($back) {
?>
	<script>
		location.href='<?php echo $scriptname; ?>?ebene=<?php echo $ebene; ?>&parent=<?php echo $parent; ?>';
	</script>
<?php
	}
	elseif($neu) {
?>
	<script>
		location.href='<?php echo $scriptname; ?>?edit=<?php echo $edit; ?>&ebene=<?php echo $ebene; ?>&parent=<?php echo $parent; ?>';
	</script>
<?php
	}

	// unset($edit);
}

elseif ($delimg) {
	deleteImage($delimg, $edit, $imgFolder, 0);
}

elseif($delete) {
	$sql = "DELETE FROM `$table` WHERE $tid=$delete ";
	safe_query($sql);
}

elseif($repair) {
	repair_stimmen();
}
elseif ($vis) {
	$sql = "UPDATE $table SET sichtbar=$sichtbar WHERE $tid=".$vis;
	safe_query($sql);
}
elseif($copy) {
	$sql  	= "SELECT * FROM $table WHERE $tid=$edit";
	$res 	= safe_query($sql);
	$y		= mysqli_num_rows($res);
	$y++;

	$sql  	= "SELECT * FROM $table WHERE $tid=$copy";
	$res 	= safe_query($sql);
	$row 	= mysqli_fetch_object($res);

	saveMorpheusForm($edit, 1, $row);

	repair_stimmen();
}

function repair_stimmen() {
	global $table, $sortField, $tid, $parent, $ebene;

	$arr	= array();
	$y 		= 0;
	$sql  	= "SELECT * FROM $table WHERE ebene=$ebene ".($parent ? " AND parent=$parent " : "")." ORDER BY ebene, parent, reihenfolge";
	$res 	= safe_query($sql);

	while ($rw = mysqli_fetch_object($res)) $arr[] = $rw->$tid;

	foreach ($arr as $val) {
		$y++;
		$sql  = "UPDATE $table SET $sortField=$y WHERE $tid=$val";
		safe_query($sql);
	}
}
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

if($up || $down) {
	if($down) { $sort1 = $down; $sort2 = $down+1; }
	elseif($up) { $sort1 = $up; $sort2 = $up-1; }

	$col1 = $col.$sort1;
	$col2 = $col.$sort2;

	$sql = "SELECT $col1, $col2 FROM $table WHERE $tid = $edit";
	$res = safe_query($sql);
	$row = mysqli_fetch_object($res);
	$file1 = $row->$col1;
	$file2 = $row->$col2;

	$sql = "UPDATE $table SET $col2='$file1', $col1='$file2' WHERE $tid = $edit";
	safe_query($sql);
}

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

if($del) {
	$output = '	<h2>Wollen Sie '.$um_wen_gehts.' wirklich löschen?</h2>
			<p>&nbsp;</p>
			<p><a href="?delete='.$del.'" class="btn btn-danger"><i class="fa fa-trash"></i> &nbsp; Ja</a>
			<a href="?" class="btn btn-info"><i class="fa fa-remove"></i> &nbsp; Nein / Abbruch</a></p>

';
}
elseif ($neuerDatensatz) 	$output .= neu("neu");
elseif ($edit) {
	// VU: create session here to redirect after saving on diary
	$_SESSION['category'] = $edit;
	$_SESSION['entry'] = 0;
	
	$output .= edit($edit);
} 
// VU: change position of new to top and add button audio
else						$output .= $new . $audio . $modal . liste();

$output .='
</form>
';
