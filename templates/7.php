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
			<section class="section_psychotherapie">
               <div class="'.$edit_mode_class.'"> 
                    <div class="row g-0">
                            <div class="col-12 col-lg-6 align-self-center">
                                <div class="box_psychotherapie_img">
                                '.$imgTop.'
                                    '.$hl.'            
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 align-self-center">
                                <div class="box_psychotherapie_content">
                                   <div id="'.$uniqueID.'" class="directeditmode">#cont#</div>
                                </div>
                            </div>
                    </div>
				'.edit_bar($content_id,"abst_top edit_class").'
                </div>
            </section>
';

} else 	$template = '
			<section class="section_psychotherapie">
               <div class="'.$edit_mode_class.'"> 
                	<div class="row g-0">
                    	<div class="col-12 col-lg-6 align-self-center order-2 order-lg-1">
                        	<div class="box_psychotherapie_content">
	<div id="'.$uniqueID.'" class="directeditmode">#cont#</div>
                        	</div>
                    	</div>
                    	<div class="col-12 col-lg-6 align-self-center order-1 order-lg-2">
                        	<div class="box_psychotherapie_img">
		            	'.$imgTop.'
		            	'.$hl.'            
                        	</div>
                    	</div>
                	</div>
				'.edit_bar($content_id,"abst_top edit_class").'
                </div>
            </section>
';


$imgTop = '';
$hl = '';