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

$myauth = 10;
$stimmen_in = 'in';
$css = "style_blue.css";
include("cms_include.inc");
require_once('getid3/getid3.php');
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

# print_r($_SESSION);
# print_r($_REQUEST);

///////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
//// EDIT_SKRIPT
$um_wen_gehts 	= "Sprachaufnahmen";
$titel			= "Sprachaufnahmen Verwaltung";
///////////////////////////////////////////////////////////////////////////////////////
$table 		= 'morp_media';
$tid 		= 'mediaID';
$nameField 	= "mname";

$imgFolder = 'wav';

$neu = $_REQUEST['new'];

///////////////////////////////////////////////////////////////////////////////////////

// $new = '<a href="?neu=1" class="btn btn-info"><i class="fa fa-plus"></i> NEU</a>';
$new = '<p><a href="?new=1" class="btn btn-info"><i class="fa fa-plus"></i> NEU</a></p>';

echo '<div id=vorschau>
	<h2>'.$titel.'</h2>

	'. ($edit || $neu ? '<p><a href="?">&laquo; zur&uuml;ck</a></p>' : '') .'
	<form action="" onsubmit="" name="verwaltung" method="post">
'.($edit || $neu ? '' : '').'
'.(!$edit && !$neu ? '' : '').'
';

// print_r($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////
#$sql = "ALTER TABLE  $table ADD  `textonline` text() NOT NULL";
#safe_query($sql);
/////////////////////////////////////////////////////////////////////////////////////////////////////

$arr_form = array(
		array("mname", "Dateiname WAV", '<input type="Text" value="#v#" class="form-control" name="#n#" disabled />'),
		array("online", "Online schalten", 'chk'),
		array("rubrik", "Ja, ich möchte über weitere Aktionen von Forschung von der Straße informiert werden", 'chk'),
		array("mdesc", "Beschreibung", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
		array("mdate", "Datum", '<input type="Text" value="#v#" class="form-control" name="#n#" />', 'date'),
		array("name", "Name", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
		array("email", "Email", '<input type="Text" value="#v#" class="form-control" name="#n#" />'),
		array("text", "Übersetzung", '<textarea class="form-control" name="#n#" />#v#</textarea>'),
		
		array("", "CONFIG", '</div><div class="col-md-6 mb3 mt2">'),
		
		array("textonline", "Online Version / Text in rechter Textbox", '<textarea class="form-control" name="#n#" />#v#</textarea>'),
		array("mname", "MP3", 'file'),


		array("dsgvo", "DSGVO", 'dropdown_array', array("true"=>"true", "false"=>"false")),
		array("public", "Darf veröffenlicht werden", 'dropdown_array', array("true"=>"true", "false"=>"false")),


//		array("", "CONFIG", '</div><div class="col-md-12 mb3 mt2">'),
//		array("img1", "Foto 1", 'img'),
		array("", "CONFIG", '</div></div>'),
);

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

$neuerDatensatz = isset($_GET["new"]) ? $_GET["new"] : 0;
$edit = isset($_REQUEST["edit"]) ? $_REQUEST["edit"] : 0;
$save = isset($_REQUEST["save"]) ? $_REQUEST["save"] : 0;
$del = isset($_REQUEST["del"]) ? $_REQUEST["del"] : 0;
$delete = isset($_REQUEST["delete"]) ? $_REQUEST["delete"] : 0;
$back = isset($_POST["back"]) ? $_POST["back"] : 0;

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

function liste() {
	global $arr_form, $table, $tid, $filter, $nameField;

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
		<th></th>
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

	$sql = "SELECT * FROM $table WHERE $where ORDER BY ".$ord."";
	//echo $sql;
	$res = safe_query($sql);
	//echo mysqli_num_rows($res); die();

	while ($row = mysqli_fetch_object($res)) {
		$edit = $row->$tid;
		$rubrik = $row->rubrik;
		
		$file = substr($row->$anz, 0, strlen($row->$anz)-4);
		$wavfile = (strpos($row->mname, 'wav')) ? '../wav/'.$row->mname : '#';
		$filename = '../mp3/'.$row->mp3;
		$target = (strpos($row->mname, 'wav')) ? 'target="_blank"' : '';
		if(file_exists($filename) && $row->mp3) {
			$ThisFileInfo = $getID3->analyze($filename);
			$dauer = $row->dauer; 
			if(!$dauer) {
				$dauer = $ThisFileInfo['playtime_string']; 
			//$sql = "UPDATE $table SET mp3='".str_replace(':', '_', $file).'.mp3'."' WHERE $tid=$edit";
				$sql = "UPDATE $table SET dauer='$dauer' WHERE $tid=$edit";
				safe_query($sql);
			}
			$mp3exists = 1;
			$player = '<audio id="A'.$edit.'" src="'.$filename.'" preload="auto"></audio>
			<input class="btn btn-warning player" id="Bt'.$edit.'" value=">" type="button" onclick="af= \'A'.$edit.'\'; bt= \'Bt'.$edit.'\'; abspielen();">';
		} else {
			$filename = '../wav/'.$row->$anz;
			$ThisFileInfo = $getID3->analyze($filename);
			$dauer = $ThisFileInfo['playtime_string']; 
			$dauer = duplicate_time($dauer);
			//return 'nambuzz';
			$mp3exists = 0;
			$player = '';
		}

		if($rubrik) $frage = get_db_field($rubrik, 'frage', 'morp_stimmen_kategorie', 'stkID');
		else $frage = ''; 
		
		$echo .= '<tr>
			<td width="50" align="center">
				<a href="?edit='.$edit.'" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i></a>
			</td>
			<td width="50" align="center">
				<a href="?edit='.$edit.'">'.$row->$tid.' </a>
			</td>
			<td align="center">
				<a href="?edit='.$edit.'" data-toggle="tooltip" title="'.$frage.'">'.($rubrik ? '<span class="label label-info">'.$rubrik.'</span>' : '-').' </a>
			</td>
			<td>
				<a '.$target.' href="'.$wavfile.'">'.$file.($mp3exists ? ' &nbsp; <span class="label label-danger">MP3</span>' : '').'</a>'.$player.'
			</td>
			<td>
				<a href="?edit='.$edit.'">'.($row->online ? 'online' : 'x').'</a>
			</td>
			<td>
				<a href="?edit='.$edit.'">'.$dauer.'</a>
			</td>
			<td>
				<a href="?edit='.$edit.'">'.substr($row->mdesc,0,30).'</a>
			</td>
			<td>
				<a href="?edit='.$edit.'">'.substr($row->textonline,0,30).'</a>
			</td>
			<td>
				<a href="?edit='.$edit.'">'.$row->dsgvo.' </a>
			</td>
			<td>
				<a href="?edit='.$edit.'">'.$row->public.' </a>
			</td>
			<td>
				<a href="?edit='.$edit.'">'. euro_dat($row->mdate).' </a>
			</td>
		</tr>
';
	}

	$echo .= '</table><p>&nbsp;</p>';

	//return 'aaaa';
	return $echo;
}

// -----------------------------------------------------------------
// getID3 gibt falschen Wert aus. Ausgabe Länge ist nur halb so lang
function duplicate_time($dauer) {
	//echo $dauer . '/ddddd/';
	//return 'sss';
	if($dauer) {
		$split = explode(":",$dauer);
		$minute = $split[0];
		$seconds = $split[1];
		$total = (($minute*60)+$seconds) * 2;
		$total = $total / 60;
		$minutes = floor($total);
		$seconds = $total - $minutes;
		return $minutes .':'. (60 * $seconds);
	} 
	 
    return '';
}
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

function edit($edit) {
	global $arr_form, $table, $tid, $imgFolder, $um_wen_gehts, $neu;

	$sql = "SELECT * FROM $table WHERE $tid=".$edit."";
	$res = safe_query($sql);
	$row = mysqli_fetch_object($res);

	$echo .= '
		<input type="Hidden" name="edit" value="'.$edit.'">
		<input type="Hidden" name="save" value="1">
		<input type="Hidden" name="neu" value='.$neu.'>
		<input type="hidden" value="0" name="back" id="back" />

		<div class="row">
			<div class="col-md-6">

	';

	foreach($arr_form as $arr) {
		$echo .= setMorpheusForm($row, $arr, $imgFolder, $edit, 'morp_media', $tid);
	}

	$echo .= '<br>
				<button type="submit" id="savebtn" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; '.$um_wen_gehts.' speichern / aktualisieren</button>
				<button type="submit" id="savebtn2" value="hier" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; '.$um_wen_gehts.' speichern und zurück</button>
		</div>
	</div>
';

	return $echo;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

/*function neu() {
	global $arr_form, $table, $tid, $um_wen_gehts;

	$x = 0;


	$echo .= '<input type="Hidden" name="neu" value="1"><input type="Hidden" name="save" value="1">

	<table cellspacing="6" style="width:100%;">';

	foreach($arr_form as $arr) {
		if ($x < 1) $echo .= '<tr>
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
}*/

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

if ($save) {
	$neu = isset($_POST["neu"]) ? $_POST["neu"] : 0;

	//echo $new; die();
	$edit = saveMorpheusForm($edit, $neu);

	//echo 'dd'; die();

	if($neu) unset($neu);

	$scriptname = basename(__FILE__);
	//echo $scriptname . 'dddd'; die();

	if($back) {
?>
	<script>
		location.href='<?php echo $scriptname; ?>';
	</script>
<?php
	}
	elseif($neu) {
?>
	<script>
		location.href='<?php echo $scriptname; ?>?edit=<?php echo $edit; ?>';
	</script>
<?php
	}

	// unset($edit);
}

elseif ($delimg) {
	deleteImage($delimg, $edit, $imgFolder);
}

elseif($delete) {
	$sql = "DELETE FROM `$table` WHERE $tid=$delete ";
	safe_query($sql);
}

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

if($del) {
	echo '	<h2>Wollen Sie '.$um_wen_gehts.' wirklich löschen?</h2>

			<a href="?delete='.$del.'" class="btn btn-danger"><i class="fa fa-trash"></i> &nbsp; Ja</a>
			<a href="?" class="btn btn-default"><i class="fa fa-remove"></i> &nbsp; Nein / Abbruch</a>

';
}
elseif ($neuerDatensatz) 	echo edit(0); //neu("neu");
elseif ($edit) 			echo edit($edit);
else						echo liste().$new;

echo '
</form>
';

include("footer.php");

?>

<script>
	  $(".form-control").on("change", function() {
	  	$("#savebtn").addClass("btn-danger");
	  	$("#savebtn2").addClass("btn-danger");
	  });
	  $("#savebtn2").on("click", function() {
	  	$("#back").val(1);
	  });
	  
	$(document).ready(function(){
  		$('[data-toggle="tooltip"]').tooltip();
  	});



  var af='';
  var bt='';
  var afx='';
  var btx='';

function ende()
    {
    var btn = document.getElementById(bt);
    btn.value = '>';
    }

 function abspielen()
  	{
  	 var pl = document.getElementById(af);
  	 var btn = document.getElementById(bt);
  	 if (afx !== '')
  	   {
  	     if (afx !== af)
  	       {
  	       var plx = document.getElementById(afx);
  	       var btnx  = document.getElementById(btx);
  	       plx.pause();
  	       btnx.value = '>';
  	       }
  	   }

      if (pl.paused)
  	    {
  	     pl.currentTime = 0;
  	     pl.play();
  	     btn.value = '||';
  	     afx = af;
             btx = bt;
             pl.addEventListener('ended',function(){ende();});
             }
  	     else
  	     {
  	     pl.pause();
  	     btn.value = '>';
  	     }
  	 }

</script>