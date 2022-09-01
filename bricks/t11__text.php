<?php
global $image, $slCt;
$zeilen = explode("\n", $text);

if(!$slCt) $slCt=1;
else $slCt++;

$output .= '
<div class="carousel-item'.($slCt < 2 ? ' active' : '').'">
	'.$image.'
	<div class="carousel-caption">
		<h3 class="animated bounceInRight" style="animation-delay: 1s">'.$zeilen[0].'</h3>
		<p class="animated bounceInLeft d-none d-md-block" style="animation-delay: 2s">'.$zeilen[1].'</p>
		<p class="animated bounceInRight" style="animation-delay: 3s">'.$zeilen[2].'</p>
	</div>
</div>';

$morp = $text;
