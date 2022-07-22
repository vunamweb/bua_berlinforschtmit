<?php
global $img_pfad, $dir, $druckversion, $navID, $lan, $morpheus, $galHR, $galLR, $cid, $jsFunc, $mid;
global $justMine, $galerie;

// $galerie = isset($_GET["nid"]) ? $_GET["nid"] : 0;
$telegram = isset($_GET["telegram"]) ? $_GET["telegram"] : 0;


if($telegram) {
	$que  	= "SELECT * FROM `morp_cms_telegram` WHERE tid=".$telegram;
	$res 	= safe_query($que);

	$backLink = $dir.$navID[22];


	$output .= '
	        <div class="container">

	        		<a href="'.$backLink.'"><button class="btn btn-info"><i class="fa fa-chevron-left"></i></button></a>

		        <div class="row mt2">
';

	$row = mysqli_fetch_object($res);

	$besitzer = $row->mid;
	// if($besitzer) $profile = getProfile($besitzer);

	$comments = getComments("morp_cms_telegram_comments", "commentsID", "tid", $telegram, $mid);

	$output .= '
					<div class="col-md-8">
						<p class="telegramDatum">'.euro_dat($row->datum).'</p>
						<h1 class="mb1">'.$row->tTitle.'</h1>
						<p class="mb1">'.nl2br($row->tText).'</p>
					</div>
					<div class="col-md-3 col-offset-md-1">
						<p class="zeile mt6"><em class="leftcol">Kontakt: </em> <b class="rightcol"><a href="mailto:'.$row->mail.'?subject=Telegram&body='.$row->tTitle.'"><i class="fa fa-envelope"></i> &nbsp; '.$row->mail.'</a></b></p>

						'.($row->fon ? '<p class="zeile"><em class="leftcol">Telefon: </em> <b class="rightcol"><a href="tel:'.$row->fon.'">'.$row->fon.'</a></b></p>' : '').'

					</div>

			        <div class="col-md-12">
						<hr>

				        	<h3>Kommentare</h3>

'.$comments;

	$output .= '
						<textarea class="form-control mt4" id="comment" ref="'.$telegram.'" placeholder="Mein Kommentar"></textarea>
						<button class="btn btn-info saveText" ref="'.$telegram.'"><i class="fa fa-save"></i></button>

					</div>


				</div>
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

		 console.log(myText+\' # \'+id);

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

		 console.log(myText+\' #\'+id);

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
	    console.log(id);
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