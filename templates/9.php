<?php
/* pixel-dusche.de */

global $uniqueID, $hl,$uniqueID, $anker, $headerImg, $anzahlOffenerDIV;
global $fileID, $lastUsedTemplateID, $templateIsClosed, $tclass;

$fileID = basename(__FILE__, '.php');
$lastUsedTemplateID = $fileID;
$templateIsClosed=1;
$anzahlOffenerDIV = 0;
	
$edit_mode_class = 'container_edit ';


$template = '
    <section'.($anker ? ' id="'.$anker.'"' : '').'>
		<div class="slider">			
				<div id="'.$uniqueID.'" class="directeditmode">
				</div>									
			<div class="slider__wrapper">
#cont#
			</div>
			<a class="slider__control slider__control_left" href="#" role="button"></a>
			<a class="slider__control slider__control_right slider__control_show" href="#" role="button"></a>
		</div>

		'.edit_bar($content_id,"edit_class").'

	</section>';

