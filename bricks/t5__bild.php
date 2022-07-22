<?php
global $img_pfad, $ausrichtung, $ausrichtungArray, $dir, $produktBild, $imageFolder, $gallery, $galCT, $image_description;

$data = explode("|", $text); $imgid = $data[0]; $ausrichtung = $data[1]; if(!$ausrichtung) $ausrichtung = 1;

// if(!$galCT) $galCT=1;


if($text) {
	$que  	= "SELECT `longtext`, itext, imgname, name FROM `morp_cms_image` i, `morp_cms_img_group` g WHERE g.gid=i.gid AND imgid=$imgid";
	$res 	= safe_query($que);
	$rw     = mysqli_fetch_object($res);
	$itext 	= $rw->itext;
	$ltext 	= $rw->longtext;

	$inm 	= $rw->imgname;
	$altText = $itext ? $itext : repl("\n", " ", $ltext); if(!$altText) $altText = $morpheus["client"].' '.$inm;
	$folder	= str_replace(array(";", " / ", "/", "  ", " "), array("","-","-", "-", "-"), $rw->name);
	
	$img_size = getimagesize($img_pfad.$inm);
	$img_w = $img_size[0];
	$img_h = $img_size[1];

	$is_anker = isin("http", $itext) ? 1 : 0;
		
	$output .= ($itext && $is_anker ? '<a href="'.$itext.'" target="_blank">' : '').'<img src="'.$img_pfad.$inm.'" alt="'.$altText.'" class="svg-emo">'.($itext && $is_anker ? '</a>' : '');

}

$morp = $inm;
