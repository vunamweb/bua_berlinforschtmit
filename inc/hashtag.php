<?php
global $lan, $navID, $dir, $morpheus;

$hashtag = isset($_GET["ht"]) ? $_GET["ht"] : '';
// print_r($_GET);

$hashtag = trim($hashtag);
// $suche 	= substr(trim(utf8_decode($suche)),0,30);

if(!$hashtag) {  $output = '<h2>Ihre HashTag-Anfrage ist leer</h2>'; }

else {
	// TRACKING der Suchbegriffe //
	$dat = date("Y-m-d H:m:s");
	$sql = "INSERT morp_suche_track set suche='$suche', time='$dat'".($hashtag ? ", hashtag=1" : "");
	safe_query($sql);
	// ===========================================================//


	$sql = "SELECT * FROM morp_tags t, morp_tags_list l WHERE t.tagID=l.tagID AND tag='$hashtag' ORDER BY art, targetID";
	$res = safe_query($sql);

	$hashtagLong = '';
	$contentImg = '';
	$contentNews = '';



	while ($row = mysqli_fetch_object($res)) {
		if(!$hashtagLong) $hashtagLong = $row->tag_long;

		$id  = $row->targetID;
		$art  = $row->art;

		if($art == "image") {
			$sql = "SELECT * FROM `morp_cms_galerie` g, `morp_cms_galerie_name` n WHERE g.gnid=n.gnid AND g.gid=$id";
			$rs = safe_query($sql);
			$rw = mysqli_fetch_object($rs);

			$img 	= $rw->gname;
			$ordner = $rw->gnname;
			$textde = $rw->gtextde;

			if($img) $contentImg .= '
				<div class="col-md-4">
					<a href="'.$dir.'galerien/galerie+'.$rw->gnid.'/">
						<img class="img-responsive" src="'.$dir.'mthumb.php?w=800&amp;zc=1&amp;src=Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/'.urlencode($img).'">
						<p class="galName">'.$rw->gnname.'</p>
					</a>
				</div>';
		}
		elseif($art == "news") {
			$sql = "SELECT * FROM `morp_cms_news` WHERE nid=$id";
			$rs = safe_query($sql);
			$rw = mysqli_fetch_object($rs);

			$id 		= $rw->nid;
			$ntitle 	= $rw->ntitle;
			$img 	= $rw->img1;
			$nabstr 	= nl2br($rw->nabstr);

			$lnk = $dir.$navID[2].'news+'.$id.'/';


			$contentNews .= '
				<div class="col-md-4">
					<div class="news">
						'.($rw->img1 ? '<img src="'.$dir.'mthumb.php?w=600&amp;h=300&amp;zc=1&amp;src=images/news/'.urlencode($rw->img1).'" alt="'.$ntitle.'" class="img-responsive mt2" />' : '').'
						<h1><a href="'. $lnk .'">'.$ntitle.'</a></h1>
						<p>'.$nabstr.'</p>
						<p class="lnk"><a href="'. $lnk .'"><i class="fa fa-chevron-right mr10"></i> Zum Artikel</a></p>
					</div>
				</div>';
		}
	}












	$output = '
	<div class="container container-xl suche">
		<div class="row">
			<div class="col-md-12">

				<h1>Sie suchen nach: '.$hashtagLong.'</h1>

			</div>
		</div>
		<div class="row">
			<div class="col-md-12">

				<h2>Bildergalerien</h2>

			</div>
		</div>
		<div class="row downloads row-flex row-flex-wrap suche">

			'.$contentImg.'

		</div>
		<div class="row">
			<div class="col-md-12 mt4">

				<h2>Neuigkeiten</h2>

			</div>
		</div>
		<div class="row">

			'.$contentNews.'

		</div>
	</div>
';

}
?>