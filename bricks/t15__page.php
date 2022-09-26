<?php
# $output .= $text;
$page = explode("?", trim($text));
$ziel = $page[1];

if($justInfo)
	$morp = ' INCLUDE '.$page[0] .' // ';
else
	include("page/".$page[0]);
