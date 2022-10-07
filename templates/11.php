<?php
/* pixel-dusche.de */

global $emotional, $headerImg, $image_overlay;
global $uniqueID, $fileID, $lastUsedTemplateID, $anzahlOffenerDIV, $templateIsClosed, $slCt, $klasse, $tabstand, $js;

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
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="" id="BUASlider">
					<div class="main-carousel">		
						#cont#		
					</div>		
				</div>
				'.edit_bar($content_id,"edit_class").'
			</div>
		</div>
	</div>
</section>

';


$js .= "
var fcarousel = $('.main-carousel').flickity({
	contain: true,
	autoPlay: 6000,
	wrapAround: true
});

fcarousel.on( 'scroll.flickity', function( event, progress ) {
  $('.carousel-caption h3').removeClass('animate__animated');
  $('.carousel-caption h3').addClass('animate__animated');
});

";