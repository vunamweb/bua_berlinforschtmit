<?php
global $image, $slCt;
$zeilen = explode("\n", $text);

if(!$slCt) $slCt=1;
else $slCt++;

$output .= '
<div class="carousel-cell'.($slCt < 2 ? ' act ive' : '').'">
	'.$image.'
	<div class="carousel-caption">
		<h3 class="">'.$zeilen[0].'</h3>
		<p class="">'.$zeilen[1].'</p>
		<span class="">'.$zeilen[2].'</span>
	</div>
</div>';

$morp = $text;
