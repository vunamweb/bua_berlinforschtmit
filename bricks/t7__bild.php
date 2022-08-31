<?php
global $img_pfad, $ausrichtung, $ausrichtungArray, $dir, $imgTop, $morpheus, $headerImgCt, $imageFolder;
global $fliesstext, $headline, $tref;

$data = explode("|", $text); $imgid = $data[0]; $ausrichtung = $data[1]; if(!$ausrichtung) $ausrichtung = 1;

$w = 1500;

if(!$headerImgCt) $headerImgCt=1;
else $headerImgCt++;

if($imgid) {
	$que  	= "SELECT `longtext`, itext, text2, imgname, name FROM `morp_cms_image` i, `morp_cms_img_group` g WHERE g.gid=i.gid AND imgid=$imgid";
	$res 	= safe_query($que);
	$rw     = mysqli_fetch_object($res);
	$itext 	= $rw->itext;
	$ltext 	= $rw->longtext;
// 	if($ltext) $ltext = explode("\n", $ltext);
	$text2 	= $rw->text2;
	$inm 	= $rw->imgname;
	$altText = $itext ? $itext : $ltext; if(!$altText) $altText = $morpheus["client"].' '.$inm;
	$folder	= str_replace(array(";", " / ", "/", "  ", " "), array("","-","-", "-", "-"), $rw->name);

	$imgTop = $img_pfad.$inm;
	
// 	$output .= '
// <div class="carousel-cell">
// 	<a '.($itext ? $itext : 'href="#"').'><img src="'.$img_pfad.''.($inm).'" alt="'.$altText.'" class="img-fluid" /></a>
// </div>';

}

$morp = $inm;

$socialImage = urlencode($inm);
global $socialImg; if(!$socialImg) $socialImg = $dir.$imageFolder.urlencode($folder).'/'.($inm).'?w='.$w;
$fliesstext = '';

