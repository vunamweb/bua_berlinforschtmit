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

$output .= '
	'.($ctDL == 1 ? '<div class="row">' : '').'
		<div class="col-2">
			<a href="'.$dir.'pdf/'.$nm.'" target="_blank" title="'.$nm.' zum Download"><img src="'.$dir.'mthumb.php?h=150&amp;src=images/userfiles/image/'.$typ[0].'.jpg" alt="" class="img-fluid border" /></a>
		</div>
		<div class="col-4">
			<a href="'.$dir.'pdf/'.$nm.'" target="_blank" title="'.$nm.' zum Download"><b>'.$de.'</b></a><br/>
			'.($pl ? nl2br($pl) : '').'
		</div>
	'.($ctDL == 2 ? '
	</div>
	<hr>' : '').'
';
}
$morp = '<b>Download:</b> '.$de.'<br/>';
?>