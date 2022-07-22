<?php
global $img_pfad, $dir, $druckversion, $navID, $lan, $morpheus, $galHR, $galLR, $cid, $jsFunc, $mid;
global $justMine, $galerie;

// $galerie = isset($_GET["nid"]) ? $_GET["nid"] : 0;
$foto = isset($_GET["foto"]) ? $_GET["foto"] : 0;
$likes = isset($_GET["likes"]) ? $_GET["likes"] : 0;
$galerie = isset($_GET["galerie"]) ? $_GET["galerie"] : 0;

if($foto) {
	$que  	= "SELECT * FROM `morp_cms_galerie_name` n, `morp_cms_galerie` g WHERE g.gid=".$foto." AND g.gnid=n.gnid";
	$res 	= safe_query($que);
	$x		= mysqli_num_rows($res);

	$galerie = 1;

	if($likes) {
		$backLink = $dir.'?hn=galerien&cont=galerien&likes='.$likes;
	}
	else $backLink = $dir.'galerien/galerie+'.$galerie.'/';



	$output .= '
	        <div class="container container-xl">
		        <div class="row">
			        <div class="col-sm-8">
			        		<a href="'.$backLink.'"><button class="btn btn-info"><i class="fa fa-chevron-left"></i></button></a>
';

	$row = mysqli_fetch_object($res);

	$img 	= $row->gname;
	$ordner = $row->gnname;
	$gid 	= $row->gid;
	$textde = $row->gtextde;
	$hl = $row->gtexten;

	$galerieName = $row->gntextde;
	$besitzer = $row->mid;
	if($besitzer) $profile = getProfile($besitzer);

	$comments = getComments("morp_cms_galerie_comments", "commentsID", "gid", $gid, $mid);

	$output .= '

				        <img class="img-responsive" src="'.$dir.'mthumb.php?w=800&amp;zc=1&amp;src=Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/'.$img.'" />
						<p class="mt1"><b>'.$galerieName.'</b></p>
						<p class="mt1">'.$textde.' / '.$profile["vname"].' '.$profile["nname"].'</p>
				    </div>
			        <div class="col-sm-4">
				        	<h3>Kommentare</h3>

'.$comments;

	$output .= '


						<textarea class="form-control mt4" id="comment" ref="'.$gid.'" placeholder="Mein Kommentar"></textarea>
						<button class="btn btn-info saveText" ref="'.$gid.'"><i class="fa fa-save"></i></button>

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

		// console.log(myText+\' # \'+id);

	    request = $.ajax({
	        url: "'.$dir.'page/UpdateComments.php",
	        type: "post",
	        data: "comment="+myText+"&id="+id+"&feld=gid&table=morp_cms_galerie_comments&mid='.$mid.'",
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
	        data: "update=\'+id+\'&comment="+myText+"&id="+id+"&feld=commentsID&table=morp_cms_galerie_comments&mid='.$mid.'",
	        success: function(data) {
				// console.log(data);
				location.reload();
  			}
	    });
    });

    $(".delComment").click(function () {
	    id = $("#delete-id").val();
	    request = $.ajax({
	        url: "'.$dir.'page/UpdateComments.php",
	        type: "post",
	        data: "update=\'+id+\'&delc=1&id="+id+"&feld=commentsID&table=morp_cms_galerie_comments&mid='.$mid.'",
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

$morp = "Galery $text";

?>