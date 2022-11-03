<?php
# # # # # # # # # # # # # # # # # # # # # # # # # # #
# www.pixel-dusche.de                               #
# björn t. knetter                                  #
# start 12/2003                                     #
# edit 27.11.2006                                   #
# post@pixel-dusche.de                              #
# frankfurt am main, germany                        #
# # # # # # # # # # # # # # # # # # # # # # # # # # #

require_once 'morpheus/getid3/getid3.php';

global $arr_form, $table, $tid, $filter, $nameField, $js, $morpheus, $dir;

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

# print_r($_SESSION);
# print_r($_REQUEST);
# print_r($_POST);

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

$new = $_REQUEST['neu'];
$save = $_REQUEST['save'];
$save_media = $_POST["save_media"];
$save_new = $_POST["save_new"];
$save_note = $_REQUEST['save_note'];
$myNote = $_REQUEST['myNote'];
$noteId = $_REQUEST['noteId'];
$show_comment = $_REQUEST['show_comment'];
$mediaId = $_REQUEST['mediaId'];
$parent_comment = $_REQUEST['parent_comment'];
$message_comment = $_REQUEST['message_comment'];
$listHashtag = $_POST['listHashTag'];
$edit = isset($_REQUEST["edit"]) ? $_REQUEST["edit"] : 0;
$cid = $_REQUEST['cid'];
$del = $_GET['del'];
$delete = $_GET['delete'];

// VU: add code for comment
// add comment for media
if ($myNote) {
	$sql = 'update morp_note set message = "'.$myNote.'" where idNote = '.$noteId.'';
	// echo $sql;
	safe_query($sql);
	die();
}
// END

$output = '<div id="vorschau">
	<h2>' . $titel . '</h2>

	' . ($show_comment ? '<p><a href="?">&laquo; zur&uuml;ck</a></p><br>' : '') . '
	<form name="verwaltung" method="post">
' . ($edit || $neu ? '' : '') . '
' . (!$edit && !$neu ? '' : '') . '
';

// print_r($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////
#$sql = "ALTER TABLE  $table ADD  `textonline` text() NOT NULL";
#safe_query($sql);
/////////////////////////////////////////////////////////////////////////////////////////////////////

if($new)	
	$arr_form = array(
		array("mdesc", "Kurz-Beschreibung", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
		array("mdate", "Datum", '<input type="Text" value="#v#" class="form-control" name="#n#" />', 'date'),
		array("name", "Name", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
		array("email", "Email", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
		array("text", "Audio zu Text / Textkommentar", '<textarea class="form-control" name="#n#" />#v#</textarea>'),	
	);
else if($edit) {
	$sql = "SELECT * FROM $table WHERE $tid=" . $edit . "";
	$res = safe_query($sql);
	$row = mysqli_fetch_object($res);
	$mtyp = $row->mtyp;

	$arr_form = array(
		array("", "CONFIG", '<div style="background:#99cc00; margin-bottom:1em; padding: 1em;">'),
		array("online", "Für Webseite freischalten ", 'chk', ),
		array("", "CONFIG", '</div>'),
		array("mname", ($mtyp ? 'Dateiname WAV' : 'HIDDEN'), '<input type="'.($mtyp ? 'Text' : 'hidden').'" value="#v#" class="form-control" name="#n#" readonly />'),
		array("mdesc", "Kurz-Beschreibung", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
		array("mdate", "Datum", '<input type="Text" value="#v#" class="form-control" name="#n#" />', 'date'),
		array("name", "Name", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
		array("email", "Email", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
		array("", "CONFIG", '<save></div><div class="col-md-6 mb3 mt2"><hr>'),
		
		array("text", "Audio zu Text / Textkommentar", '<textarea class="form-control" name="#n#" />#v#</textarea>'),	
		array("textonline", "Online Version öffentlich", '<textarea class="form-control" name="#n#" />#v#</textarea>'),
		//array("mname", "MP3", 'file'),
		array("", "CONFIG", '<hr><p>Vom Teilnehmer gesetzte Angagen zur Veröffentlichung und Newsletter</p>'),
		array("ck02", "Tonaufnahme / Text veröffentlichen", 'chk'),
		array("ck03", "Newsletter", 'chk'),
		array("ck01", "DSGVO", 'chk'),
	
		// array("dsgvo", "DSGVO", 'dropdown_array', array("true" => "true", "false" => "false")),
		// array("public", "Darf veröffenlicht werden", 'dropdown_array', array("true" => "true", "false" => "false")),
	
	//        array("", "CONFIG", '</div><div class="col-md-12 mb3 mt2">'),
	//        array("img1", "Foto 1", 'img'),
		array("", "CONFIG", '</div></div>'),
	);
}

function liste()
{
	global $arr_form, $table, $tid, $filter, $nameField, $morpheus;

	// install get information from file
	$getID3 = new getID3;

	//// EDIT_SKRIPT
	$ord = "$tid DESC";
	$anz = $nameField;
	
	$sstring = isset($_GET["sstring"]) ? $_GET["sstring"] : '';
	////////////////////
	$where = $sstring ? "( `mdesc` LIKE '%$sstring%' OR `text` LIKE '%$sstring%' OR `textonline` LIKE '%$sstring%' OR `name` LIKE '%$sstring%' OR `email` LIKE '%$sstring%' ) " : 1;

	$echo .= '
	
	<div class="row">
	<div class="col-md-6">
		<p><a href="?neu=1" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp; Neue Nachricht hinzufügen</a></p>
	</div>
	<div class="col-md-6">
		<form method="get">
			<input type="text" class="form-control" value="'.$sstring.'" style="width:250px;float:left" placeholder="suche" name="sstring"> &nbsp; 
			<button type="submit" class="btn"><i class="fa fa-search"></i></button>
		<form>
	</div>
	</div>
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
		<th>Art</th>
		<th>online</th>
		<th>Dauer</th>
		<th>Name</th>
		<th>E-Mail</th>
		<th>Kurz Beschreibung</th>
		<th>Datum</th>
	</tr>';

	$sql = "SELECT * FROM $table WHERE $where ORDER BY " . $ord . "";
	$res = safe_query($sql);
	//echo mysqli_num_rows($res); die();

	while ($row = mysqli_fetch_object($res)) {
		$edit = $row->$tid;
		$rubrik = $row->rubrik;
		$mtyp = $row->mtyp;
		$dauer = '';
		$mp3exists = 0;
		$player = '';
		if($mtyp || $row->mp3) {			
			$file = substr($row->$anz, 0, strlen($row->$anz) - 4);

			$wavfile = (strpos($row->mname, 'wav') || strpos($row->mname, 'mp3')) ? $morpheus['url'] . 'wav/' . $row->mname : '#';
			//$wavfile = (strpos($row->mname, 'mp3')) ? $morpheus['url'] . 'wav/' . $row->mname : '#';
			
			$filename = $dir.'mp3/' . $row->mp3;
			$target = (strpos($row->mname, 'wav') || strpos($row->mname, 'mp3')) ? 'target="_blank"' : '';
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
				$filename = $dir.'wav/' . $row->$anz;
				$ThisFileInfo = $getID3->analyze($filename);
				$dauer = $ThisFileInfo['playtime_string'];
				$dauer = duplicate_time($dauer);
				//return 'nambuzz';
			}
		}

		// if ($rubrik) {
		// 	$frage = get_db_field($rubrik, 'frage', 'morp_stimmen_kategorie', 'stkID');
		// } else {
		// 	$frage = '';
		// }

		$echo .= '<tr>
			<td width="50" align="center">
				<a href="?edit=' . $edit . '">' . $row->$tid . ' </a>
			</td>
			<td>
				'.( $mtyp || $row->mp3 ? '<a ' . $target . ' href="' . $wavfile . '">' : '') . ($mtyp ? '<i class="fa fa-microphone"></i>' : '<i class="fa fa-language"></i>') . ($mp3exists ? ' &nbsp; <span class="label label-danger">MP3</span>' : '') . ($mtyp ? '</a>' : '') . $player . '
			</td>
			<td>
				<a href="?edit=' . $edit . '">' . ($row->ck02 ? 'x' : '-') . '</a>
			</td>
			<td>
				<a href="?edit=' . $edit . '">'. $dauer . '</a>
			</td>
			<td>
				<a href="?edit=' . $edit . '">'. $row->name . '</a>
			</td>
			<td>
				<a href="?edit=' . $edit . '">'. $row->email . '</a>
			</td>
			<td>
				<a href="?edit=' . $edit . '">' . substr($row->mdesc, 0, 100) . '</a>
			</td>
			<td>
				<a href="?edit=' . $edit . '">' . euro_dat($row->mdate) . ' </a>
			</td>
			<td>
			
					<button type="button" class="btn btn-danger small" data-toggle="modal" data-target="#deleteModal_'.$edit.'">
			  		<i class="fa fa-trash-o"></i>
					</button>
									
					<div class="modal fade modal-sm" id="deleteModal_'.$edit.'" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
			  		<div class="modal-dialog">
						<div class="modal-content">
				  		<div class="modal-body">
							<b>Teilnehmer Meinung</b> wirklich löschen?<br><br>
							<i>Was soll mit den Diary Einträgen passieren?</i> 
				  		</div>
				  		<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<a href="?delete='.$edit.'" class="btn btn-primary">Löschen</a>
				  		</div>
						</div>
			  		</div>
					</div>
			
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
	// echo $dauer . '<br>';
	return $dauer;
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
	global $arr_form, $table, $tid, $imgFolder, $um_wen_gehts, $neu, $morpheus, $dir;

	$sql = "SELECT * FROM $table WHERE $tid=" . $edit . "";
	$res = safe_query($sql);
	$row = mysqli_fetch_object($res);
	
	$scriptname = $morpheus['url'] . 'de/' . $_REQUEST['hn'] . '/';

	$mtyp = $row->mtyp;
	
	if($mtyp || $row->mp3) {			
		$file = substr($row->$anz, 0, strlen($row->$anz) - 4);
		$wavfile = (strpos($row->mname, 'wav')) ? $morpheus['url'] . 'wav/' . $row->mname : '#';
		$filename = $dir.'mp3/' . $row->mp3;
		$wav = $dir.'wav/' . $row->mname;
		// if (file_exists($wav)) echo '########';
		
		$mp3exists = 0;
		if ($row->mp3) {
			$mp3exists = 1;
			$player = '<audio controls src="' . $filename . '"></audio>';
			$player .= '<a href="#" data-toggle="modal" data-target="#myModalUploadMedia" class="btn btn-info btn-danger upload_audio"><i class="fa fa-bullhorn"></i> <i class="fa fa-upload"></i></a>';
		} else {
			$player = '<audio controls src="' . $wav . '"></audio>';
			$player .= '<a href="#" data-toggle="modal" data-target="#myModalUploadMedia" class="btn btn-info btn-danger upload_audio"><i class="fa fa-bullhorn"></i> <i class="fa fa-upload"></i></a>';
		}
	}
	else $player .= '<a href="#" data-toggle="modal" data-target="#myModalUploadMedia" class="btn btn-info btn-danger upload_audio"><i class="fa fa-bullhorn"></i> <i class="fa fa-upload"></i></a>';
	
	$echo .= '
	<p><a href="'.$scriptname.'" class="btn btn-success"><i class="fa fa-arrow-circle-left"></i> zurück</a></p>
	<br>
		'.$player.'		
		<div class="row">
			<div class="col-md-6">
				<input type="hidden" name="save_media" value="1">
			';

	foreach ($arr_form as $arr) {
		$echo .= setMorpheusForm($row, $arr, $imgFolder, $edit, 'morp_media', $tid);
	}

	$array_properties = array();
	$sql = "SELECT * FROM morp_stimmen_media t1, morp_stimmen t2 WHERE t1.stID=t2.stID AND mediaID=$edit";
	$res = safe_query($sql);
	$charts = '';
	while($row = mysqli_fetch_object($res)) {
		$array_properties[] = $row->stID;		
		$charts .= '<span class="btn btn-info mr1 mb1 delChart" data-id="'.$row->idstmedia.'" data-myid="'.$row->stID.'"><i class="fa fa-trash"></i> &nbsp; '.$row->name.'</span>';
	}
	
	$echo = str_replace('<save>', '<hr><button class="btn btn-info" type="submit">Speichern</button>', $echo);
	
	$echo .= '
		<div class="row">
			<div class="col-md-6">
				'. showCategories($array_properties) .'			
			</div>
			<div class="col-md-6">
				'.$charts.'
				
				<hr class="mt4">
				<button class="btn btn-info" type="submit">Speichern</button> &nbsp; 							
				<button type="button" class="btn btn-info btn-danger" data-toggle="modal" data-target="#deleteModal">
				  <i class="fa fa-trash-o"></i>
				</button>
								
				<div class="modal fade modal-sm" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-body">
						<b>Teilnehmer Meinung</b> wirklich löschen?<br><br>
						<i>Was soll mit den Diary Einträgen passieren?</i> 
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<a href="?delete='.$edit.'" class="btn btn-primary">Löschen</a>
					  </div>
					</div>
				  </div>
				</div>
				
			</div>
		</div>
	</div>
</form>
';
	
	$echo .= '<hr>
		<h1 class="text-center small"><i>Diary</i></h1>' . '
		
		<p><a href="'.$morpheus['url'].'de/diary?neu=1&mediaID='.$edit.'" class="btn btn-info"><i class="fa fa-plus"></i> Kommentar hinzufügen</a><br><br><p class="message_info"></p>
			  ' . showComments($edit);

	return $echo;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

function new_entry()
{
	global $arr_form, $table, $tid, $imgFolder, $um_wen_gehts, $neu, $morpheus, $dir;
	
	$scriptname = $morpheus['url'] . 'de/' . $_REQUEST['hn'] . '/';
	$mtyp = 0;
		
	$echo .= '
	<p><a href="'.$scriptname.'" class="btn btn-success"><i class="fa fa-arrow-circle-left"></i> zurück</a></p>
	<br>
		<div class="row">
			<div class="col-md-6">';

	foreach ($arr_form as $arr) {
		$echo .= setMorpheusForm($row, $arr, $imgFolder, $edit, 'morp_media', $tid);
	}

	$echo .= '
			<input type="hidden" name="save_media" value="1">
			<input type="hidden" name="save_new" value="1">
			<button class="btn btn-info" type="submit">Speichern</button>
		</div>
	</div>
</form>
';

	return $echo;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

if ($save_media && $save_new) {
	global $morpheus;
	$edit = saveMorpheusForm(0, 1, 0);
	?>
	<script>
		location.href='<?php echo $scriptname; ?>?edit=<?php echo $edit; ?>';
	</script>
	<?php
} 
else if ($save_media) {
	global $morpheus;
	$edit = saveMorpheusForm($edit, $neu, 0);

	$sql = "DELETE FROM morp_stimmen_media WHERE mediaID=$edit";
	$res = safe_query($sql);
	foreach($_POST["listCategories"] as $key=>$val) {
		$sql = "INSERT morp_stimmen_media SET stID=$val , mediaID=$edit";
		$rs = safe_query($sql);
	}	
	// $scriptname = $morpheus['url'] . 'de/' . $_REQUEST['hn'] . '/' . '?edit_entry='.$_SESSION['entry'].'';

	?>
	  <!-- <script>
		location.href='<?php echo $scriptname; ?>';
	  </script> -->
	<?php
} 
elseif($save_note) {
	$uid = $_SESSION['mid'];
	$date = date("Y-m-d H:i:s");

	$sql = 'insert into morp_note(uid, parent, mediaID, message, add_link, date_time)values(' . $uid . ', ' . $parent_comment . ', ' . $mediaId . ', "' . $message_comment . '", "'.$cid.'", "' . $date . '")';
	safe_query($sql);

	updateDateComment($parent_comment);

	$scriptname = $morpheus['url'] . 'de/' . $_REQUEST['hn'] . '/' . '?edit='.$_SESSION['entry'].'';

	?>
	   <script>
		location.href='<?php echo $scriptname; ?>';
	  </script> 
	<?php
}
elseif($delete) {
	$sql = "DELETE FROM `$table` WHERE $tid=$delete ";
	safe_query($sql);
}

if ($edit) {
	$output .= edit($edit);

	$timestamp = time();
	$uploadScript = $dir . 'uploadifive/uploadifive.php';
	
    $output .= '
	<!-- The Modal -->
		<div class="modal" id="myModalUploadMedia">
		  <div class="modal-dialog">
			<div class="modal-content">
	
			  <!-- Modal Header -->
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			  </div>
	
			  <!-- Modal body -->
			  <div class="modal-body">
			  <div id="queue"></div>
			  <input id="file_upload_media" name="file_upload_media" type="file" multiple="true">
			  </div>
	
			  <!-- Modal footer -->
			  <div class="modal-footer">
				<button type="button" class="btn btn-info btn-upload-file">Upload</button>
				<input type="hidden" id="timestamp" value=' . $timestamp . ' />
				<input type="hidden" id="id_entries" value=' . $edit . ' />
				<input type="hidden" id="uploadScript" value=' . $uploadScript . ' />
				<input type="hidden" id="token" value=' . md5('pixeld' . $timestamp) .
			' />
			  </div>
	
			</div>
		  </div>
		</div>
	';

	$_SESSION['entry'] = $edit;
	$_SESSION['category'] = 0;
}
else if ($new) {
	$output .= new_entry();
}
else {
	$output = list_comment();
}
// END

$output .= '
</form>
';


$js .= '
// Bjoern add delete assigned media to media
$(".delChart").click(function(){		
	media = $(this).attr("data-media");
	id = $(this).attr("data-id");
	myid = $(this).attr("data-myid");
	$(this).addClass("hide");
	request = $.ajax({
		url: "'.$dir.'inc/UpdateDelete.php",
		type: "POST",
		data: "tabl=morp_stimmen_media&tid=idstmedia&todel="+id,
		success: function(data) {
			$("#data_"+myid).prop( "checked", false );
			$("#data_"+myid).prop( "checked", false );
			$(".message_info").removeClass("hide");
			$(".message_info").css("color", "green");
			$(this).html("Zuweisung gelöscht");
		}
	 });
});

';