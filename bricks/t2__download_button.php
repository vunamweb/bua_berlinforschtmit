<?php
global $pdf, $dir, $ctDL, $closeDL, $isDownload;

if($text) {
	$query  = "SELECT * FROM `morp_cms_pdf` where pid=$text";
	$result = safe_query($query);
	$row = mysqli_fetch_object($result);

	$de = $row->pdesc;
	$nm = $row->pname;
	$si = $row->psize;
	$da = $row->pdate;
	$pi = $row->pimage;
	$pl = $row->plong;
	$da = euro_dat($da);

	$typ = explode(".", $nm);
	$c	 = (count($typ)-1);
	$img = $typ[$c]."_s.gif";

	if(!$ctDL) $ctDL = 1;
	else $ctDL++;

	if($ctDL == 3) $ctDL = 1;

	$closeDL = $ctDL == 2 ? 0 : 1;
	$isDownload = 1;

	$output .= '<a href="'.$dir.'pdf/'.$nm.'" target="_blank" title="'.$nm.' zum Download" class="btn btn-info btn-text mb-2 mb-lg-0 mr-2">'.$de.'</a>';
}
$morp = '<b>Download:</b> '.$de.'<br/>';
