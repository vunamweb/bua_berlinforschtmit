<?php
global $dir, $cid, $morpheus, $table, $mid, $profile, $navID;
global $arr_form, $table, $tid, $mylink;


$show = 0;

include('angebot_arr.php');
// print_r($profile);

// ORDNER /Directory => gnname

$row = '';

	$form = '';

	foreach($arr_form as $arr) {
	 	$form .= setMorpheusForm($row, $arr, "portrait", $mid, 0, "mid");
	}


	$output .= '
<div class="container">
	<div class="row">
		<div class="col-sm-6">

			<form method="post" action="'.$dir.$navID[21].'">
				<input type="hidden" value="1" name="neu" />
				<input type="hidden" value="1" name="save" />
				'.$form.'
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; Anlegen</button>
			</form>

		</div>
		<div class="col-sm-6">
			'.($portrait ? '<img src="'.$dir.'mthumb.php?w=300&amp;h=300&amp;src=images/portrait/'.urlencode($portrait).'" class="mt2" />' : '').'
		</div>
	</div>
	<div class="row">

	</div>
</div>

';



?>