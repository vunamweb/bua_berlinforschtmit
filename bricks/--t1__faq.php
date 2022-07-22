<?php
/* pixel-dusche.de */

global $wiki, $wiki_nav;

$table 		= 'morp_faq';
$nameField 	= "name";
$sortField 	= 'reihenfolge';



$sql = "SELECT * FROM `$table` WHERE 1 ORDER BY $sortField ASC";
$res = safe_query($sql);
$anz = mysqli_num_rows($res);
$x = 0;


while ($row = mysqli_fetch_object($res)) {
	$x++;
	$output .= '
<div class="box_content_items">
	<div class="row">
		<div class="col-12 col-lg-3">
			<h2>'.$x.'. '.$row->name.'</h2>
		</div>
		<div class="col-12 col-lg-9">
			<div class="multicol__2">'.$row->faq.'</div>
		</div>
	</div>
</div>';


}

$wiki .= '</div>';

$morp = "FAQ Modul";

?>