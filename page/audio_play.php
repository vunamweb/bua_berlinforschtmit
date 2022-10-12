<?php
global $morpheus, $audio_file, $modal;

$rubrik = $_POST["rubrik"] ? $_POST["rubrik"] : '';

$output .= '		
		<h1 class="mw">Aktuelle Nachrichten</h1>
		<div class="slider_2">
    		<div class="slider__wrapper">';
    			$query  = "SELECT * FROM morp_media WHERE mtyp='wav' AND public='true'";
				$query  = "SELECT * FROM morp_media WHERE mtyp='wav'";
				$query  = "SELECT * FROM morp_media WHERE 1";
				$result = safe_query($query);
				$x = 0;
				while ($row = mysqli_fetch_object($result)) {
        			$name = $row->name;
        			$date = $row->email;
        			$url_media = 'wav/' . $row->mname; 
					$x++;
        			$output .= '
					<div class="slider__item">
        				<a class="play_audio playme play1" href="'.$dir.''.$url_media.'">
          	  				<img src="'.$dir.'images/wave5.svg"/>
        				</a>
        				<div class="border_top">
          	  				<p>Informationen zur Nachricht '.$x.'</p>
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
					<div class="bg_wave"><img class="bg_wave_img" src="'.$dir.'images/wave_audio.jpeg"/></div>
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

';

$morp .= "Audios abspielen / ";