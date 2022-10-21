<?php
global $pdf, $dir, $video, $fliesstext, $countSlider, $img_pfad;
global $map, $mobile, $mobileJPG, $videoPlay, $image, $ytCt;

if(!$countSlider) $countSlider=1;
else $countSlider++;

$tmp 	= explode("|", $text);
$link 	= $tmp[1];
$imgid 	= $tmp[0];

if(!$ytCt) $ytCt=1;
else $ytCt++;

if($imgid) {
	$query  = "SELECT itext, imgname FROM morp_cms_image WHERE imgid=$imgid";
	$result = safe_query($query);
	$row    = mysqli_fetch_object($result);
	$itext 	= $row->itext;
	$inm 	= $row->imgname;

	$image .= '
	<div class="videoWrapper" id="yt'.$ytCt.'">
		<div class="youtube_icon">
			<img src="'.$img_pfad.$inm.'" ref="'.$link.'" refid="yt'.$ytCt.'" alt="'.$itext.'"  class="youtubeHack img-responsive" />
			<i class="fa fa-youtube i1 youtubeHack" ref="'.$link.'" refid="yt'.$ytCt.'"></i>
			<i class="fa fa-play i2 youtubeHack" ref="'.$link.'" refid="yt'.$ytCt.'"></i>
		</div>
	</div>';

	$morp = "Link /";
}

$morp = $typ[0];
