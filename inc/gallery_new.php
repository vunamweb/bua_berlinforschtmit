<?php
global $dir, $cid, $morpheus, $galerie, $mid, $navID, $mylink;


// safe_query($sql);

//	print_r($_SESSION);

// $mid = $_SESSION["mid"];

$setGalerie = $_POST["setGalerie"];


$arr_form = array(
	array("gntextde", "Titel der Galerie", '<input type="Text" value="#v#" class="form-control" name="#n#" required />'),
	array("textde", "Kurze Beschreibung der Galerie", '<textarea class="form-control" name="#n#" required>#v#</textarea>'),
);


// ORDNER /Directory => gnname

if($setGalerie) {
	$sqlNew = 'INSERT `morp_cms_galerie_name` SET ggid=1, ';
	$x = count($arr_form);
	$y = 0;

	foreach($arr_form as $arr) {
		$y++;
		$get = $arr[0];
	 	$sqlNew .= '`'.$arr[0]."`='". $_POST[$get]. "'" .($y < $x ? ', ' : '');
	}

	// DARF Benutzer Galerie anlegen?

	$directory = date("Ymd").'-'.eliminiere($_POST["gntextde"]);

	$sql = "SELECT * FROM `morp_cms_galerie_name` WHERE gnname='".$directory."'";
	$res = safe_query($sql);
	$checkit = mysqli_num_rows($res);

	if($checkit > 0) $directory .= '-'.rand(0,999);

	// SET PATH
	$structure = DIR.'/Galerie/'.$morpheus["GaleryPath"].'/'.$directory.'/';

	// MAKE DIR

	if (!mkdir($structure, 0777, true)) {
	    die('Erstellung der Verzeichnisse '.$structure.' schlug fehl...');
	}
	chmod($structure, 0777);

	$sqlNew .= ", gnname='".$directory."', mid=$mid , date='".date("Y-m-d")."'";
	$res = safe_query($sqlNew);
	$galID = mysqli_insert_id($mylink);


	// https://www.stkatwei.de/galerien/galerie-edit/edit+1/
	$output .= '
<script>
	location.href="'.$dir.$navID[8].'edit+'.$galID.'/";
</script>

	';

	// $output .= $sql.'<br>-'.$checkit.'-<br>'.$sqlNew;
}

else {
	$form = '';
	foreach($arr_form as $arr) {
	 	$form .= setMorpheusForm($row, $arr, "", 0, 0, 0);
	}

	$galerie = 1;

	$output .= '
<div class="container">
	<div class="row">

		<form method="post">
			<input type="hidden" value="1" name="setGalerie" />
			'.$form.'
			<button type="submit" class="btn btn-default">Abschicken</button>
		</form>
	</div>
</div>

';
}


?>