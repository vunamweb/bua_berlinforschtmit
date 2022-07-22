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
		<div class="'.$edit_mode_class.' col-12 col-md-6 col-lg-6'.($tclass ? ' '.$tclass : '').'"'.($linkbox ? ' ref="'.$linkbox.'"' : '').'"'.($anker ? ' id="'.$anker.'"' : '').'>
			<div class="card-service">
				<div id="'.$uniqueID.'" class="directeditmode">
					#cont#
				</div>
				'.edit_bar($content_id,"edit_class").'
				</div>
			</div>
		</div>
	</section>';

