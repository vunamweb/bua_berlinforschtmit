<?php
global $ytCt;

if(!$ytCt) $ytCt=1;
else $ytCt++;

	$output .= '
    <!-- video -->
    	<div class="video-container" id="yt'.$ytCt.'">
			<img src="https://img.youtube.com/vi/'.trim($text).'/hqdefault.jpg" ref="'.trim($text).'" refid="yt'.$ytCt.'" alt="YouTube '.trim($text).'"  class="youtubeHack w-100" />
		</div>
    <!-- end video -->';
