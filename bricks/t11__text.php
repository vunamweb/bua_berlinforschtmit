<?php
global $image, $slCt;
$zeilen = explode("\n", $text);

if(!$slCt) $slCt=1;
else $slCt++;

$output .= '
<div class="carousel-item'.($slCt < 2 ? ' active' : '').'">
	'.$image.'
	<div class="carousel-caption">
		<h3 class="animate__animated animate__bounceInRight animate__delay-1s">'.$zeilen[0].'</h3>
		<p class="animate__animated animate__bounceInLeft d-none d-md-block animate__delay-2s">'.$zeilen[1].'</p>
		<p class="animate__animated animate__bounceInRight animate__delay-3s">'.$zeilen[2].'</p>
	</div>
</div>';

$morp = $text;
