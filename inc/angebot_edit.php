<?php
global $dir, $cid, $morpheus, $table, $mid, $profile;
global $arr_form, $table, $tid, $mylink, $navID, $cid, $jsFunc;


$show = 1;
$folder = "angebote";
$zurueckID = 20;
$showForm = 1;


include('angebot_arr.php');
// print_r($profile);
// print_r($_POST);

$save = isset($_POST["save"]) ? $_POST["save"] : 0;
$neu = isset($_POST["neu"]) ? $_POST["neu"] : 0;
$aid = isset($_POST["aid"]) ? $_POST["aid"] : 0;
$back = isset($_POST["back"]) ? $_POST["back"] : 0;

if ($save) {
	$aid = saveMorpheusForm($aid, $neu);
	if($back) {
		header('Location: '.$dir.$navID[$zurueckID]);
		exit;
	}
	else if($neu) {
		header('Location: '.$dir.$navID[$cid].'edit+'.$aid.'/');
		exit;
	}
}
elseif(isset($_GET["nid"])) $aid = $_GET["nid"];

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// Get parameter for e.g. delete
$func = isset($_GET["func"]) ? $_GET["func"] : '';

if($func) {
	$func = explode("-", $func);
	$todel = $func[1];
	$func = $func[0];

	if($func == "delimg") {
		$sql = "UPDATE $table SET $todel='' WHERE $tid=$aid";
		safe_query($sql);

		header('Location: '.$dir.$navID[$cid].'edit+'.$aid.'/');
		exit;
	}
	else if($func == "deljob") {
		$showForm = 0;

		$sql = "SELECT * FROM `$table` WHERE $tid=$aid AND mid=$mid";
		$res = safe_query($sql);
		$checkit = mysqli_num_rows($res);
		$row = mysqli_fetch_object($res);

		$output.= '
<div class="container">
		<h2>Löschen ?!</h2>
		<p>Wollen Sie das Angebot <u><b>'.$row->aTitle.'</b></u> wirklich löschen?</p>
		<p>&nbsp;</p>
		<a href="'.$dir.$navID[$cid].'confirm-'.$aid.'+'.$aid.'/" class="btn btn-danger"><i class="fa fa-check"></i></a>
		<a href="'.$dir.$navID[$zurueckID].'" class="btn btn-default"><i class="fa fa-remove"></i></a>
</div>
		';
	}
	else if($func == "confirm") {
		$sql = "DELETE FROM `$table` WHERE $tid=$aid AND mid=$mid";
		safe_query($sql);

		header('Location: '.$dir.$navID[$zurueckID]);
		exit;

	}
}
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *


if(!$aid) die("Problem");

// ORDNER /Directory => gnname

	$sql = "SELECT * FROM `$table` WHERE $tid=$aid AND mid=$mid";
	$res = safe_query($sql);
	$checkit = mysqli_num_rows($res);
	$row = mysqli_fetch_object($res);

if($showForm) {
	$images = '';
	for($i=1;$i<=4;$i++) {
		$get = "img".$i;
		if($row->$get) $images .= '<div class="col-md-3"><img src="'.$dir.'mthumb.php?h=200&amp;src=images/'.$folder.'/'.urlencode($row->$get).'" class="img-responsive mb1" style="float:left;"><a href="'.$dir.$navID[$cid].'delimg-'.$get.'+'.$aid.'/" class="btn btn-danger"><i class="fa fa-trash-o"></i></a></div>';
		else $images .= '<div class="col-md-3"></div>';
	}


	$form = '';

	foreach($arr_form as $arr) {
	 	$form .= setMorpheusForm($row, $arr, $folder, $aid, 0, "aid", "1000x1000");
	}


	$output .= '
<div class="container">
	<div class="row mb4">
			<form method="post" id="myform">
				<input type="hidden" value="1" name="save" />
				<input type="hidden" value="'.$aid.'" name="aid" />
				<input type="hidden" value="0" name="back" id="back" />


				'.$form.'
				<hr>
				<button type="submit" id="savebtn2" value="hier" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; Angebot speichern und zurück</button>
				<button type="submit" id="savebtn" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; Angebot speichern / aktualisieren</button>
				<a href="'.$dir.$navID[$zurueckID].'" class="btn btn-default"><i class="fa fa-chevron-left"></i> zurück ohne Speichern</a>
				<hr>

	</div>
			</form>

	<div class="row">
		'.($images ? $images : '').'
	</div>
</div>

';

	$jsFunc .= '
	  $(".form-control").on("change", function() {
	  	$("#savebtn").addClass("btn-danger");
	  	$("#savebtn2").addClass("btn-danger");
	  });
	  $("#savebtn2").on("click", function() {
	  	$("#back").val(1);
	  });


	';
}

?>