<?php
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# www.pixel-dusche.de / björn t. knetter / post@pixel-dusche.de / frankfurt am main, germany
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
global $morpheus, $sign_gruppe, $lan;
$morpheus = array();

$morpheus["dbname"] 		= "d039d371";
$morpheus["dfile"]			= "morpheus_db.sql";
$morpheus["user"]			= "d039d371";
$morpheus["password"]		= "AzzXfHZpATC2zeUM";
$morpheus["server"]			= "localhost";
$morpheus["url"]			= "https://bua.morpheus-cms.de/globalhealth/";
$morpheus["search_ID"]		= array("de"=>14, "en"=>"200" );

# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

$morpheus["multilang"]		= 1;
$morpheus["dfile"]			= "morpheus_db.sql";
$morpheus["home_ID"]		= array("de"=>1, "en"=>70 );
$morpheus["lan_arr"]		= array(1=>"de",  2=>"en" );
$morpheus["lan_nm_arr"]		= array("de"=>"Deutsch", "en"=>"English", );

$morpheus["img_size_news"]		= 450;
$morpheus["img_size_news_tn"]	= 120;
$morpheus["img_size_tn"]	= 35;
$morpheus["img_size_full"]	= 600;
$morpheus["img_size"]		= 600;
$morpheus["page-topic"]		= "";
$morpheus["publisher"]		= "";
$morpheus["foto"]			= 0;
$morpheus["imageName"]		= "morpheus_";
$morpheus["GaleryPath"]		= "BUA";

$morpheus["Host"] = "w0118b8d.kasserver.com"; 
$morpheus["Port"] = 465; 
$morpheus["Username"] = "b@7sc.eu"; 
$morpheus["Password"] = "FischWaage104";
$morpheus["FromName"] = "BUA global health";
$morpheus["From"] = "b@7sc.eu";
	
$morpheus["imageFolder"] 	= 'image/';

$morpheus["mail_start"]		= '<style Type="text/css">
body { background-color: #ffffff; } p, h1, h2, h3, td, a	{ font-family: 	Arial, Verdana; font-size:	12px; line-height: 	16px; color: #666666; margin: 0 0 1px 0; padding: 0; }
td { padding:6px;	margin:0;} h1, h2  { font-weight: 	bold; margin: 0 0 10px 0; } h1  { font-size: 16px; font-weight: normal; line-height: 20px; margin: 0 0 12px 0; } table { width: 100%; }
</style>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center">
	<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width: 600px">
		<tr><td align="center" style="background: #fff;" colspan="2">
			<img src="'.$morpheus["url"].'images/logo.svg" width="400" style="width:400px;height:auto;margin:10px auto 10px;" /></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>
';

$morpheus["mail_end"]		= '</td></tr></table></td></tr></table></center>';

// NEW array for SEARCH PAGE
// Array Lang-ID => navID *********************************************

