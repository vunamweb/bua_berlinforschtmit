<?php
session_start();
# # # # # # # # # # # # # # # # # # # # # # # # # # #
# www.pixel-dusche.de                               #
# björn t. knetter                                  #
# start 12/2003                                     #
#                                                   #
# post@pixel-dusche.de                              #
# frankfurt am main, germany                        #
# # # # # # # # # # # # # # # # # # # # # # # # # # #

global $upload, $morpheus, $dir, $mid;
$upload = 1;

include("../nogo/config.php");
include("../nogo/funktion.inc");
include("../nogo/db.php");
dbconnect();

$root = $morpheus["url"];
$mid = $_SESSION["mid"];
?>

<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>uploadifive/uploadifive.css">
<!-- <script src="../../uploadifive/jquery.min.js" type="text/javascript"></script> -->
<script src="<?php echo $root; ?>uploadifive/jquery.uploadifive.min.js" type="text/javascript"></script>

<?php

$table 	= isset($_REQUEST["tbl"])		? $_REQUEST["tbl"] 		: '';
$id		= isset($_REQUEST["id"])		? $_REQUEST["id"] 		: '';
$imgrow	= isset($_REQUEST["imgid"])		? $_REQUEST["imgid"] 	: '';
$folder	= isset($_REQUEST["folder"])	? $_REQUEST["folder"]	: '';
$tid	= isset($_REQUEST["setid"])		? $_REQUEST["setid"]	: '';
$imgSize= isset($_REQUEST["imgSize"])	? $_REQUEST["imgSize"]	: '';

$path =  str_replace('/page', "", dirname(__FILE__)).'/images/'.$folder.'/';

/*
UploadiFive
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
*/

$timestamp = time();

echo '
<style>
#queue {
	border: 1px solid #E5E5E5;
	height: 60px;
	overflow: auto;
	margin-bottom: 10px;
	padding: 0 3px 3px;
	width: 100%;
}
</style>

	<p><a href=""><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> Fertig und Reload Seite</a></p>
	<form>
		<div id="queue"></div>
		<input id="file_upload" name="file_upload" type="file" multiple="true" class="btn btn-info ">
	</form>

<script>
	$(function() {
		$(\'#file_upload\').uploadifive({
			\'auto\'             : true,
			\'formData\'         : {
								   \'timestamp\' : \''.$timestamp.'\',
								   \'token\'     : \''.md5('pixeld'.$timestamp).'\',
								   \'table\'	   	: \''.$table.'\',
								   \'tid\'	   	: \''.$tid.'\',
								   \'id\'	   	: \''.$id.'\',
								   \'imgrow\'   	: \''.$imgrow.'\',
								   \'imgSize\'  	: \''.$imgSize.'\',
								   \'mid\'  		: \''.$mid.'\',
								   \'dir\'	   	: \''.$path.'\'
			                     },
			\'queueID\'          : \'queue\',
			\'buttonText\' 		 : \'Datei auswählen\',
			\'uploadScript\'     : \''.$morpheus["url"].'uploadifive/uploadifive_img.php\',
			\'onUploadComplete\' : function(file, data) { console.log(data); location.reload();  }
		});
	});
</script>
';
//			\'onUploadComplete\' : function(file, data) { console.log(data); location.reload();  }

