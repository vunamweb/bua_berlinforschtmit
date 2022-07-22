<?php
global $navarray, $lan, $navID, $containerLink, $containerLinkText, $multilang;

$tmp 	= explode("|", $text);
$anker 	= explode("#", $tmp[0]);
$link 	= trim($anker[0]);
$anker	= $anker[1];
$txt 	= explode("#", $tmp[1]);


$output .= '<p><a href="'.$dir.($multilang ? $lan.'/' : '').$navID[$link].'">'.$txt[0].($txt[1] ? ' <span>'.$txt[1].'</span>' : '').'</a></p>';


$morp = '<b>Link</b>: '.$txt.'<br/>';

?>