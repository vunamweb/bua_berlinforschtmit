<?php
/* pixel-dusche.de */

global $hl,$uniqueID, $button, $imgSize, $imgClass;
global $fileID, $lastUsedTemplateID, $anker, $subline;

$fileID = basename(__FILE__, '.php');
$lastUsedTemplateID = $fileID;

$edit_mode_class = 'container_edit ';

$template = '

        <section class="clinical_pictures">            
            <div class="'.$edit_mode_class.'container">
                <div class="row">
                    <div class="col-12 col-lg-12">
						'.$subline.'
                        <div class="box_clinical_pictures">
				#cont#
                        </div>
                    </div>
                </div>
            '.edit_bar($content_id,"edit_class").'
            </div>   
        </section>			
';

$hl = '';
$button = '';
$subline = '';
