<?php
/* pixel-dusche.de */

global $cid, $uniqueID, $template2count, $templateTotal;
global $lasttref, $linkbox;

global $containerLink, $containerLinkText, $template2count, $templateTotal, $lastUsedTemplateID, $templateIsClosed, $templateCloseNow;
global $design, $cid, $tref, $farbe, $class, $tende, $tabstand, $tpos, $DoNotCloseTemplate, $anzahlOffenerDIV, $anker, $klasse;
global $class_inner, $farbe_inner, $kontaktCount, $icon, $tclass, $portrait;
global $parallax, $needBG, $needBGCounter, $interner_link, $position;

$edit_mode_class = 'container_edit ';
$template = '';

$fileID = basename(__FILE__, '.php');

//echo $cid;


if ($parallax) {
	$needBG = 1;
}

if(!$needBGCounter) $needBGCounter=1;
else $needBGCounter++; 
if($needBGCounter == 3) $needBGCounter = 1;


if(!$template2count || $template2count < 1) {
	$sql = "SELECT cid FROM morp_cms_content WHERE tid=$fileID AND navid=$cid AND ton=1 ORDER by tpos";
	$res = safe_query($sql);
	$templateTotal = mysqli_num_rows($res);

	$template2count = 1;
}
else $template2count++;


if($lastUsedTemplateID && $lastUsedTemplateID != $fileID && !$templateIsClosed) {
	for($i=1; $i<=$anzahlOffenerDIV; $i++) $template .= '					</div>
';

	$template .= '
				</section>
';
	$templateIsClosed=1;
}


if($template2count == 1 || $templateIsClosed) { $template .= '
<section class="section_multi '.($tclass ? $tclass.' ' : '').($tabstand ? ' pt0 ' : '').($tabstand_bottom? ' pb0 ' : '').'"'.($farbe ? ' style="background:#'.$farbe.';"' : '').($anker ? ' id="'.$anker.'"' : '').'>
'.($parallax ? '<div class="parallax " style="background: url('.$parallax.') no-repeat top center fixed; -webkit-background-size: cover; background-size: cover;">' : '').'
    <div class="container">
        <div class="row'.($tref == 5 ? ' h-100' : '').'">';
	$templateIsClosed=0;
}

        
if($tref == 1 || !$tref) $template .= '
           <div class="'.$edit_mode_class.'col-12 col-lg-6 wow '.($klasse ? ' '.$klasse : ' ').'"'.($linkbox ? ' ref="'.$linkbox.'"' : '').'">
		     '.($class_inner ? '<div class="text-center inner '.$class_inner .'">' : '').'
<div id="'.$uniqueID.'" class="directeditmode">#cont#</div>
            '.($class_inner ? '</div>' : '').'
			'.edit_bar($content_id,"edit_class").'
			</div>
				
';

elseif($tref == 2) $template .= '
            <div class="'.$edit_mode_class.'col-12 col-lg-9'.($klasse ? ' '.$klasse : ' ').'"'.($linkbox ? ' ref="'.$linkbox.'"' : '').'">
            '.($class_inner ? '<div class="text-center inner '.$class_inner .'">' : '').'
<div id="'.$uniqueID.'" class="directeditmode">#cont#</div>
            '.($class_inner ? '</div>' : '').'
			'.edit_bar($content_id,"edit_class").'
            </div>
';

elseif($tref == 3) $template .= '
            <div class="'.$edit_mode_class.'col-12 col-lg-3 "'.($linkbox ? ' ref="'.$linkbox.'"' : '').'>'
            .($needBG ? '<div class="text-center">' : '').
            ($class_inner ? '<div class="text-center inner '.$class_inner .'">' : '').'
<div id="'.$uniqueID.'" class="directeditmode">#cont#</div>
            '.($class_inner ? '</div>' : '').'
            '.($needBG ? '</div>' : '').'
			'.edit_bar($content_id,"edit_class").'
            </div>
';

elseif($tref == 4) $template .= '
            <div class="'.$edit_mode_class.'col-12 col-md-8  "'.($linkbox ? ' ref="'.$linkbox.'"' : '').'>
            '.($class_inner ? '<div class="inner '.$class_inner .'">' : '').'
<div id="'.$uniqueID.'" class="directeditmode">#cont#</div>
            '.($class_inner ? '</div>' : '').'
			'.edit_bar($content_id,"edit_class").'
            </div>
';

elseif($tref == 5) $template .= '
            <div class="'.$edit_mode_class.'col-12 col-md-6 col-lg-4 h-100 "'.($linkbox ? ' ref="'.$linkbox.'"' : '').'>
            '.($class_inner ? '<div class="inner h-100 '.$class_inner .'">' : '').'
<div id="'.$uniqueID.'" class="directeditmode">#cont#</div>
            '.($class_inner ? '</div>' : '').'
			'.edit_bar($content_id,"edit_class").'
            </div>
';

elseif($tref == 6) $template .= '
            <div class="'.$edit_mode_class.'col-12 col-md-6 col-lg-6  "'.($linkbox ? ' ref="'.$linkbox.'"' : '').'>
				<div id="sturm'.$template_page_count.'" class="carousel carousel-std slide" data-bs-ride="carousel">
					<div class="carousel-inner">

<div id="'.$uniqueID.'" class="directeditmode">#cont#</div>
            		</div>
					
					<button class="carousel-control-prev" type="button" data-bs-target="#sturm'.$template_page_count.'" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#sturm'.$template_page_count.'" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
            	</div>
			'.edit_bar($content_id,"edit_class").'
            </div>
';

elseif($tref == 7) $template .= '
            <div class="'.$edit_mode_class.'col-12 col-md-6 col-lg-6"'.($linkbox ? ' ref="'.$linkbox.'"' : '').'">
				<div class="card-service">
					<div class="body">
<div id="'.$uniqueID.'" class="directeditmode">#cont#</div>
					</div>
				</div>
			'.edit_bar($content_id,"edit_class").'
            </div>
';

if(($template2count == $templateTotal || $tende) && !$templateIsClosed) {
	for($i=1; $i<=$anzahlOffenerDIV; $i++) $template .= '					</div>
';

	$template .= '
			
	   </section>
';
	$template2count = 0;
	$templateTotal = 0;
	$templateIsClosed = 1;
	$tende = 0;

	$needBG = 0;
	$needBGCounter = 0;
}

$lastUsedTemplateID = $fileID;
$anzahlOffenerDIV = $parallax ? 2 : 2;

// SPECIAL POPUP TEXT

if($popupTarget && $popupText) $template .= '

<!-- popup Text -->
<div class="modal">
	<div class="modal-body">
		<div class="row" id="'.$popupTarget.'">
			<div class="block mobilePad">
'.$popupText.'
			</div>
		</div>
	</div>
</div>

';


$portrait = '';
$popupTarget = '';
$popupText = '';
$icon = '';
$farbe = '';
$farbe_inner = '';
$class_inner = '';
$anker = '';
$linkbox = '';
$interner_link = '';
$tclass = '';
$class='';
$tabstand = '';
$parallax = '';
