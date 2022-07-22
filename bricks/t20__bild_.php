<?php
global $img_pfad, $ausrichtung, $ausrichtungArray, $dir, $img__header, $templ_id, $css, $mobile;

$data = explode("|", $text); $imgid = $data[0]; $ausrichtung = $data[1]; if(!$ausrichtung) $ausrichtung = 1;

if($text) {
	$que  	= "SELECT itext, imgname, `longtext` FROM `morp_cms_image` WHERE imgid=$imgid";
	$res 	= safe_query($que);
	$rw     = mysqli_fetch_object($res);
	$itext 	= $rw->itext;
	$ltext 	= $rw->longtext;

	$inm 	= $rw->imgname;
	$altText = $itext ? $itext : $ltext; if(!$altText) $altText = $morpheus["client"].' '.$inm;

	// $img__header = '<img src="'.$img_pfad.urlencode($inm).'" class="img-fluid" alt="'.($ltext ? $ltext : $inm).'" />';
	$img__header = $img_pfad.urlencode($inm);

	//$mobile = 3;
	//echo $mobile;

	if($mobile == 3) $css .= '
	.box_topbanner_item {
    	background-image: url('.$dir.'mthumb.php?w=750&h=400&src=images/userfiles/image/'.$inm.'); background-repeat: no-repeat;
	}';
	else $css .= '
	.box_topbanner_item {
		background-image: url('.$dir.'images/userfiles/image/'.$inm.');
		background-repeat: no-repeat;
		background-size: cover;
		background-position: right;
	}
';
}

$morp = $inm;

$socialImage = urlencode($inm);


// .section_topbanner.topbanner_services {
// 	background: url('.$dir.'images/userfiles/image/'.$inm.') no-repeat center top;
// 	background-size: cover; height: 400px;
// }