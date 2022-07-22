<?php
/* pixel-dusche.de */

global $uniqueID, $hl,$uniqueID, $button, $imgSize, $imgClass;
global $fileID, $lastUsedTemplateID, $anker;

$fileID = basename(__FILE__, '.php');
$lastUsedTemplateID = $fileID;

$edit_mode_class = 'container_edit ';

$template = '
	<div class="container-fluid '.$edit_mode_class.'">
		<div class="row">
			<div id="'.$uniqueID.'" class="directeditmode">#cont#</div>
			'.edit_bar($content_id,"edit_class").'
		</div>
	</div>
';

$hl = '';
$button = '';

