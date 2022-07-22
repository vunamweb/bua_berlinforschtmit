<?php
	global $upload, $dir, $navID, $js, $morpheus, $galerie, $mid;
	$upload = 1;
?>

<?php

$output .= '
	<div class="container">
		<div class="row">
			<div class="col-md-12">

';

$galerie = isset($_GET["nid"]) ? $_GET["nid"] : '';

if(!$galerie) die("Fehler");

$que  	= "SELECT * FROM `morp_cms_galerie_name` WHERE gnid=".$galerie." AND mid=".$mid;
$res 	= safe_query($que);
$row 	= mysqli_fetch_object($res);

$img 	= $row->gname;
$ordner 	= $row->gnname;
$path 	=  DIR.'/Galerie/'.$morpheus["GaleryPath"].'/'.$ordner.'/';


/*
UploadiFive
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
*/



$timestamp = time();

$output .= '

<style>
.uploadifive-button {
	float: left;
	margin-right: 10px;
    height: 32px !important;
    line-height: 34px !important;
    width: auto !important;
    padding-right: 30px;
    padding-left: 30px;
    border-radius: 6px !important;
    font-size: .9em !important;
   }
#queue {
	border: 1px solid #E5E5E5;
	height: 377px;
	overflow: auto;
	margin-bottom: 10px;
	padding: 0 3px 3px;
	width: 500px;
}

@media only screen and (max-width: 992px) { #queue { height: 177px; overflow: auto; margin-bottom: 2em; padding: 0 3px 3px; width: 90%; margin-top: 2em; } }

p { font-size:14px; }
</style>

	<p><a href="'.$dir.$navID[8].'edit+'.$galerie.'/" class="btn btn-info"><i class="fa fa-chevron-left"></i> Zurück zur Galerie</a><br/>&nbsp;<br/></p>

	<form>
		<div id="queue"></div>
		<input id="file_upload" name="file_upload" type="file" multiple="true" class="btn btn-info ">
		<!--<a href="javascript:$(\'#file_upload\').uploadifive(\'upload\')" class="btn btn-info ">Upload Bilder</a>-->

	</form>
';


$js = '
		$(function() {
			$(\'#file_upload\').uploadifive({
				\'auto\'             : true,
				\'buttonText\' 		 : \'Bild(er) auswählen\',
				\'formData\'         : {
									   \'timestamp\' : \''.$timestamp.'\',
									   \'token\'     : \''.md5('pixeld'.$timestamp).'\',
									   \'gnid\'	   	: \''.$galerie.'\',
									   \'dir\'	   	: \''.$path.'\'
				                     },
				\'queueID\'          : \'queue\',
				\'uploadScript\'     : \''.$dir.'uploadifive/uploadifive_galerie.php\',
				\'onUploadComplete\' : function(file, data) { console.log(data); }
			});
		});

';

$galerie = 1;
?>