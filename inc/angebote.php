<?php
global $dir, $cid, $morpheus, $table, $mid, $profile, $navID, $jsFunc;
global $arr_form, $table, $tid, $mylink;


$show = 1;

$angebot = isset($_GET["nid"]) ? $_GET["nid"] : 0;
$isAngebot = isset($_GET["anfrage"]) ? $_GET["anfrage"] : 0;

include('angebot_arr.php');
// print_r($profile);

$angebote = 0;

if($angebot) {
	$sql = "SELECT * FROM `$table` WHERE sichtbar=1 AND aid=$angebot";
	$res = safe_query($sql);

	$output .= '
	<div class="container angebote">
		<div class="container mb2 center">
			<a href="'.$dir.'?hn=schwarzes-brett&cont=schwarzes-brett" class="btn btn-default'.(!$isAngebot ? ' btn-info' : '').'">Alle</a>
			<a href="'.$dir.'?hn=schwarzes-brett&cont=schwarzes-brett&anfrage=1" class="btn btn-default'.($isAngebot == 1 ? ' btn-info' : '').'">nur Angebote</a>
			<a href="'.$dir.'?hn=schwarzes-brett&cont=schwarzes-brett&anfrage=2" class="btn btn-default'.($isAngebot == 2 ? ' btn-info' : '').'">wird gesucht</a>

			<a href="'.$dir.$navID[19].'" class="btn btn-success lm10"><i class="fa fa-plus" style="padding:0 4px 0 0;"></i> '.$navarrayFULL[19].'</a>
			<hr>
		</div>
		<div class="row downloads">
';

	$row = mysqli_fetch_object($res);
	$images = '';
	$anzahlImages = 0;
	$isAngebot = $row->isAngebot;

	for($i=1;$i<=4;$i++) {
		$get = "img".$i;
		if($row->$get && $i !=2) $images .= '<a href="'.$dir.'images/angebote/'.($row->$get).'" data-toggle="lightbox" data-gallery="stift-'.$row->aid.'"></a>';
	}

	$img = $row->img1 ? '<img src="'.$dir.'mthumb.php?w=500&amp;src=images/angebote/'.urlencode($row->img1).'" class="img-responsive" />' : '';
	$output .= '
		<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
			<div class="download-item'.($isAngebot ? '' : ' bg-light').'">
				'.($img ? $img.'<hr>' : '').'

				<h1>'.$row->aTitle.'</h1>

					<p class="zeile1"><em class="leftcol">Preis:</em> <b class="rightcol">'.$row->aPreis.'</b></p>
					<p class="zeile"><em class="leftcol">Kontakt: </em> <b class="rightcol"><a href="mailto:'.$row->mail.'?subject=Anfrage zum Angebot aus dem Intranet&body='.$row->aTitle.'"><i class="fa fa-gavel"></i> &nbsp; '.$row->mail.'</a></b></p>
					'.($row->fon ? '<p class="zeile"><em class="leftcol">Telefon: </em> <b class="rightcol"><a href="tel:'.$row->fon.'">'.$row->fon.'</a></b></p>' : '').'


				<p>
					'.nl2br($row->aDesc).'<br>
				</p>
				'.($row->img2 ? '<hr>
				<p><a data-toggle="lightbox" data-gallery="stift-'.$row->aid.'" href="'.$dir.'/images/angebote/'.$row->img2.'" class="btn btn-default"><i class="fa fa-camera"></i> weitere Bilder</a>'.$images.'</p>' : '').'
			</div>
		</div>
';

	$output .= '</div>';



}

else {
	// REIHENFOLGE !!!!

// 					'.($row->datumende ? 'Ablaufdatum: '.euro_dat($row->datumende).'<br>' : '').'

	$where = '';
	if($isAngebot == 1) $where = " AND isAngebot=1";
	elseif($isAngebot == 2) $where = " AND isAngebot=0";

	$sql = "SELECT * FROM `$table` WHERE sichtbar=1 $where ORDER BY aid DESC";
	$res = safe_query($sql);
	$anzahl = mysqli_num_rows($res);

	$output .= '
	<div class="container-full angebote">
		<div class="container mb2 center">
			<a href="'.$dir.'?hn=schwarzes-brett&cont=schwarzes-brett" class="btn btn-default'.(!$isAngebot ? ' btn-info' : '').'">Alle</a>
			<a href="'.$dir.'?hn=schwarzes-brett&cont=schwarzes-brett&anfrage=1" class="btn btn-default'.($isAngebot == 1 ? ' btn-info' : '').'">nur Angebote</a>
			<a href="'.$dir.'?hn=schwarzes-brett&cont=schwarzes-brett&anfrage=2" class="btn btn-default'.($isAngebot == 2 ? ' btn-info' : '').'">wird gesucht</a>

			<a href="'.$dir.$navID[19].'" class="btn btn-success lm10"><i class="fa fa-plus" style="padding:0 4px 0 0;"></i> '.$navarrayFULL[19].'</a>
			<hr>
		</div>
		<div class="row downloads row-flex row-flex-wrap">
';

	$x=0;


	while($row = mysqli_fetch_object($res)) {
		$x++;
		$images = '';
		$anzahlImages = 0;
		$isAngebot = $row->isAngebot;


		for($i=1;$i<=4;$i++) {
			$get = "img".$i;
			if($row->$get && $i !=2) $images .= '<a href="'.$dir.'images/angebote/'.($row->$get).'" data-toggle="lightbox" data-gallery="stift-'.$row->aid.'"></a>';
		}

		$img = $row->img1 ? '<img src="'.$dir.'mthumb.php?w=500&amp;src=images/angebote/'.urlencode($row->img1).'" class="img-responsive" />' : '';
		$output .= '
		<div class="col-sm-6 col-md-4 col-lg-3">
			<div class="download-item'.($isAngebot ? '' : ' bg-light').'">
				'.($img ? $img.'<hr>' : '').'

				<h1>'.$row->aTitle.'</h1>

					<p class="zeile1"><em class="leftcol">Preis:</em> <b class="rightcol">'.$row->aPreis.'</b></p>
					<p class="zeile"><em class="leftcol">Kontakt: </em> <b class="rightcol"><a href="mailto:'.$row->mail.'?subject=Anfrage zum Angebot aus dem Intranet&body='.$row->aTitle.'"><i class="fa fa-gavel"></i> &nbsp; '.$row->mail.'</a></b></p>
					'.($row->fon ? '<p class="zeile"><em class="leftcol">Telefon: </em> <b class="rightcol"><a href="tel:'.$row->fon.'">'.$row->fon.'</a></b></p>' : '').'


				<p>
					'.nl2br($row->aDesc).'<br>
				</p>
				'.($row->img2 ? '<hr>
				<p><a data-toggle="lightbox" data-gallery="stift-'.$row->aid.'" href="'.$dir.'/images/angebote/'.$row->img2.'" class="btn btn-default"><i class="fa fa-camera"></i> weitere Bilder</a>'.$images.'</p>' : '').'
			</div>
		</div>
';

	}

	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	// because of flex modelling i have to set empty div container
	$rest = explode(".", $anzahl/4);
	if($rest[1] > 0) {
		$rest = $rest[1];
		if($rest == 25) $rest = 3;
		elseif($rest == 5) $rest = 2;
		else $rest = 1;

		for($a=1; $a<=$rest; $a++) {
			$output .= '	            <div class="col-md-3 col-sm-4 col-xs-6"><div class=""></div></div>
';
		}
	}
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

	$output.='
</div>
	';

}

?>