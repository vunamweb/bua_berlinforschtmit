<?php
global $morpheus, $audio_file, $modal;

$rubrik = $_POST["rubrik"] ? $_POST["rubrik"] : '';

$output .= '
    		<div class="row">
				<div class="col-12 col-lg-6 mt2">
					<div class="startbtn">
						<b id="recordButton">
							<img src="'.$dir.'images/Sprachnachrichten.svg" alt="" class="img-fluid audio-btn" />
						</b>
					</div>	
				</div>	
    			
				<div class="col-12 col-lg-6 mt2">
					<div class="startbtn">
						<a href="#" data-toggle="modal" data-target="#stimmeText" id="textstimme">
								<img src="'.$dir.'images/Textnachrichten.svg" alt="" class="img-fluid audio-btn" />
						</a>
					</div>	
				</div>	
			</div>	
					
					
			<div class="record-bg">
				<div class="on_record">
					<div class="count_time hide"><label id="minutes">00</label>:<label id="seconds">00</label></div>
    				<div id="display_wave"></div>
					
    				<a class="bntmic stop hide" role="button" href="#" data-toggle="modal" data-target="#audioModal" id="stopButton">
        				<span></span>
    				</a><br>
    				<a class="bntmic restart hide" role="button" id="restartButton">
        				<span></span>
    				</a>
				</div>
			</div>';


$modal = '
<!-- Modal -->
<div class="modal fade" id="audioModal" aria-labelledby="audioModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div id="hl">Haben wir Sie richtig verstanden?</div>
				<button type="button" class="btn-close close reload" data-dismiss="modal" aria-label="Close"></button>
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
								<p><a href="#" class="btn btn-success btnRecord recordagain">Erneut aufnehmen</a></p>
            				</div>
            				<div class="col-12 col-lg-6 mt2">
            					<p class="message"></p>
            					<input type="text" name="name" id="name" class="form-control mb2" placeholder="name"/>
            					<input type="text" name="email" id="email" class="form-control mb2" placeholder="email"/>
            					<div class="custom-control custom-checkbox">
                					<label class="custom-control-label" for="ck01">
                						<input type="checkbox" class="custom-control-input" id="ck01" required>
										Ja, ich stimme der Nutzung meiner Daten gemäß <a href="'.$dir.'datenschutz/">AGB und DSGVO</a> zu*
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
								* Pflichtfeld                                                                                    
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