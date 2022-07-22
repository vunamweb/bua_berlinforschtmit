<?php
global $navarray, $lan, $navID, $multilang, $ddID, $div__link;

$tmp 	= explode("|", $text);
$anker 	= explode("#", $tmp[0]);
$link 	= trim($anker[0]);
$anker	= $anker[1];
$txt 	= $tmp[1];

$output .= '<p><a href="'.$dir.$navID[$link].'" class="btn-link">'.$txt.'</a></p>';

$morp = '<b>Link</b>: '.$txt.'<br/>';

?>