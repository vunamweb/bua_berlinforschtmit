<?php
/* pixel-dusche.de */

global $uniqueID, $fileID, $lastUsedTemplateID, $anker, $class, $farbe, $tabstand, $anzahlOffenerDIV, $templateIsClosed, $text_rechts, $interner_link;

$fileID = basename(__FILE__, '.php');
$lastUsedTemplateID = $fileID;
$templateIsClosed=1;

$template = '
<section'.($anker ? ' id="'.$anker.'"' : '').' class="'.($tabstand ? ' mt6 ' : '').($class ? $class.' bg-color' : '').'"'.($farbe ? ' style="background:#'.$farbe.'"' : '').'>
    <div class="container">
   		<div class="row">
';


// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
// TEMPLATE


if($tref == 1 || !$tref) $template .= '
            <div class="col-md-4 order-1 order-md-1">
'.$grIMG.'
            </div>
            <div class="col-md-6 order-2 order-md-2 imgPaddingL">
<div id="'.$uniqueID.'" class="directeditmode">#cont#</div>
            </div>
';

else if($tref == 2) $template .= '
            <div class="col-md-6 offset-md-2 order-2 order-md-1 imgPaddingR">
<div id="'.$uniqueID.'" class="directeditmode">#cont#</div>
            </div>
            <div class="col-md-4 order-1 order-md-2">
'.$grIMG.'
            </div>
';

else if($tref == 3) $template .= '
    	  		<div class="col-md-6 offset-md-1 bordertop">
<div id="'.$uniqueID.'" class="directeditmode">#cont#</div>					
				</div>
      	  		<div class="col-md-5 bild">
'.$grIMG.'
				</div>
';

else if($tref == 4) $template .= '
      	  		<div class="col-md-5 bild2">
'.$grIMG.'
				</div>
      	  		<div class="col-md-6 offset-md-1 bordertop">
<div id="'.$uniqueID.'" class="directeditmode">#cont#</div>					
				</div>
';


// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
// END TEMPLATE

$template .= '
    	</div>
	</div>
</section>
';

$anzahlOffenerDIV = 0;

$class = '';
$farbe = '';
$grIMG = '';
$text_rechts = '';

