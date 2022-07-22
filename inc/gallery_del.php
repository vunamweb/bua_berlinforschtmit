<?php
global $img_pfad, $dir, $druckversion, $navID, $lan, $morpheus, $galHR, $galLR, $cid, $js;
global $justMine, $galerie;

$galerie = isset($_GET["nid"]) ? $_GET["nid"] : 0;

$gal2del = isset($_POST["gal2del"]) ? $_POST["gal2del"] : 0;

if($gal2del) {
	$que  	= "SELECT * FROM `morp_cms_galerie_name` n, `morp_cms_galerie` g WHERE n.gnid=".$gal2del." AND g.gnid=n.gnid AND mid=".$_SESSION["mid"]." ORDER BY g.sort";
	$res 	= safe_query($que);

	if(mysqli_num_rows($res)>0 ) {
		while($row = mysqli_fetch_object($res)) {
			$img 	= $row->gname;
			$ordner = $row->gnname;

			$img2del = DIR.'/Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/'.$img;

			unlink($img2del);
		}

		$dir2del = DIR.'/Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/';
		rmdir($dir2del);

		$que  	= "DELETE FROM `morp_cms_galerie_name` WHERE gnid=".$gal2del." AND mid=".$_SESSION["mid"];
		$res 	= safe_query($que);
		$que  	= "DELETE FROM `morp_cms_galerie` WHERE gnid=".$gal2del." AND mid=".$_SESSION["mid"];
		$res 	= safe_query($que);

		$output .= '

		<p class="alert alert-danger mt6 text-center" style="font-size:1.25em;">GELÖSCHT</p>
		<div class="text-center">
			<br/><a class="btn btn-info" href="'.$dir.$navID[9].'">zurück</a>
		</div>
		';
	} else 		$output .= '

		<p class="alert alert-danger mt6 text-center" style="font-size:1.25em;">Fehler !</p>
		<div class="text-center">
			<br/><a class="btn btn-info" href="'.$dir.$navID[9].'">zurück</a>
		</div>
		';

}

elseif($galerie) {
	$que  	= "SELECT gnname FROM `morp_cms_galerie_name` WHERE gnid=".$galerie."";
	$res 	= safe_query($que);
	$row = mysqli_fetch_object($res);

	$output .= '

	<p class="alert alert-danger mt6 text-center" style="font-size:1.25em;">Sind Sie sich sicher, dass Sie die Galerie "<strong>'.$row->gnname.'</strong>" löschen möchten?</p>
	<div class="text-center">
		<form method="POST"><input type="hidden" name="gal2del" value="'.$galerie.'"><button class="btn btn-danger">Galerie unwiderruflich Löschen</button></form>
		<br/><a class="btn btn-info" href="'.$dir.$navID[9].'">abbrechen</a>
	</div>
	';
}

//$galerie = 1;

$morp = "Galery $text";

?>