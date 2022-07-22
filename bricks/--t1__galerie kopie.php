<?php
global $img_pfad, $dir, $druckversion, $navID, $lan, $morpheus, $galHR, $galLR, $cid, $js, $hn_id, $mid;
global $justMine, $galerie;

$galerie = $text; // isset($_GET["nid"]) ? $_GET["nid"] : 0;
$likes = isset($_GET["likes"]) ? $_GET["likes"] : 0;

$hashtag = isset($_GET["hashtag"]) ? $_GET["hashtag"] : '';
$hashtagid = isset($_GET["hashtagid"]) ? $_GET["hashtagid"] : 0;

#echo '##mid: '.$mid.'##';
#print_r($_REQUEST);
#print_r($_SESSION);

if($likes) {
	$profile = getProfile($besitzer);

	if($likes=="all") 	$que = "SELECT * , COUNT(likesID) as countLikes FROM `morp_cms_galerie` g, `morp_cms_galerie_likes` l, `morp_cms_galerie_name` n WHERE g.gnid=n.gnid AND l.gid=g.gid  GROUP BY g.gid ORDER BY COUNT(likesID) DESC, g.sort";
	elseif($likes=="my") $que = "SELECT * FROM `morp_cms_galerie` g, `morp_cms_galerie_likes` l, `morp_cms_galerie_name` n WHERE g.gnid=n.gnid AND l.gid=g.gid AND l.mid=$mid ORDER BY g.sort";
	$res 	= safe_query($que);
	$x		= mysqli_num_rows($res);
	$n = 0;

	$tagListButtons = array();
	$galerie = 1;

	$output .= '

<div class="container-full">
<div class="row">
	<div class="col-sm-12 mt4">
		<h2><a href="'.$dir.$navID[$hn_id].'" class="btn btn-info"><i class="fa fa-chevron-left"></i></a> &nbsp;  Anzahl Fotos: '.$x.' '.($likes == "all" ? '// die beliebtesten Bilder' : '// meine Favoriten').'</h2>
		<hr>
	</div>
	<div class="col-sm-8 col-md-9 col-lg-10">
        <div class="grid">
';

	while ($row = mysqli_fetch_object($res)) {
		$n++;
		$img 	= $row->gname;
		$tn 		= $row->tn;
		$ordner = $row->gnname;
		$gnid 	= $row->gnid;
		$gid 	= $row->gid;
		$textde = $row->gtextde;
		$hl 		= $row->gtexten;

		$galerieName = $row->gntextde;
		$galerieDesc = $row->textde;
		$besitzer = $row->mid;
		if($besitzer) $profile = getProfile($besitzer);

		$tagList = getTags($gid, 'image');
		// print_r($tagList);
		$filter = '';

		foreach($tagList as $arr) {
			$filter .= " ".$arr[1];
			$tagListButtons[$arr[1]] = $arr[2];

		}

		$hasLike = isLike($mid, "morp_cms_galerie_likes", "gid", $gid);
		$noOfLikes = countLikes("morp_cms_galerie_likes", "gid", $gid);
		$hasComment = hasComment("morp_cms_galerie_comments", "gid", $gid);

		$ekko =  '<a class="galIcons" data-toggle="lightbox" data-gallery="stift" href="'.$dir.'mthumb.php?w=1200&amp;src=Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/'.urlencode($img).'" data-title="Galerie: '.$galerieName.' / '.$profile["vname"].' '.$profile["nname"].'" data-footer="'.$textde.'">';
		$output .= '

<div class="grid-item grid-sizer '.$filter.'">
    <div class="gal-item">
        '.$ekko.'<img class="img-responsive" src="'.$dir.'mthumb.php?w=400&amp;zc=1&amp;src=Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/'.urlencode($img).'"></a>
        <div class="inner">
            <div class="gal-Desc">
	            <p class="mt1">Galerie: '.$galerieName.' / '.$profile["vname"].' '.$profile["nname"].'</p>
				<p>'.$textde.'</p>
			</div>
            <div class="gal-Icons">
            		<span class="galIcons i1"><i class="fa fa-heart'.($hasLike ? '' : '-o').' tool transparent loveit" ref="'.$gid.'"></i> <span class="noOfLikes"><a href="/likes_galerie.php?gid='.$row->gid.'" data-toggle="lightbox" data-title="Galerie Likes" id="like'.$gid.'">'.$noOfLikes.'</a></span></span>
            		<span class="galIcons i2"><a href="'.$dir.'?hn=galerien&cont=gallery-comment&sn2=gallery-comment&likes='.$likes.'&foto='.$gid.'"><i class="fa fa-comments'.($hasComment ? '' : '-o').' tool transparent"></i></a></span>
            		'.$ekko.'<i class="fa fa-arrows tool transparent"></i></a>
             </div>

        </div>
    </div>
</div>
';

	}

	$filterButton = '';

	foreach($tagListButtons as $key=>$val) {
		$filterButton .= '			<button class="btn btn-info" data-filter=".'.$key.'"># '.$val.'</button>
';
	}

	$output .= '
		</div>
	</div>
	<div class="col-sm-4 col-md-3 col-lg-2">
		<div id="filters" class="button-group filter-button-group">
			<button class="btn btn-info is-checked" data-filter="*">Zeige alle Bilder</button>
			'.$filterButton.'
		</div>
	</div>
</div>
</div>
';

}


else if($galerie) {
	$que  	= "SELECT besucher, gntextde, textde FROM `morp_cms_galerie_name` WHERE gnid=".$galerie;
	$res 	= safe_query($que);
	$row 	= mysqli_fetch_object($res);
	$x		= $row->besucher;
	$x		= $x+1;
	$que  	= "UPDATE `morp_cms_galerie_name` set besucher=$x WHERE gnid=".$galerie;
	safe_query($que);

	$galerieName = $row->gntextde;
	$galerieDesc = $row->textde;
	// $besitzer = $row->mid;
	$profile = getProfile($besitzer);

	$que  	= "SELECT * FROM `morp_cms_galerie_name` n, `morp_cms_galerie` g WHERE g.gnid=".$galerie." AND g.gnid=n.gnid ORDER BY g.sort";
	$res 	= safe_query($que);
	$x		= mysqli_num_rows($res);
	$n = 0;

	$tagListButtons = array();

	$output .= '

<div class="container-full">
<div class="row">
	<div class="col-sm-12 mt4">
		<h2><a href="'.$dir.$navID[$hn_id].'" class="btn btn-info"><i class="fa fa-chevron-left"></i></a> &nbsp; Galerie: '.$galerieName.($besitzer ? ' // von: '.$profile["vname"].' '.$profile["nname"] : '').'</h2>
		'.($galerieDesc ? '<p class="mt2">'.$galerieDesc.'</p>' : '').'
		<hr>
	</div>
	<div class="col-sm-8 col-md-9 col-lg-10">
        <div class="grid">
';

	while ($row = mysqli_fetch_object($res)) {
		$n++;
		$img 	= $row->gname;
		$tn 		= $row->tn;
		$ordner = $row->gnname;
		$gnid 	= $row->gnid;
		$gid 	= $row->gid;
		$textde = $row->gtextde;
		$hl = $row->gtexten;

		$tagList = getTags($gid, 'image');
		// print_r($tagList);
		$filter = '';

		foreach($tagList as $arr) {
			$filter .= " ".$arr[1];
			$tagListButtons[$arr[1]] = $arr[2];

		}

		$noOfComments = '';
		$hasLike = isLike($mid, "morp_cms_galerie_likes", "gid", $gid);
		$noOfLikes = countLikes("morp_cms_galerie_likes", "gid", $gid);
		$hasComment = hasComment("morp_cms_galerie_comments", "gid", $gid);
		$noOfComments = countComments("morp_cms_galerie_comments", "gid", $gid);

		$output .= '

<div class="grid-item grid-sizer '.$filter.'">
    <div class="gal-item">
        <a class="galIcons" data-toggle="lightbox" data-gallery="stift2" href="'.$dir.'mthumb.php?w=1200&amp;src=Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/'.urlencode($img).'"><img class="img-responsive" src="'.$dir.'mthumb.php?w=400&amp;zc=1&amp;src=Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/'.$img.'"></a>
        <div class="inner">
            <div class="gal-Desc">
	            <h2>'.$hl.'</h2>
				<p>'.$textde.'</p>
			</div>
            <div class="gal-Icons">
            		<div class="innerLeft">
					</div>
            		<div class="innerRight">
	            		<span class="galIcons"><i class="fa fa-heart'.($hasLike ? '' : '-o lightBlue').' tool loveit" ref="'.$gid.'"></i> &nbsp; <span class="noOfLikes"><a href="/likes_galerie.php?gid='.$row->gid.'" data-toggle="lightbox" data-title="Galerie Likes" id="like'.$gid.'">'.$noOfLikes.'</a></span></span>
					<span class="galIcons"><a href="'.$dir.'?hn=galerien&cont=gallery-comment&sn2=gallery-comment&galerie='.$gnid.'&foto='.$gid.'"><i class="fa fa-comments'.($hasComment ? '' : '-o lightBlue').' tool"></i> &nbsp; <span class="noOfLikes">'.$noOfComments.'</span></a></span>
				</div>
             </div>

        </div>
    </div>
</div>
';

	}

	$filterButton = '';

	foreach($tagListButtons as $key=>$val) {
		$filterButton .= '			<button class="btn btn-info" data-filter=".'.$key.'"># '.$val.'</button>
';
	}

	$output .= '
		</div>
	</div>
	<div class="col-sm-4 col-md-3 col-lg-2">
		<div id="filters" class="button-group filter-button-group">
			<button class="btn btn-info is-checked" data-filter="*">Zeige alle Bilder</button>
			'.$filterButton.'
		</div>
	</div>
</div>
</div>
';


}

else if($hashtag) {
	$que  	= "SELECT tagID FROM `morp_tags` WHERE tag='$hashtag'";
	$res 	= safe_query($que);
	$row 	= mysqli_fetch_object($res);
	$hashtagID = $row->tagID;

	// $galerie to start CSS for grid * * * * * * * * * * * * * * * * * * * * * * * *
	$galerie = 1;

 	$que  	= "SELECT * FROM `morp_cms_galerie_name` n, `morp_cms_galerie` g, `morp_tags_list` tl WHERE tl.tagID=$hashtagID AND art='image' AND targetID=g.gid AND g.gnid=n.gnid ORDER BY g.sort";
	$res 	= safe_query($que);
	$x		= mysqli_num_rows($res);
	$n = 0;

	$output .= '

<div class="container-full">
<div class="row">
	<div class="col-sm-12 mt4">
		<h2><a href="'.$dir.$navID[$hn_id].'" class="btn btn-info"><i class="fa fa-chevron-left"></i></a></h2>
		<hr>
	</div>
	<div class="col-sm-12">
        <div class="grid">
';

	while ($row = mysqli_fetch_object($res)) {
		$n++;
		$img 	= $row->gname;
		$tn 		= $row->tn;
		$ordner = $row->gnname;
		$gnid 	= $row->gnid;
		$gid 	= $row->gid;
		$textde = $row->gtextde;
		$hl = $row->gtexten;

		$besitzer = $row->mid;
		$profile = getProfile($besitzer);

		$tagList = getTags($gid, 'image');
		// print_r($tagList);
		$filter = '';

		foreach($tagList as $arr) {
			$filter .= " ".$arr[1];
			$tagListButtons[$arr[1]] = $arr[2];

		}

		$hasLike = isLike($mid, "morp_cms_galerie_likes", "gid", $gid);
		$noOfLikes = countLikes("morp_cms_galerie_likes", "gid", $gid);
		$hasComment = hasComment("morp_cms_galerie_comments", "gid", $gid);

		$output .= '

			<div class="grid-item grid-sizer '.$filter.'">
			    <div class="gal-item">
			        <a class="galIcons" data-toggle="lightbox" data-gallery="stift2" href="'.$dir.'Galerie/mthumb.php?w=1200&amp;src='.$morpheus["GaleryPath"].'/'.$ordner.'/'.urlencode($img).'"><img class="img-responsive" src="'.$dir.'mthumb.php?w=400&amp;zc=1&amp;src=Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/'.$img.'"></a>
			        <div class="inner">
			            <div class="gal-Desc">
				            <h2>'.$hl.'</h2>
							<p>'.$textde.'</p>
						</div>
			            <div class="gal-Icons">
			            		<div class="innerLeft">
								</div>
			            		<div class="innerRight">
				            		<span class="galIcons"><i class="fa fa-heart'.($hasLike ? '' : '-o').' tool transparent loveit" ref="'.$gid.'"></i> &nbsp; <span class="noOfLikes"><a href="/likes_galerie.php?gid='.$row->gid.'" data-toggle="lightbox" data-title="Galerie Likes" id="like'.$gid.'">'.$noOfLikes.'</a></span></span>
									<span class="galIcons"><a href="'.$dir.'?hn=galerien&cont=gallery-comment&sn2=gallery-comment&galerie='.$gnid.'&foto='.$gid.'"><i class="fa fa-comments'.($hasComment ? '' : '-o').' tool transparent"></i></a></span>
							</div>
			             </div>

			        </div>
			    </div>
			</div>
';

	}

	$output .= '
		</div>
	</div>
</div>
</div>
';


}


else {
	if($justMine)		$que = "SELECT * , n.gnid AS gnid FROM `morp_cms_galerie_name` n LEFT JOIN `morp_cms_galerie` g ON g.gnid=n.gnid WHERE mid=".$_SESSION["mid"]." GROUP BY n.gnid ORDER BY n.date DESC";
	else				$que = "SELECT * FROM `morp_cms_galerie_name` n, `morp_cms_galerie` g WHERE sichtbar=1 AND g.gnid=n.gnid GROUP BY g.gnid ORDER BY n.date DESC";

	$res 	= safe_query($que);
	$x		= mysqli_num_rows($res);
	$n = 0;
	$galerie = 1;

	$output .= '

    	<div class="container container-xl mt4">
        <div class="row">
	        <div class="col-sm-8 col-md-9 col-lg-10">
';

	while ($row = mysqli_fetch_object($res)) {
		// print_r($row);
		$n++;
		$img 	= $row->gname;
		$ordner = $row->gnname;
		$gnid 	= $row->gnid;

		$textde = $row->textde;
		$hl = $row->gntextde;

		$besitzer = $row->mid;
		$profile = getProfile($besitzer);

		$output .= '

				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 linkbox mb2" ref="'.$dir.$navID[$cid].'galerie+'.$gnid.'/">
				    <div class="hovereffect">
				        <img class="img-responsive" src="'.$dir.'mthumb.php?w=800&amp;h=400&amp;zc=1&amp;src=Galerie/'.($img ? $morpheus["GaleryPath"].'/'.$ordner.'/'.urlencode($img) : 'leer.png').'">
			            <div class="overlay">
			                <h2>'.$hl.($besitzer ? '</h2><span>von '.$profile["vname"].' '.$profile["nname"] : '').'</span>
							<p>'.$textde.'</p>
							'.( $justMine ? '<p><a href="'.$dir.$navID[8].'edit+'.$gnid.'/"><i class="fa fa-pencil tool mb2"></i></a></p>' : '').'
							'.( $justMine ? '<p><a href="'.$dir.$navID[38].'er+'.$gnid.'/"><i class="fa fa-eraser tool"></i></a></p>' : '').'
			            </div>
				    </div>
				</div>
		';
	}

	$tagList = getAllTags($id, $art='image');
	ksort($tagList);
	$filterButton = '';

	foreach($tagList as $arr) {
		$filterButton .= '<a href="'.$dir.'?hn=galerien&cont=galerien&hashtagid='.$arr[0].'&hashtag='.$arr[1].'" class="btn btn-info hashtagGal">#'.$arr[2].'</a>
';
	}

	$output .= '
		    </div>
	        <div class="col-sm-4 col-md-3 col-lg-2 hashtag-hl">
	        		<h2><b>#Hashtag & Likes</b></h2>
	        		<hr>

	        		<p><a href="'.$dir.'?hn=galerien&cont=galerien&likes=all" class="btn btn-default mb1"><i class="fa fa-heart-o"></i> Die beliebtesten Bilder</a></p>
	        		<p><a href="'.$dir.'?hn=galerien&cont=galerien&likes=my" class="btn btn-default mb1"><i class="fa fa-heart-o"></i> Meine Lieblings-Bilder</a></p>

	        		<hr>

	        		'.$filterButton.'
        		</div>

		</div>
	</div>
';
}


// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// JS JS JS  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

global $phasen_graph;

if($galerie || $likes)		$js .= '
var $grid = $(\'.grid\').isotope({
  itemSelector: \'.grid-item\',
  masonry: {
	columnWidth: \'.grid-sizer\',
	percentPosition: true
  }
});

$grid.imagesLoaded().progress( function() {
  $grid.isotope(\'layout\');
});

var $items = $grid.find(\'.grid-item\');
$grid.addClass(\'is-showing-items\')
// .isotope( \'revealItemElements\', $items );

// bind filter button click
$(\'.filter-button-group\').on( \'click\', \'button\', function() {
  var filterValue = $( this ).attr(\'data-filter\');
  $grid.isotope({ filter: filterValue });
  //$grid.masonry();
});

// change is-checked class on buttons
$(\'.button-group\').each( function( i, buttonGroup ) {
  var $buttonGroup = $( buttonGroup );
  $buttonGroup.on( \'click\', \'button\', function() {
    $buttonGroup.find(\'.is-checked\').removeClass(\'is-checked\');
    $( this ).addClass(\'is-checked\');
  });
});


    $(".loveit").click(function () {
	    var obj = $(this);
	    id = obj.attr("ref");
	    var onoff = obj.hasClass("fa-heart-o");

	    request = $.ajax({
	        url: "'.$dir.'morpheus/UpdateLikes.php",
	        type: "post",
	        data: "onoff="+onoff+"&mid='.$mid.'&id="+id+"&feld=gid&table=morp_cms_galerie_likes",
	        success: function(data) {
		        //console.log(data);
		        $("#like"+id).html(data);
				if(onoff == true) { obj.removeClass("fa-heart-o lightBlue"); obj.addClass("fa-heart"); console.log(1); }
				else { obj.removeClass("fa-heart");  obj.addClass("fa-heart-o lightBlue"); console.log(0); }
  			}
	    });
    });

'.($phasen_graph ? '	setPhasen();	' : '').'

';


// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *


$morp = "Galery $text";


?>