<?php
global $img_pfad, $dir, $emotional, $socialImage, $imageFolder, $image, $slCt;

$imgid  = explode("|",$text);
$imgid = $imgid[0];

$w = 600;

if(!$slCt) $slCt=1;
else $slCt++;

if($text) {
	$que  	= "SELECT `longtext`, itext, imgname, name FROM `morp_cms_image` i, `morp_cms_img_group` g WHERE g.gid=i.gid AND imgid=$imgid";
	$res 	= safe_query($que);
	$rw     = mysqli_fetch_object($res);
	$itext 	= $rw->itext;
	$ltext 	= $rw->longtext;
	$inm 	= $rw->imgname;
	$altText = $itext ? $itext : $ltext; if(!$altText) $altText = $morpheus["client"].' '.$inm;
	$folder	= str_replace(array(";", " / ", "/", "  ", " "), array("","-","-", "-", "-"), $rw->name);

	// $image = '<img src="'.$img_pfad.$inm.'" class="img-fluid" alt="'.$itext.'" />';
	$output .= '<div class="carousel-cell'.($slCt < 2 ? ' active' : '').'"><img src="'.$img_pfad.$inm.'" alt="'.$itext.'" /><div class="BU">'.$ltext.'</div></div>';
}

$morp = $inm;
$socialImage = urlencode($inm);
global $socialImg; if(!$socialImg) $socialImg = $dir.$imageFolder.urlencode($folder).'/'.($inm).'?w='.$w;
