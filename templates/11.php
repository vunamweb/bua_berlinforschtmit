<?php
/* pixel-dusche.de */

global $emotional, $headerImg;
global $uniqueID, $fileID, $lastUsedTemplateID, $anzahlOffenerDIV, $templateIsClosed, $slCt, $klasse, $tabstand;

$fileID = basename(__FILE__, '.php');
$lastUsedTemplateID = $fileID;

$edit_mode_class = 'container_edit ';

if($lastUsedTemplateID && $lastUsedTemplateID != $fileID && !$templateIsClosed) {
	for($i=1; $i<=$anzahlOffenerDIV; $i++) $template .= '					</div>
';

	$template .= '
				</section>
';
	$templateIsClosed=1;
}

$indicator = '';
for($i=1; $i<=$slCt; $i++) {
	$indicator .= '<button aria-label="Slide '.$i.'"'.($i < 2 ? ' class="active"' : '').' data-bs-slide-to="'.($i-1).'" data-bs-target="#BUASlider" type="button"></button> ';
}

$template = '
<section class="'.$edit_mode_class.($tabstand ? ' pt0 ' : '').($klasse ? ' '.$klasse : '').'">
	<div class="carousel slide" data-bs-ride="carousel" id="BUASlider">
		<div class="carousel-indicators">
			'.$indicator.'		
		</div>
		<div class="carousel-inner">
		
			#cont#
		
		</div>
		<button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#BUASlider" type="button"><span aria-hidden="true" class="carousel-control-prev-icon"></span> <span class="visually-hidden">Previous</span></button> 
		<button class="carousel-control-next" data-bs-slide="next" data-bs-target="#BUASlider" type="button"><span aria-hidden="true" class="carousel-control-next-icon"></span> <span class="visually-hidden">Next</span></button>
	</div>
	'.edit_bar($content_id,"edit_class").'
</section>

';
