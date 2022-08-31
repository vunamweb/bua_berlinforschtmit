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
    <a class="bntmic stop hide" role="button" href="#myPopover1" data-toggle="popover-x" data-placement="top top-right" id="stopButton">
        <span></span>
    </a><br>
    <a class="bntmic restart hide" role="button" id="restartButton">
        <span></span>
    </a><br>
    </p>
  </div>
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


<div class="slider_2">
    <div class="slider__wrapper">';
    $query  = "SELECT * FROM morp_media WHERE mtyp='wav' AND public='true'";
	$query  = "SELECT * FROM morp_media WHERE mtyp='wav'";
	$result = safe_query($query);
	while ($row = mysqli_fetch_object($result)) {
        $name = $row->name;
        $date = $row->email;
        $url_media = 'wav/' . $row->mname; 

        $output .= '<div class="slider__item">
        <a class="play_audio playme play1" href="'.$dir.''.$url_media.'">
          <img src="'.$dir.'images/wave.svg"/>
        </a>
        <div class="border_top">
          <p> '.$name.' // '.$date.'</p>
        </div>
     </div>';
    }    
      
    $output .= '</div>
    <a class="slider__control slider__control_left" href="#" role="button"></a>
    <a class="slider__control slider__control_right slider__control_show" href="#" role="button"></a>
  </div>
</div>
</div>
</section>



<div id="myPopover1" class="popover popover-default popover-x">
    <div class="popover-header popover-title">
        <button class="close reload" data-dismiss="popover-x">
            <img src="'.$dir.'images/SVG/i_close.svg" alt="" class="img-fluid" width="20">
        </button>
        <div id="hl">Haben wir Sie richtig verstanden?</div>
    </div>
    <div class="popover-body popover-content" id="danke">
        <form action="" class="frm_questions" method="post">
        <input type="hidden" id="url_home" value="'.$dir.'">
        '.($rubrik ? '<input type="hidden" name="rubrik" id="rubrik" value="'.$rubrik.'">' : '').'
            <div class="row">
                <div class="col-12">
					<button id="pauseButton" disabled="" class="hide">Pause</button> 
					<div id="formats" class="hide"></div>
					<ol id="recordingsList"></ol>
                    <p><a href="#" class="btn btn_audio"><img src="'.$dir.'stimmen/images/SVG/i_btn_audio.svg" alt="" class="img-fluid" width="150"> <span>0.12</span></a></p> 
                </div>
                <div class="col-12 col-lg-6 mt2">
                    <a href="<?php echo $dir.$navID[3]; ?>" class="btn btnRecord recordagain">Erneut aufnehmen</a>
                </div>
                <div class="col-12 col-lg-6 mt2">
                	<p class="message"></p>
                	<input type="text" name="name" id="name" class="form-control mb2" placeholder="name"/>
                	<input type="text" name="email" id="email" class="form-control mb2" placeholder="email"/>
                	<div class="custom-control custom-checkbox">
                    	<label class="custom-control-label" for="ck01">
                    		<input type="checkbox" class="custom-control-input" id="ck01">
							Ja, ich stimme der Nutzung meiner Daten gemäß <a href="'.$dir.'stimmen/datenschutz/">AGB und DSGVO</a> zu
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
<div id="myPopover2" class="popover psmall popover-x popover-default">
    <div class="popover-header popover-title">
        <button class="close reload" data-dismiss="popover-x">
            <img src="'.$dir.'images/SVG/i_close.svg" alt="" class="img-fluid" width="20">
        </button>
    </div>
    <div class="popover-body popover-content">
            <div class="row">
                <div class="col-12 mt2">
                    <p class="danke"><b>Vielen Dank für Ihre Stimme!</b></p>
                    <p class="mb-0">Wir nehmen uns Ihre Worte zu Herzen. Die Auswertung erfolgt voraussichtlich im April 2021. Unter <a href="#ansehen" data-scroll="">Ergebnisse ansehen</a> finden Sie einen Überblick über den Diskurs. Natürlich können Sie auch weitere <a href="#anhoeren" data-scroll="">Sprachnachrichten anhören</a>.</p>
                </div>
            </div>
    </div>
</div>
';

//$output = 'ddd';