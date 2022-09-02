<?php
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# www.pixel-dusche.de / björn t. knetter / post@pixel-dusche.de / frankfurt am main, germany
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
global $morpheus, $sign_gruppe, $lan;
$morpheus = array();

$morpheus["dbname"] 		= "d039f7ed";
$morpheus["user"]			= "d039f7ed";
$morpheus["password"]		= "JcsMBVhCqm8Vurru";

$morpheus["dbname2"] 		= "d039d371";
$morpheus["user2"]			= "d039d371";
$morpheus["password2"]		= "AzzXfHZpATC2zeUM";

$morpheus["dfile"]			= "morpheus_db.sql";
$morpheus["server"]			= "85.13.164.136";
$morpheus["url"]			= "http://localhost:8888/berlinforscht/bua_berlinforschtmit/";
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
$morpheus["imageName"]		= "BUA_";
$morpheus["GaleryPath"]		= "BUA";

// info@knowledge-exchange.berlin-university-alliance.de (m062df48)
// s4NSoH4Qftat7fug
// w01ac4ac.kasserver.com

$morpheus["Host"] = "mail.zedat.fu-berlin.de"; 
$morpheus["Port"] = 465; 
$morpheus["Username"] = "knowledgebua"; 
$morpheus["Password"] = "cmhpkCJo23wCNnkf";
$morpheus["FromName"] = utf8_decode("Themenwerkstätten Urban Health");
$morpheus["From"] = "globalhealth-forum@berlin-university-alliance.de";
	
$morpheus["imageFolder"] 	= 'image/';
$morpheus["subFolder"] 	= '/berlinforschtmit/';

$morpheus["mail_start"]		= '<style Type="text/css">
body { background-color: #ffffff; } p, h1, h2, h3, td, a { font-family:	Arial, Verdana; font-size:	12px; line-height: 	16px; color: #666666; margin: 0 0 1px 0; padding: 0; } p.small { font-size:	10px; line-height: 	14px; color: #888888; } td { padding:6px;	margin:0;} h1, h2  { font-weight: 	bold; margin: 0 0 10px 0; } h1  { font-size: 16px; font-weight: normal; line-height: 20px; margin: 0 0 12px 0; } table { width: 100%; }
</style>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center">
	<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width: 600px">
		<tr><td align="center" style="background: #fff;" colspan="2">
			<img src="'.$morpheus["url"].'images/logo.svg" width="300" style="width:300px;height:auto;margin:10px auto 10px;" /></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>
';

$morpheus["mail_end"]		= '</td></tr>
<tr><td> 
<br/><br/>
<hr>
<br/><br/>
<p class="small">BERLIN FORSCHT MIT<br/>
Berlin University Alliance<br/>
#berlinforschtmit<br/>
<a href="https://www.berlin-university-alliance.de">www.berlin-university-alliance.de</a></p>
</td></tr>
</table></td></tr></table></center>';

// NEW array for SEARCH PAGE
// Array Lang-ID => navID *********************************************

