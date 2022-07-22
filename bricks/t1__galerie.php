<?php
global $img_pfad, $dir, $druckversion, $navID, $lan, $morpheus, $galHR, $galLR, $cid, $js, $hn_id, $mid;
global $justMine, $galerie;

$galerie = $text; // isset($_GET["nid"]) ? $_GET["nid"] : 0;

#echo '##mid: '.$mid.'##';
#print_r($_REQUEST);
#print_r($_SESSION);

if($galerie) {
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

<div class="container">
<div class="row">
	<div class="col-12">
        <div class="grid">
		<div class="grid-sizer"></div>
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

<div class="grid-item  '.$filter.'">
    <div class="gal-item">
        <a class="galIcons" data-toggle="lightbox" data-gallery="stift2" href="'.$dir.'mthumb.php?w=1200&amp;src=Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/'.urlencode($img).'"><img class="img-fluid" src="'.$dir.'mthumb.php?w=500&amp;zc=1&amp;src=Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/'.$img.'"></a>
        <div class="inner">
            <div class="gal-Desc">
	            <h2>'.$hl.'</h2>
				<p>'.$textde.'</p>
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
				        <img class="img-fluid" src="'.$dir.'mthumb.php?w=800&amp;h=400&amp;zc=1&amp;src=Galerie/'.($img ? $morpheus["GaleryPath"].'/'.$ordner.'/'.urlencode($img) : 'leer.png').'">
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

if($galerie)		$js .= '
var $grid = $(\'.grid\').isotope({
  itemSelector: \'.grid-item\',
  layoutMode: \'masonry\'
});

$grid.imagesLoaded().progress( function() {
  $grid.isotope(\'layout\');
});

var $items = $grid.find(\'.grid-item\');
$grid.addClass(\'is-showing-items\')
// .isotope( \'revealItemElements\', $items );



'.($phasen_graph ? '	setPhasen();	' : '').'

';


// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *


$morp = "Galery $text";


?>