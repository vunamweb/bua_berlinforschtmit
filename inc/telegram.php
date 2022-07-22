<?php
global $dir, $cid, $morpheus, $table, $mid, $profile, $navID, $jsFunc, $cid, $navID;
global $arr_form, $table, $tid, $mylink;


$show = 1;

$telegram = isset($_GET["nid"]) ? $_GET["nid"] : 0;
$edit = isset($_GET["edit"]) ? $_GET["edit"] : 0;
$neu = isset($_GET["neu"]) ? $_GET["neu"] : 0;
$save = isset($_GET["save"]) ? $_GET["save"] : 0;

$del = isset($_GET["del"]) ? $_GET["del"] : 0;
$delete = isset($_GET["delete"]) ? $_GET["delete"] : 0;

$back = isset($_POST["back"]) ? $_POST["back"] : 0;

include('telegram_arr.php');
// print_r($profile);
// print_r($_REQUEST);


if($delete) {
	$sql = "DELETE FROM `$table` WHERE $tid=$delete AND mid=$mid";
	safe_query($sql);
}

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *


if($del) {
	$output .= '<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Wollen Sie das Telegram wirklich löschen?</h2>

			<a href="'.$dir.'?hn=telegram&cont=telegram&delete='.$del.'" class="btn btn-danger"><i class="fa fa-trash"></i> &nbsp; Ja</a>
			<a href="'.$dir.'?hn=telegram&cont=telegram" class="btn btn-default"><i class="fa fa-remove"></i> &nbsp; Nein / Abbruch</a>

		</div>
	</div>
';
}

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *


else if($edit) {

	$form = '';
	$telegram = $edit;

	$sql = "SELECT * FROM `$table` WHERE $tid=$telegram AND mid=$mid";
	$res = safe_query($sql);
	$checkit = mysqli_num_rows($res);
	$row = mysqli_fetch_object($res);

	foreach($arr_form as $arr) {
	 	$form .= setMorpheusForm($row, $arr, "", $telegram, 0, "tid");
	}


	$output .= '
<div class="container">
	<div class="row">
		<div class="col-md-12">

			<form method="post" action="'.$dir.'?hn=telegram&cont=telegram&save=1">
				<input type="hidden" value="1" name="save" />
				<input type="hidden" value="'.$telegram.'" name="edit" />
				<input type="hidden" value="0" name="back" id="back" />

				'.$form.'

				<button type="submit" id="savebtn2" value="hier" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; Telegram speichern und zurück</button>
				<button type="submit" id="savebtn" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; Telegram speichern / aktualisieren</button>
				<a href="'.$dir.'?hn=telegram&cont=telegram&del='.$edit.'" class="btn btn-default"><i class="fa fa-trash"></i> &nbsp; Telegram löschen</a>
			</form>

		</div>
	<div class="row">

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



// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *


else if($save) {

	$neu = isset($_POST["neu"]) ? $_POST["neu"] : 0;
	$telegram = isset($_POST["edit"]) ? $_POST["edit"] : 0;
	$telegram = saveMorpheusForm($telegram, $neu);



	if($back) {
		header('Location: '.$dir.$navID[22]);
		exit;
	}


	$form = '';

	$sql = "SELECT * FROM `$table` WHERE $tid=$telegram AND mid=$mid";
	$res = safe_query($sql);
	$checkit = mysqli_num_rows($res);
	$row = mysqli_fetch_object($res);

	foreach($arr_form as $arr) {
	 	$form .= setMorpheusForm($row, $arr, "", $telegram, 0, "tid");
	}


	$output .= '
<div class="container">
	<div class="row">
		<div class="col-md-12">

			<form method="post" action="'.$dir.'?hn=telegram&cont=telegram&save=1">
				<input type="hidden" value="1" name="save" />
				<input type="hidden" value="'.$telegram.'" name="edit" />
				<input type="hidden" value="0" name="back" id="back" />

				'.$form.'

				<button type="submit" id="savebtn2" value="hier" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; Telegram speichern und zurück</button>
				<button type="submit" id="savebtn" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; Telegram speichern / aktualisieren</button>
			</form>

		</div>
	<div class="row">

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



// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *



else if($neu) {

	$form = '';

	foreach($arr_form as $arr) {
	 	$form .= setMorpheusForm($row, $arr, "", $tid, 0, "tid");
	}


	$output .= '
<div class="container">
	<div class="row">
		<div class="col-md-12">

			<form method="post" action="'.$dir.'?hn=telegram&cont=telegram&save=1">
				<input type="hidden" value="1" name="neu" />
				<input type="hidden" value="1" name="save" />
				'.$form.'
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; Anlegen</button>
			</form>

		</div>
	<div class="row">

	</div>
</div>

';

}

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *


else {
	if($cid == 25) $where = " mid=$mid ";
	else $where = 'sichtbar=1 ';

	$sql = "SELECT * FROM `$table` WHERE $where ORDER BY $tid DESC";
	$res = safe_query($sql);
	$anzahl = mysqli_num_rows($res);


	$output .= '
	<div class="container telegram ">

		<div class="neu"><a href="'.$dir.'?hn=telegram&cont=telegram&neu=1"><button class="btn btn-info"><i class="fa fa-plus"></i></button></a></div>

		<div class="row downloads">
';

	$x=0;


	while($row = mysqli_fetch_object($res)) {
		$x++;
		$images = '';
		$anzahlImages = 0;

		$sichtbar = $row->sichtbar;

		$hasComment = hasComment("morp_cms_telegram_comments", $tid, $row->$tid);
		if($hasComment) $comments = getComments("morp_cms_telegram_comments", "commentsID", $tid, $row->$tid, $mid, 1);

		// $img = $row->img1 ? '<img src="'.$dir.'mthumb.php?w=500&amp;src=images/angebote/'.urlencode($row->img1).'" class="img-responsive" />' : '';

		$output .= '
		<div class="col-md-9'.($sichtbar ? '' : ' bg-gray pt2 pb2').'">
			<p class="telegramDatum">'.euro_dat($row->datum).'</p>
			<h1 class="mb1">'.($sichtbar ? '' : '<i class="fa fa-eye-slash"></i> &nbsp; ').''.$row->tTitle.'</h1>
			<p class="mb1">'.nl2br($row->tText).'</p>
			'.($hasComment ? ''.$comments.'' : '').'
			<span class="telegram"><a href="'.$dir.'?hn=telegram&amp;cont=telegram-comment&amp;sn2=telegram-comment&amp;telegram='.$row->$tid.'"><i class="fa fa-comments'.($hasComment ? '' : '-o').' tool"></i></a></span>
		</div>
		<div class="col-md-3'.($sichtbar ? '' : ' bg-gray pt2 pb2').'">
			<p class="zeile"><em class="leftcol">Kontakt: </em> <b class="rightcol"><a href="mailto:'.$row->mail.'?subject=Telegram&body='.$row->tTitle.'"><i class="fa fa-envelope"></i> &nbsp; '.$row->mail.'</a></b></p>
			'.($row->fon ? '<p class="zeile"><em class="leftcol">Telefon: </em> <b class="rightcol"><a href="tel:'.$row->fon.'">'.$row->fon.'</a></b></p>' : '').'
			'.($row->mid == $mid ? '<p class="ra"><a href="'.$dir.'?hn=telegram&cont=telegram&edit='.$row->$tid.'"><button class="btn btn-info"><i class="fa fa-edit"></i></button></a></b></p>' : '').'
		</div>


		<div class="col-md-12">
			<hr>
		</div>
';

	}

	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

	$output.='
</div>



<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="beispielModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
	        <h4 class="modal-title" id="beispielModalLabel">Wollen Sie Ihren Kommentar wirklich löschen?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
        <button type="button" class="btn btn-primary delComment">Kommentar löschen</button>
      </div>
    </div>
  </div>
</div>

<input type="hidden" class="form-control" id="delete-id">

	';

	$jsFunc = '

	$(\'#deleteModal\').on(\'show.bs.modal\', function (event) {
	  var button = $(event.relatedTarget)
	  var recipient = button.data(\'todel\')
	  var modal = $(this)
	  modal.find(\'.modal-body input\').val(recipient);
	  $("#delete-id").val(recipient);
	})


    $(".saveText").click(function () {
	    id = $(this).attr("ref");
	    myText = $("#comment").val();

		// console.log(myText+\' # \'+id);

	    request = $.ajax({
	        url: "'.$dir.'page/UpdateComments.php",
	        type: "post",
	        data: "comment="+myText+"&id="+id+"&feld=tid&table=morp_cms_telegram_comments&mid='.$mid.'",
	        success: function(data) {
				$(\'#s\'+id).removeClass(\'btn-danger\');
				// console.log(data);
				location.reload();
  			}
	    });
    });

    $(".upd").click(function () {
	    id = $(this).attr("ref");
	    myText = $("#c"+id).val();

		// console.log(myText+\' #\'+id);

	    request = $.ajax({
	        url: "'.$dir.'page/UpdateComments.php",
	        type: "post",
	        data: "update=\'+id+\'&comment="+myText+"&id="+id+"&feld=commentsID&table=morp_cms_telegram_comments&mid='.$mid.'",
	        success: function(data) {
				// console.log(data);
				location.reload();
  			}
	    });
    });

    $(".delComment").click(function () {
	    id = $("#delete-id").val();
	    // console.log(id);
	    request = $.ajax({
	        url: "'.$dir.'page/UpdateComments.php",
	        type: "post",
	        data: "update=\'+id+\'&delc=1&id="+id+"&feld=commentsID&table=morp_cms_telegram_comments&mid='.$mid.'",
	        success: function(data) {
				// console.log(data);
				location.reload();
  			}
	    });
    });


    $(".editComment").click(function () {
	    editID = $(this).attr("ref");

		$("#t"+editID).hide();
		$("#c"+editID).fadeIn();
		$("#b"+editID).fadeIn();
		$("#a"+editID).fadeIn();
		$("#d"+editID).fadeIn();

		// console.log(editID);
    });
    $(".abbruch").click(function () {
	    editID = $(this).attr("ref");

		$("#t"+editID).fadeIn();
		$("#c"+editID).hide();
		$("#b"+editID).hide();
		$("#a"+editID).hide();
		$("#d"+editID).hide();

		// console.log(editID);
    });

';
}

?>