<?php
global $img_pfad, $ausrichtung, $ausrichtungArray, $dir, $imgGal, $imageFolder, $tref, $bild_box, $anker_image, $cid, $navID;

$data = explode("|", $text); $imgid = $data[0]; $ausrichtung = $data[1]; if(!$ausrichtung) $ausrichtung = 1;

$w = 600;
if($tref < 3) $w = 400;

if($text) {
	$que  	= "SELECT `longtext`, itext, imgname, name FROM `morp_cms_image` i, `morp_cms_img_group` g WHERE g.gid=i.gid AND imgid=$imgid";
	$res 	= safe_query($que);
	$rw     = mysqli_fetch_object($res);
	$itext 	= $rw->itext;
	$ltext 	= $rw->longtext;
	$inm 	= $rw->imgname;
	$altText = $itext ? $itext : $ltext; if(!$altText) $altText = $morpheus["client"].' '.$inm;
	$folder	= str_replace(array(";", " / ", "/", "  ", " "), array("","-","-", "-", "-"), $rw->name);

	$output .= '						<a href="'.$dir.$navID[$cid].'#'.$itext.'" class="page-scroll"><img src="'.$dir.$imageFolder.urlencode($folder).'/'.($inm).'?w='.$w.'" alt="'.$altText.'" class="img-fluid w-100" /></a>';
	// $bild_box = '<img src="'.$dir.$imageFolder.urlencode($folder).'/'.($inm).'?w='.$w.'" alt="'.$altText.'" class="img-fluid" />';
	//	https://www.pixeldusche.com/laborpahl/produkte/gehoerschutz/epro-komfort-gehoerschutz/#epro%20ER
}

$morp = $inm;

$socialImage = urlencode($inm);
global $socialImg; if(!$socialImg) $socialImg = $dir.$imageFolder.urlencode($folder).'/'.($inm).'?w='.$w;

?>