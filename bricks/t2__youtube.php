<?php
global $ytCt;

if(!$ytCt) $ytCt=1;
else $ytCt++;

	$output .= '
    <!-- video -->
    <div class="video_wrapper" style="background-image: url( \'https://img.youtube.com/vi/'.trim($text).'/hqdefault.jpg\' );">
	  <div class="video_trigger" data-source="'.trim($text).'" data-type="youtube">
		<p class="text-center">Mit dem Aufruf des Videos erklären sie sich  einverstanden, dass ihre Daten an YouTube übermittelt werden und das sie die <a href="https://knowledge-exchange.berlin-university-alliance.de/berlinforschtmit/de/datenschutz/">Datenschutzerklärung</a> gelesen haben.</p>
		<input type="button" class="btn" value="YouTube Video abspielen" />
	  </div>
	  <div class="video_layer"><iframe src="" border="0" data-scaling="true" data-format="16:9"></iframe></div>
	</div>
	<!-- end video -->';

    	// <div class="video-container" id="yt'.$ytCt.'">
		// 	<img src="https://img.youtube.com/vi/'.trim($text).'/hqdefault.jpg" ref="'.trim($text).'" refid="yt'.$ytCt.'" alt="YouTube '.trim($text).'"  class="youtubeHack w-100" />
		// </div>