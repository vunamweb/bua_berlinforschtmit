<?php
global $dir, $cid, $morpheus, $table, $mid, $profile, $navID, $jsFunc;
global $arr_form, $table, $tid, $mylink;


$show = 1;

include('angebot_arr.php');
// print_r($profile);



$sql = "SELECT * FROM `$table` WHERE mid=$mid";
$res = safe_query($sql);
$checkit = mysqli_num_rows($res);

	$output .= '
<div class="container mt2">
	<div class="row ">
		<div class="col-12 text-center">
			<h1>Verwaltung: Meine Angebote / Suchanfragen</h1>
		</div>
	</div>
</div>

<div class="container angebote">
	<div class="row bg-sand pad1 edit-desc">
		<div class="col-sm-4">
			<p><b>Foto</b></p>
		</div>
		<div class="col-sm-4">
			<p><b>Angaben</b></p>
		</div>
		<div class="col-sm-4">
			<p>
				<b>Beschreibung</b>
			</p>
		</div>
	</div>
';

while($row = mysqli_fetch_object($res)) {

	$images = '';
	for($i=1;$i<=1;$i++) {
		$get = "img".$i;
		if($row->$get) $images .= '<img src="'.$dir.'mthumb.php?h=150&amp;src=images/angebote/'.urlencode($row->$get).'" class="img-responsive" />';
	}

	$output .= '
	<div class="row borderBottom">
		<div class="col-sm-4">
			'.($images ? $images : '').'
		</div>
		<div class="col-sm-4 edit-text">
			<h2>
				'.$row->aTitle.'
			</h2>
			<p>
				Preis: <b>'.$row->aPreis.'</b><br>
				'.($row->datumende ? 'Ablaufdatum: '.euro_dat($row->datumende).'<br>' : '').'
				Meine E-Mail: <b>'.$row->mail.'</b><br>
				Meine Telefonnummer: '.$row->fon.'<br>
			</p>
		</div>
		<div class="col-sm-3">
			<p>
			'.nl2br($row->aDesc).'<br>
			</p>
		</div>
		<div class="col-sm-1">
			<p>
			<span class="sichtbar edit-btn"><i class="fa fa-eye'.($row->sichtbar ? '' : '-slash').' tool '.($row->sichtbar ? '' : 'tool-white').' state" ref="'.$row->aid.'"></i></span>
			<span class="edit-btn"><a href="'.$dir.$navID[21].'edit+'.$row->aid.'/"><i class="fa fa-pencil tool"></i></a></span>
			<span class="edit-btn"><a href="'.$dir.$navID[21].'deljob-'.$row->aid.'+'.$row->aid.'/"><i class="fa fa-eraser tool warn"></i></a></span>
			</p>
		</div>
	</div>

';

}


	$output .= '

	<div class="row mt2">
		<div class="col-md-12">
			<a href="'.$dir.$navID[19].'" class="btn btn-default"><i class="fa fa-plus"></i> Neues Angebot erstellen</a>
		</div>
	</div>

</div>

';


	$jsFunc .= '

	 $(".state").on("click", function() {
	  	aid = $(this).attr("ref");
	  	chk = $(this).hasClass("tool-white");
	  	if(chk) { value=1; $(this).removeClass("tool-white"); $(this).removeClass("fa-eye-slash"); $(this).addClass("fa-eye");  }
	  	else { value=0; $(this).addClass("tool-white"); $(this).addClass("fa-eye-slash"); $(this).removeClass("fa-eye"); }
	  	console.log(value);
	    request = $.ajax({
	        url: "'.$dir.'morpheus/Update.php",
	        type: "post",
	        data: "table='.$table.'&feld=aid&data="+value+"&id="+aid+"&pos=sichtbar",
	        success: function(data) {
			//	console.log(data);
			}
	    });
	});

	';
?>