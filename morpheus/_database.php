<?php
session_start();
?><pre><?php
global $mylink, $auditor;
include("../nogo/config.php");
include("../nogo/config_morpheus.inc");
include("../nogo/db.php");
dbconnect();
include("login.php");
include("../nogo/funktion.inc");


$tables_old_new = array(	
	"content"=>	"morp_cms_content",
	"content_history"=>	"morp_cms_content_history",
	"delete"=>	"OFF",
	"form"=>	"morp_cms_form",
	"form_auswertung"=>	"morp_cms_form_auswertung",
	"form_field"=>	"morp_cms_form_field",
	"galerie"=>	"morp_cms_galerie",
	"galerie_group"=>	"morp_cms_galerie_group",
	"galerie_name"=>	"morp_cms_galerie_name",
	"image"=>	"morp_cms_image",
	"img_group"=>	"morp_cms_img_group",
	"nav"=>	"morp_cms_nav",
	"news"=>	"morp_cms_news",
	"news_group"=>	"morp_cms_news_group",
	"pdf"=>	"morp_cms_pdf",
	"pdf_group"=>	"morp_cms_pdf_group",
	"pfad"=>	"morp_cms_pfad",
	"z_protokoll"=>	"morp_cms_protokoll",
	"user"=>	"morp_cms_user",
	"morp_download"=>	"morp_download",
);



$res = "SHOW TABLES FROM ".$morpheus["dbname"];
$res = safe_query($res);

while ($row = mysqli_fetch_row($res)) {
	#print_r($row);
	// if(in_array($row[0], $ausschluss)) {}
	// else 
	//if(key_exists($row[0], $tables_old_new)) {
		echo $tables_old_new[$row[0]].'<br>';
		$tables[] = $row[0];
	//}
}

// print_r($tables);

foreach ($tables as $table) {
	echo $table."<br>";
	
	$sql = "SHOW CREATE TABLE `$table`";
	$res = safe_query($sql);

	if ($res) {
		$create = mysqli_fetch_array($res);
		print_r($create);
	}
}
