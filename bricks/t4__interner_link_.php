<?php
global $navarray, $lan, $navID, $produkt_group_arr, $multilang, $ilink;

$tmp 	= explode("|", $text);
$anker 	= explode("#", $tmp[0]);
$link 	= trim($anker[0]);
$anker	= $anker[1];
$txt 	= $tmp[1];

$output .= '<a href="'.$dir.($multilang ? $lan.'/' : '').$navID[$link].'" class="btn btnmore_info"><span>'.$txt.'</span></a>
		</div>
	</li>
';

$morp = '<b>Link</b>: '.$txt.'<br/>';

?>