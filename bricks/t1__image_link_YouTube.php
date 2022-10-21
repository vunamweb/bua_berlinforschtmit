<?php

global $navarray, $lan, $navID, $ytCt, $img_pfad, $img_pfad_local, $dir, $lokal_pfad, $quality;

$tmp 	= explode("|", $text);
$link 	= $tmp[1];
$imgid 	= $tmp[0];

if(!$ytCt) $ytCt=1;
else $ytCt++;

if($imgid) {
	$query  = "SELECT itext, imgname FROM image WHERE imgid=$imgid";
	$result = safe_query($query);
	$row    = mysqli_fetch_object($result);
	$itext 	= $row->itext;
	$inm 	= $row->imgname;

	$output .= '
	<div class="videoWrapper" id="yt'.$ytCt.'">
		<img src="'.$img_pfad.$inm.'" ref="'.$link.'" refid="yt'.$ytCt.'" alt="'.$itext.'"  class="youtubeHack img-responsive" />
	</div>';

	$morp = "Link /";
}
