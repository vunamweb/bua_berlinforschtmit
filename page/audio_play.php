<?php
global $morpheus, $audio_file, $modal;

$rubrik = $_POST["rubrik"] ? $_POST["rubrik"] : '';

$output .= '		
		<h1 class="mw">Aktuelle Nachrichten</h1>
		<div class="slider_2">
    		<div class="slider__wrapper">';
    			$query  = "SELECT mp3, mdesc, name, email FROM morp_media WHERE mp3<>'' AND (ck02='true' OR ck02='1')";
				// $query  = "SELECT * FROM morp_media WHERE mtyp='wav'";
				// $query  = "SELECT * FROM morp_media WHERE 1";
				$result = safe_query($query);
				$x = 0;
				while ($row = mysqli_fetch_object($result)) {
        			$name = $row->name;
        			$date = $row->email;
        			$url_media = 'mp3/' . $row->mp3; 
					$x++;
        			$output .= '
					<div class="slider__item">
        				<a class="play_audio playme play1 row h-100 d-flex align-items-center " href="'.$dir.''.$url_media.'">
          	  				<div class="col-4 col-lg-3">
								<img src="'.$dir.'images/playme.svg"/>
							</div>
							<div class="col-8  col-lg-9">
          	  					<span>'.$row->mdesc.'</span>
							</div>
        				</a>
     				</div>';
    			}    
      		
    		$output .= '
			</div>
    			
			<a class="slider__control slider__control_left" href="#" role="button"></a>
    		<a class="slider__control slider__control_right slider__control_show" href="#" role="button"></a>
		</div>
	
 		<div class="row waveform_player">
			<div class="col-9 col-md-10">
				<div id="waveform">
					<!-- Here be waveform -->
					
				</div>
			</div>
			<div class="col-3 col-md-2 align-self-center">
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