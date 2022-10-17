<?php
global $pdf, $dir, $video, $fliesstext, $countSlider, $img_pfad;
global $map, $mobile, $mobileJPG, $videoPlay, $image;


if(!$countSlider) $countSlider=1;
else $countSlider++;

$query  = "SELECT * FROM `morp_cms_pdf` WHERE pid=$text";
$result = safe_query($query);
$row = mysqli_fetch_object($result);

$video = 1;

$de = $row->pdesc;
$nm = $row->pname;
$si = $row->psize;
$da = $row->pdate;
$pi = $row->pimage;
$da = euro_dat($da);

$file = substr($nm, 0, strlen($nm)-4);

$w = 820;
$h= 484;

$videoPlay = 1;
$image .= '	            <div class="video-html5" >
                <video src="'.$dir.'pdf/'.$file.'.mp4" controls playsinline class="video-absolute my-video" poster="'.$img_pfad.str_replace(" ", "-", strtolower($file)).'.jpg"></video>
            </div>
';

$morp = $typ[0];
