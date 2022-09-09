<?php
/* pixel-dusche.de */

global $uniqueID, $hl, $uniqueID, $anker, $headerImg, $anzahlOffenerDIV;
global $fileID, $lastUsedTemplateID, $templateIsClosed, $tclass, $img__header, $audio_file, $modal;

$fileID = basename(__FILE__, '.php');
$lastUsedTemplateID = $fileID;
$templateIsClosed = 1;
$anzahlOffenerDIV = 0;

$edit_mode_class = 'container_edit ';

//echo $tref . '///';

if($tref == 1)
$template = '
<section class="record_audio" ' . ($anker ? ' id="' . $anker . '"' : '') . '>
    <div class="container">
		<div class="row">
			<div class="col-12 col-lg-6 ">
#cont#
			</div>
			<div class="col-12 col-lg-6 ">
     '.$img__header.'
			</div>
			
			'.$audio_file.'
			
		</div>
	</div>
</section>

'.$modal;

