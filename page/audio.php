<?php
global $morpheus;

$rubrik = $_POST["rubrik"] ? $_POST["rubrik"] : '';

$output .= '
<div class="col-12 col-lg-6 position-relative">
    <div class="count_time hide"><label id="minutes">00</label>:<label id="seconds">00</label></div>
    	<br>
    	<p class="text-center w_bntmic">
    	<a class="bntmic start" id="recordButton">
        	<span></span>
    	</a>
    	<div id="display_wave"></div>
    	<a class="bntmic stop hide" role="button" href="#" data-bs-toggle="modal" data-bs-target="#audioModal" id="stopButton">
        	<span></span>
    	</a><br>
    	<a class="bntmic restart hide" role="button" id="restartButton">
        	<span></span>
    	</a><br>
    	</p>
  	</div>
	  

	  
 </div>

<div class="slider_2">
    <div class="slider__wrapper">';
    	$query  = "SELECT * FROM morp_media WHERE mtyp='wav' AND public='true'";
		$query  = "SELECT * FROM morp_media WHERE mtyp='wav'";
		$query  = "SELECT * FROM morp_media WHERE 1";
		$result = safe_query($query);
		while ($row = mysqli_fetch_object($result)) {
        	$name = $row->name;
        	$date = $row->email;
        	$url_media = 'wav/' . $row->mname; 
	
        	$output .= '
			<div class="slider__item">
        		<a class="play_audio playme play1" href="'.$dir.''.$url_media.'">
          	  		<img src="'.$dir.'images/wave.svg"/>
        		</a>
        		<div class="border_top">
          	  		<p> '.$name.' // '.$date.'</p>
        		</div>
     		</div>';
    	}    
      
    $output .= '
	</div>
    	
	<a class="slider__control slider__control_left" href="#" role="button"></a>
    <a class="slider__control slider__control_right slider__control_show" href="#" role="button"></a>
</div>

 <div class="row waveform_player">
	<div class="col-sm-9">
		<div id="waveform">
			<!-- Here be waveform -->
		</div>
	</div>
	<div class="col-sm-3 align-self-center">
		<button class="btn btn-berlin btn-block" id="playPause">
			<span id="play">                                                        
				Play
			</span>                        
			<span id="pause" style="display: none">
				Pause
			</span>
		</button>
	</div>
</div>

</section>



<!-- Modal -->
<div class="modal fade" id="audioModal" tabindex="-1" aria-labelledby="audioModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div id="hl">Haben wir Sie richtig verstanden?</div>
				<button type="button" class="btn-close close reload" data-bs-dismiss="modal" aria-label="Close">
				<img src="'.$dir.'images/SVG/i_close.svg" alt="" class="img-fluid" width="20">
				</button>
			</div>
		
			<div class="modal-body">
				<div class="popover-body popover-content" id="danke">
    				<form action="" class="frm_questions" method="post">
    				<input type="hidden" id="url_home" value="'.$dir.'">
    				'.($rubrik ? '<input type="hidden" name="rubrik" id="rubrik" value="'.$rubrik.'">' : '').'
        				<div class="row">
            				<div class="col-12">
            				</div>
            				<div class="col-12 col-lg-6 mt2">
								<div class="checkaudio">
									<button id="pauseButton" disabled="" class="hide">Pause</button> 
									<div id="formats" class="hide"></div>
									<ol id="recordingsList"></ol>
								</div>
								<a href="'.$dir.'" class="btn btn-success btnRecord recordagain">Erneut aufnehmen</a>
            				</div>
            				<div class="col-12 col-lg-6 mt2">
            					<p class="message"></p>
            					<input type="text" name="name" id="name" class="form-control mb2" placeholder="name"/>
            					<input type="text" name="email" id="email" class="form-control mb2" placeholder="email"/>
            					<div class="custom-control custom-checkbox">
                					<label class="custom-control-label" for="ck01">
                						<input type="checkbox" class="custom-control-input" id="ck01" required>
										Ja, ich stimme der Nutzung meiner Daten gemäß <a href="'.$dir.'datenschutz/">AGB und DSGVO</a> zu
									</label>
            					</div>
            					<div class="custom-control custom-checkbox mt1">
                					<label class="custom-control-label" for="ck02">
                						<input type="checkbox" class="custom-control-input" id="ck02">
										Ja, ich stimme der Veröffentlichung der obigen Tonaufnahme unter Abgabe meiner Leistungsschutz- und Vervielfältigungsrechte zu. Die Veröffentlichung erfolgt ohne Namensnennung.
									</label>
            					</div>
            					<div class="custom-control custom-checkbox mt1">
                					<label class="custom-control-label" for="ck03">
                						<input type="checkbox" class="custom-control-input" id="ck03">
										Ja, ich möchte über weitere Aktionen von Forschung von der Straße informiert werden
									</label>
                					<a class="submit_form_audio" href="javascript:void(0)">Aufnahme senden</a>  
            					</div>                                                                                       
            				</div>
        				</div>
    				</form>
				</div>
  			</div>
	  		
		</div>
  	</div>
</div>


';

//$output = 'ddd';