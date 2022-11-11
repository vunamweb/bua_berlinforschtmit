<?php
global $img_pfad, $dir, $druckversion, $navID, $lan, $morpheus, $galHR, $galLR, $cid, $js, $hn_id, $mid;
global $justMine, $galerie;

$galerie = $text; // isset($_GET["nid"]) ? $_GET["nid"] : 0;

#echo '##mid: '.$mid.'##';
#print_r($_REQUEST);
#print_r($_SESSION);

if($galerie && !CMS) {
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

<div class="container lightgallery">
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

		// $noOfComments = '';
		// $hasLike = isLike($mid, "morp_cms_galerie_likes", "gid", $gid);
		// $noOfLikes = countLikes("morp_cms_galerie_likes", "gid", $gid);
		// $hasComment = hasComment("morp_cms_galerie_comments", "gid", $gid);
		// $noOfComments = countComments("morp_cms_galerie_comments", "gid", $gid);

		// <img class="lightboxed" rel="group1" src="https://www.jqueryscript.net/dummy/1.jpg" data-link="https://www.jqueryscript.net/dummy/1.jpg" alt="Image Alt" data-caption="Image Caption" />

		$format = substr($img, -3);
		
		if($format == "mp4") $dataLink = $dir.'Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/'.$img;
		else $dataLink = $dir.'mthumb.php?w=1500&amp;zc=1&amp;src=Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/'.$img;
		
		$output .= '
				<div class="grid-item">
					<img class="img-fluid lightboxed" rel="group1" src="'.$dir.'mthumb.php?w=500&amp;zc=1&amp;src=Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/'.$img.'" data-link="'.$dataLink.'" alt="kug <sg ajkg k '.$textde.'">
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


