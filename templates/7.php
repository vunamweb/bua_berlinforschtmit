<?php
/* pixel-dusche.de */

global $fileID, $lastUsedTemplateID, $Slider;
global $cid, $uniqueID, $morpheus, $lan, $ipad, $buttons, $styles, $imgTop, $hl;

$Slider = 1;

$fileID = basename(__FILE__, '.php');
$lastUsedTemplateID = $fileID;

$edit_mode_class = 'container_edit ';

if($tref == 1 || !$tref) {
	$template = '
			<section class="headerIMG" style="background:url('.$imgTop.') no-repeat; background-size: cover; background-position: center;">
			   <div class="container '.$edit_mode_class.' h-100"> 
					<div class="row g-0 h-100">
						<div class="col-12 align-self-center text-center">
							<div id="'.$uniqueID.'" class="directeditmode">#cont#</div>
						</div>
					</div>
				'.edit_bar($content_id,"abst_top edit_class").'
				</div>
			</section>
';

} 

$imgTop = '';
$hl = '';