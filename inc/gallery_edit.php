<?php
global $img_pfad, $dir, $druckversion, $navID, $lan, $morpheus, $galHR, $galLR, $cid, $js;
global $justMine, $galerie;

$galerie = isset($_GET["nid"]) ? $_GET["nid"] : 0;

if($galerie) {
	$que  	= "SELECT * FROM `morp_cms_galerie_name` n, `morp_cms_galerie` g WHERE g.gnid=".$galerie." AND g.gnid=n.gnid AND mid=".$_SESSION["mid"]." ORDER BY g.sort";
	$res 	= safe_query($que);
	$x		= mysqli_num_rows($res);
	$n = 0;

	$output .= '




		        <div class="row">
			        <div class="col-sm-10">
				        <div id="sortableH">
';

	$jsList = '';
	$setOptions = '';

	while ($row = mysqli_fetch_object($res)) {
		$n++;
		$img 	= $row->gname;
		$tn 	= $row->tn;
		$ordner = $row->gnname;
		$gid 	= $row->gid;
		$textde = $row->gtextde;
		$hl = $row->gtexten;

		$sql = "SELECT tagID FROM `morp_tags_list` WHERE art='image' AND targetID=$gid";
		$rs = safe_query($sql);
		$tagList = array();

		$setOptions .= '
					 var control = $select_'.$gid.'[0].selectize;
					 control.addOption({
					 	value: data,
					 	title: value
					 });
';

		while ($rw = mysqli_fetch_object($rs)) {
			$tagList[]=$rw->tagID;
		}

		$tagCount = count($tagList);
		$tagList = implode(",", $tagList);

		$output .= '

<div class="sortGal" id="z_'.$gid.'">
    <div class="hovereffect">
        <img class="img-responsive" src="'.$dir.'mthumb.php?w=400&amp;zc=1&amp;src=Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/'.$img.'">
        <div class="overlay">
        		<p><i class="fa fa-eraser delete tool" ref="'.$gid.'" id="e'.$gid.'"></i></p>
        		<p><i class="fa fa-check tool invisible delYes chk'.$gid.'" ref="'.$gid.'"></i></p>
        		<p><i class="fa fa-close tool invisible delNo chk'.$gid.'" ref="'.$gid.'"></i></p>
        </div>
    </div>
    <div class="relative">
	    <textarea class="galedit form-control" name="t'.$gid.'" id="t'.$gid.'" ref="s'.$gid.'" placeholder="Beschreibung Bild">'.$textde.'</textarea>
    		<button class="btn btn-info saveText" ref="'.$gid.'" id="s'.$gid.'"><i class="fa fa-save"></i></button>
    	</div>
	<select multiple id="tags'.$gid.'" name="tags[]" class="tags form-control" ref="'.$gid.'" placeholder="Tags / Kategorien"></select>
</div>
';

		$jsList .= '
	var $select_'.$gid.' = $(\'#tags'.$gid.'\').selectize({
		plugins: [\'remove_button\'],
	    labelField: \'title\',
	    searchField: \'title\',
	    sortField: \'title\',
		options: options,
	    create:  function(value, callback) {
			// console.log(value);
		    request = $.ajax({
		        url: "'.$dir.'morpheus/UpdateTag.php",
		        type: "post",
		        data: "add=1&table=morp_cms_galerie&data="+value+"&id='.$gid.'&feld=gid",
		        success: function(data) {
					  console.log(data);
					 //callback({ value: data, title: value });
					 //setOptions(data, value);
					 location.reload();
				}
		    });
	    },
	    onChange: function(value) {
	        if (!value.length) return;
		    request = $.ajax({
		        url: "'.$dir.'morpheus/UpdateTag.php",
		        type: "post",
		        data: "table=morp_cms_galerie&data="+value+"&id='.$gid.'&feld=gid",
		        success: function(data) {
					 console.log(data);
				}
		    });
	    }
	});

	'.( $tagCount > 0 ? ' $select_'.$gid.'[0].selectize.setValue(['.$tagList.']);' : '').'

';


	}

	$output .= '
					</div>
				</div>

				<div class="col-sm-2">
					<a href="'.$dir.$navID[10].'edit+'.$galerie.'/" class="btn btn-info"><i class="fa fa-plus"></i> Bild(er) hinzufügen</a>
				</div>
			</div>
';

	$js = '

	function setOptions(data, value) {
		'.$setOptions.'
	}

	$( function() {
	    $( "#sortableH" ).sortable({
			start: function(e, ui) {
			},
			update: function(event, ui) {
				var data = $(this).sortable(\'serialize\');
			    var new_position = ui.item.index();
				// console.log(data + new_position);

			    request = $.ajax({
			        url: "'.$dir.'morpheus/UpdatePosGal.php",
			        type: "post",
			        data: "data="+data+"&gid='.$gnid.'",
			        success: function(data) {
						// console.log(data);
					}
			    });

			}
		});

    		$( "#sortable" ).disableSelection();

	});

    $(".delete").click(function () {
	    id = $(this).attr("ref");
		$(this).addClass("invisible");
		$(".chk"+id).removeClass("invisible");
    });
    $(".delNo").click(function () {
	    id = $(this).attr("ref");
		$(".chk"+id).addClass("invisible");
		$("#e"+id).removeClass("invisible");
    });
    $(".delYes").click(function () {
	    id = $(this).attr("ref");
		// console.log(id);

	    request = $.ajax({
	        url: "'.$dir.'morpheus/UpdateDelete.php",
	        type: "post",
	        data: "todel="+id+"&tid=gid&table=morp_cms_galerie",
	        success: function(data) {
				$(\'#z_\'+id).hide();
				// console.log(data);
  			}
	    });
    });
    $(".saveText").click(function () {
	    id = $(this).attr("ref");
	    myText = $("#t"+id).val();

		// console.log(myText+\' # \'+id);

	    request = $.ajax({
	        url: "'.$dir.'morpheus/Update.php",
	        type: "post",
	        data: "pos=gtextde&data="+myText+"&id="+id+"&feld=gid&table=morp_cms_galerie",
	        success: function(data) {
				$(\'#s\'+id).removeClass(\'btn-danger\');
				// console.log(data);
  			}
	    });
    });
    $(".galedit").on("input",function () {
	    id = $(this).attr("ref");
	    $(\'#\'+id).addClass(\'btn-danger\');
    });


'.$jsList;

}

//$galerie = 1;

$morp = "Galery $text";

?>