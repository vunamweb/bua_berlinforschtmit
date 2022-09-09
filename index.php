<?php
header('Access-Control-Allow-Origin: *');
session_start();
define('CMS',0);

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

global $morpheus_edit;
$PIN = md5(date("Ymd").'!XcDf5?');
$PIN = 'xxx';
if(isset($_GET["morpheus_edit"])) {
	$morpheus_edit = $_GET["morpheus_edit"]==$PIN ? 1 : 0;
	$_SESSION["morpheus_live_edit"]=$PIN;
}
else if(isset($_GET["edit_close"])) {
	unset($_SESSION["morpheus_live_edit"]);
}
else if(isset($_SESSION["morpheus_live_edit"])) {
	$morpheus_edit = $_SESSION["morpheus_live_edit"]==$PIN ? 1 : 0;
}
$redirect = 0;
if(isset($_GET["hn"])&&isset($_GET["cont"])) {
	include_once("nogo/funktion.inc");
	if( $_GET["hn"]=="cookie" && $_GET["cont"]=="cookie" ) { delAllCookie(); $redirect = 1; }
}
$track = isset($_COOKIE["marketing"]) ? 1 : 0;
error_reporting(0);
# session_destroy();
// phpinfo();

# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
global $dir, $navarray, $nav_h, $nav_s, $navarrayFULL, $SID, $lightbox, $lang, $lan, $hn, $sn2, $nid, $ns, $waehrung, $thwg, $product_show, $wg_txt, $navID, $img_pfad, $uri, $print, $imageFolder, $profile;
global $news_headl, $news_back, $tcolor, $mindflashID, $kompetenz, $komp_col, $lokal_pfad, $sub1_id, $qSET, $IAMIN, $urlencode, $multilang, $relative_path, $relative_url, $profile, $ipad;
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
//     1   GRUNDEINSTELLUNGEN
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .

include("nogo/config.php");
include("nogo/config_morpheus.inc");
include_once("nogo/funktion.inc");

// COOKIES LOESCHEN
// delCookie('komfort');
// delAllCookie();

// print_r($_COOKIE);

$multilang = $morpheus["multilang"];
$profile = 0;

# # # pfad ermitteln
# $out = print_r($_REQUEST, 1);
// print_r($_REQUEST);
# print_r($_POST);
# print_r($_SESSION);
$url  	 = $_SERVER["HTTP_HOST"];
// $lasturl = isset($_SESSION["tld"]) ? $_SESSION["tld"] : '';
$ref_chk = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';
$uri	 = $_SERVER["REQUEST_URI"];
// $SID	 = session_id();
$page404 = 0;
define('DIR', dirname(__FILE__));
define('URL', substr($_SERVER['PHP_SELF'], 0, - (strlen($_SERVER['SCRIPT_FILENAME']) - strlen(DIR))));

$urlencode = urlencode($url.$uri);

// echo '::'.$mobile = mobile_device_detect();

$useragent=$_SERVER['HTTP_USER_AGENT'];
$mobile = 0;
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
	$mobile = 1;
	// header('Location: http://detectmobilebrowser.com/mobile');

}
$ipad = (preg_match('/iPad/',$useragent));
// echo $mobile;
// if($mobile) $qSET = '&amp;q=30';
// else $qSET = '&amp;q=90';
// $IAMIN = 1;
//$suche = isset($_POST["suche"]) ? $_POST("suche") : '';

//////////////////////////////////////////////////////////////////////////////////
$browser = browser_detection("browser");

if ($browser == "ie") {
	$msie = 1;
	$browser = substr(browser_detection("number"), 0, 1);
	if ($browser < 6) $browser = "MSIE5";
	elseif ($browser < 7) $browser = "MSIE6";
}
/////////////////////////////////////////////////////////////////////////////////

if(file_exists("lokal.dat")) $dir = $morpheus["local"];
else $dir = $morpheus["url"];

$img_pfad = $dir."images/userfiles/image/";
$imageFolder = $morpheus["imageFolder"];
// $imageFolder = "images/userfiles/image/";

$lokal_pfad = '';
/*
$count_tiefe = explode('/', $uri);
$count_tiefe = count($count_tiefe)-$morpheus["ebene"];  // -2 weil anfang und endslash im array sind
if($count_tiefe) {
	for ($i=1; $i<=$count_tiefe; $i++) {
		$lokal_pfad .= "../";
	}
}
*/
$lokal_pfad = $dir;

// spracheinstellungen // sprachauswertung
$lan = isset($_GET["lang"]) ? $_GET["lang"] : 'de';


// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + 
// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + 
// LOGOUT * * * * * * * * * * * * * * * * * * * * * * * * * * * *
$logout = isset($_GET["logout"]) ? 1 : 0;
$crontab = isset($_GET["crontab"]) ? $_GET["crontab"] : '';

if ($logout) {
	$_SESSION["uname"] = '';
	$_SESSION["pd"] = '';
	$_SESSION["mIL"] = '';
	$_SESSION["vname"] = '';
	$_SESSION["nname"] = '';
	$_SESSION["mid"] = '';
	redirect($dir);
	exit();
}
// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + 
// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + 



$weiterleitung = array(
	"beschwerdemanagement"=>13,
	"ds-gvo"=>12,
);

if(isset($_GET["alt"])) {
	if(isset($_GET["s1"])) {
		include("nogo/navID_de.inc");
		$id_arr = array_flip($navID);
		$new = strtolower($_GET["s1"])."/";

		if(isset($_GET["s2"])) {
			$new .= strtolower($_GET["s2"])."/";
		}
		else $new .= "allgemeines/";

		if ($id_arr[$new]) $go = $dir.$new;
		else $go = $dir;

		// print_r($_REQUEST);
	}
	else $go = $dir;

	$nosend = 1;
	redirect ($go);
}
elseif(array_key_exists($lan, $weiterleitung)) {
	include("nogo/navarray_de.php");
	include("nogo/navID_de.inc");
	$weiterleitung = $weiterleitung[$lan];
	$go = $dir.($multilang ? $morpheus["lan_arr"][1].'/' : '').$navID[$weiterleitung];
	redirect ($go);
	exit();
}
else if ($lan != "de" && $lan != "en" && $lan != "sl" && $lan != "fr" && $lan != "it" && $lan != "es" && $lan != "ru") {
	$nosend = 1;
	redirect ($dir);
}
else if($redirect) {
	$nosend = 1;
	if($lan == "de") redirect ($dir);
	else redirect ($dir.'en/');
}

$lan_ID_arr = array_flip($morpheus["lan_arr"]);
$lang 		= $lan_ID_arr[$lan];

include("nogo/".$lan.".inc");
// ____ sprache

// navigation ID's laden
include("nogo/navarray_".$lan.".php");
include("nogo/navID_".$lan.".inc");

# $ausnahme = array("lang", "hn", "sn2", "sn3", "sn4", "cont");
$ausnahme = array("x","y");

if (($_GET || $_POST)) {
	foreach ($_POST as $key=>$val) {
		if ($val) {
			$check 	= $val;
			if(is_array($val)) {  }
			else {
				$chk 	= no_injection($val);
				// echo "($check != $chk)<br>";
				if ($check != $chk) {
					$nosend = 1;
					//redirect ($dir);
				}				
			}
		}
	}
	foreach ($_GET as $key=>$val) {
		if ($val && !in_array($key, $ausnahme)) {
			if ($key == "pnm") 	$val = eliminiere($val);
			$check 	= $val;
			if ($key == "pnm") 	$chk = no_injection($val, 1);
			else 				$chk = no_injection($val);
			if ($check != $chk) {
				$nosend = 1;
				//redirect ($dir);
			}
		}
	}
}
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

// START database
//$checkLogSession = get_token();
/*$userIsLogIn = isset($_SESSION["mIL"]) ? $_SESSION["mIL"] : '';
if(get_token() == $userIsLogIn) {
	include("nogo/db2.php");
	dbconnect();
	//echo 'db'; die();
} else {
	include("nogo/db2.php");
	dbconnect();
	//echo 'db2'; die();
}*/
//dbconnect();
include("nogo/db.php");
dbconnect();

// SETTINGS KUNDEN LADEN
$sql = "SELECT * FROM morp_settings WHERE 1";
$res = safe_query($sql);
while($row = mysqli_fetch_object($res)) {
	$morpheus[$row->var] = $row->value;
}

/////////////////////////////////////////////////////////////////////////////////////////
// aus welchen land kommt der kunde?
/*
$country = $_SESSION["country"];
if(file_exists("lokal.dat")) {}
elseif (!$country) {
	session_register('country');
	$ip_number = sprintf("%u", ip2long($_SERVER["REMOTE_ADDR"]));
	$sq 		= "SELECT country_code2 FROM iptoc WHERE IP_FROM <=$ip_number AND IP_TO >=$ip_number";
	$rs 		= safe_query($sq);
	$rw 		= mysqli_fetch_object($rs);
	$country 	= $rw->country_code2;
	$_SESSION["country"] = $country;
	if(file_exists("lokal.dat")) {
		$country = "EN";
		$_SESSION["country"] = "EN";
	}
	if ($country == "CH" || $country == "DE" || $country == "AT") 	{}
	elseif ($uri == '/') {
				$nosend = 1;
				redirect ($dir.'en/');
			}
}
*/
////////////////// TRACKING  // TRACKING  // TRACKING  // TRACKING

$uid = isset($_GET["uid"]) ? $_GET["uid"] : '';

if ($uid) {
	$sql = "SELECT * FROM morp_newsletter_track WHERE vid='$uid' AND site='".$_GET["newsname"]."'";
	$res = safe_query($sql);
	if (mysqli_num_rows($res) < 1) {
		$sql = "INSERT morp_newsletter_track set vid='$uid', site='".$_GET["newsname"]."'";
		$res = safe_query($sql);
	}
}
//////////////////////////////////////////////////

# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
// standard seite festlegen

$hn 		= isset($_REQUEST["hn"]) ? $_REQUEST["hn"] : '';
$cont 		= isset($_REQUEST["sn2"]) ? $_REQUEST["sn2"] : '';
$cont3 		= isset($_REQUEST["sn3"]) ? $_REQUEST["sn3"] : '';
$cont4 		= isset($_REQUEST["sn4"]) ? $_REQUEST["sn4"] : '';
$cont5 		= isset($_REQUEST["sn5"]) ? $_REQUEST["sn5"] : '';
$print 		= isset($_REQUEST["print"]) ? $_REQUEST["print"] : '';
$nid 		= isset($_REQUEST["nid"]) ? $_REQUEST["nid"] : '';
$id_arr 	= array_flip($navID);

$set_uri= '';

if ($hn) 	$set_uri = eliminiere($hn)."/";
if ($cont) 	$set_uri .= eliminiere($cont)."/";
$sn2_id 	= $set_uri ? $id_arr[$set_uri] : '';
if ($cont3) $set_uri .= eliminiere($cont3)."/";
$sn3_id 	= $set_uri ? $id_arr[$set_uri] : '';
if ($cont4) $set_uri .= eliminiere($cont4)."/";
if ($cont5) $set_uri .= eliminiere($cont5)."/";

// ID dieser Seite auswerten
$cid = $set_uri ? $id_arr[$set_uri] : 0;
$cidValue = $_REQUEST['cidValue'];
// hauptnaviagtion ID auswerten
$hn_id 	= $hn ? $id_arr[eliminiere($hn)."/"] : 0;

if ($cont) $sub1_id = $id_arr[eliminiere($hn)."/".eliminiere($cont)."/"];
else $sub1_id = "";

$old = isset($_GET["old"]) ? $_GET["old"] : '';

/////////////////////////////////////////////////////////////////////////////////////////
// CRONTAB
if($crontab) {
	sendMailNewletters();
	die();
 }
// SEARCH
elseif(isset($_GET["s"])) {
	$cid=$morpheus["search_ID"][$lan];
	$hn_id=$morpheus["search_ID"][$lan];
}
elseif($old) {
	// echo $old;
	$sql  	= "SELECT navid, lang FROM `morp_cms_nav` WHERE oldlnk LIKE '%$old%'";
	$res 	= safe_query($sql);

	if(mysqli_num_rows($res) > 0) {
		$row 	= mysqli_fetch_object($res);
		$go = $dir.($multilang ? $morpheus["lan_arr"][$row->lang].'/' : '').$navID[$row->navid];
		redirect ($go);
		exit();
	}
	else {
		redirect ($dir);
		exit();
	}

}
// else if($cont) {
// 	// special schroeder boese, weil keine subnav - subnav ist hier onepager scroll
// 	$go = $dir.($multilang ? $morpheus["lan_arr"][$row->lang].'/' : '').$navID[$hn_id];
// 	redirect ($go);
// 	exit();
// }
/////////////////////////////////////////////////////////////////////////////////////////
// Alte Url auswerten ODER Shortlink
elseif ((!$hn_id || !$cid) && $hn)	{
	// print_r($_REQUEST);
	$find = substr($uri, 1, strlen($uri));
	// echo $lan.$hn;

	if($lan == "sl") {
		$sql  	= "SELECT navid, lang, setlink FROM `morp_cms_nav` WHERE shortlink = '$hn'";
		$res 	= safe_query($sql);

		if(mysqli_num_rows($res) > 0) {
			$row 	= mysqli_fetch_object($res);
			// print_r($row);
			include("nogo/navID_".$morpheus["lan_arr"][$row->lang].".inc");
			$go = $dir.($multilang ? $morpheus["lan_arr"][$row->lang].'/' : '').$navID[$row->navid];
			redirect ($go);
			exit();
		}
		else {
			redirect ($dir);
			exit();
		}
	}
	else {
		$sql  	= "SELECT navid FROM `morp_cms_nav` WHERE oldlnk LIKE '%$find%'";
		$res 	= safe_query($sql);

		if(mysqli_num_rows($res) > 0) {
			$row 	= mysqli_fetch_object($res);
			$go = $dir.($multilang ? $morpheus["lan_arr"][$row->lang].'/' : '').$navID[$row->navid];
			redirect ($go);
			exit();
		}
		else {
			redirect ($dir);
			exit();
		}
	}
}
elseif (!$hn_id || !$cid)	{
	$hn_id 	= $morpheus["home_ID"][$lan];
	$cid 	= $morpheus["home_ID"][$lan];
}
/////////////////////////////////////////////////////////////////////////////////////////
# vorschau aus CMS MORPHEUS
$vorschau = 0;
if (isset($_GET["vs"]) && isset($_GET["cid"])) {
	if ($_GET["vs"] == 1 && $_GET["cid"]) {
		$vorschau = 1;
		$cid 	= $_GET["navid"];
		$sn2	= $cid;
		$sql  	= "SELECT ebene, navid, parent FROM `morp_cms_nav` WHERE navid=$cid";
		$res 	= safe_query($sql);
		$row 	= mysqli_fetch_object($res);

		if ($row->ebene > 2) 	{
			$sn3	= $cid;
			$sn2	= $row->parent;
			$sql  	= "SELECT ebene, navid, parent FROM `morp_cms_nav` WHERE navid=".$row->parent."";
			$res 	= safe_query($sql);
			$row 	= mysqli_fetch_object($res);
			$hn_id 	= $row->parent;
		}
		elseif ($row->ebene == 1) 	$hn_id = $cid;
		else						$hn_id = $row->parent;
	}
}


// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
//     2   HAUPTNAVIGATION
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .



# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
// hauptnavigation
$sql  	= "SELECT name, n.navid, bereich, button, imgname, lnk, design, sichtbar, emotional, fbimage, setlink, `lock` FROM `morp_cms_nav` n LEFT JOIN morp_cms_image i ON i.imgid=n.emotional WHERE n.ebene=1 AND lang=$lang ORDER BY `sort` ASC";

$res 	= safe_query($sql);
$anz	= mysqli_num_rows($res);
$class	= "";
$nav_arr= array("leer");	# wert 0 ist null. wert 1 muss der aktive hauptnavigationsname sein
$n 		= 0;
$m 		= 0;
$nav_footer = '';
$nav_h = '';
$nav_meta = '';
$nav_meta_mobile = '';
$nav_logged_in = '';
$fbimage = '';
$nav_log = '';
// print_r($navID);
while ($row = mysqli_fetch_object($res)) {
	$n_nm		= "name";
	$name		= $row->$n_nm;
	//print_r($row);
	if ($name) {
		$id			= $row->navid;
		$bereich	= $row->bereich;
		$des		= $row->design;
		$nnm 		= eliminiere($name);
		$lnk		= $row->lnk;
		$extern 	= 0;
		$li_class	= "";
		$class		= "";
		$split 		= "";
		$button 	= $row->button;
		$sichtbar	= $row->sichtbar;
		$setlink	= $row->setlink;
		$lock		= $row->lock;


		if ($id == $morpheus["home_ID"][$lan] && $lang == 1)  		$index = "";
		elseif ($id == $morpheus["home_ID"][$lan] && $multilang)  	$index = $lan."/";
		elseif ($lnk && preg_match("/^http/", $lnk))	{ 			$index = $lnk; $extern = 1; 	}
		elseif ($lnk) 												$index = ($multilang ? $lan.'/' : '').$navID[$lnk];
		else														$index = ($multilang ? $lan.'/' : '').$setlink.'/';

		if ($hn_id == $id) {
			if ($id >= 1) $class = ' active';
			if ($id >= 1) $li_class= ' class="active"';

			$split 			= "<!-- split".$id." -->";
			$design			= $des;

			$nav_arr[]		= strtolower($nnm);
			$breadcrumb 	= '<li><a href="'.$dir.$index.'"><i class="fa fa-angle-right"></i> '.$name.'</a></li>';
			$hn_name		= strtolower($nnm);
			if($lan=="en") $langpar = $row->langpar;
			else {
				$langpar = get_db_field($id, 'navid', 'morp_cms_nav', 'langpar');
			}
			if ($row->button) 	$but = $row->button;
			if ($row->imgname) 	$background = $img_pfad.$row->imgname;
		}

		if ($sichtbar) {
			if ($bereich == 1 && $lock<1) 	{
				$m++;
				$nav_h .= '						<li class="nav-item"><a href="'. ($extern ? $index : $dir.$index) .'" title="'.$name.'"'. ($extern ? ' target="_blank"' : '') .' class="nav-link'.$class.'">'.$name.'</a>'.$split.'</li>
';
			}
			
			else if ($bereich == 1) 	{
				$m++;
				$nav_logged_in .= '						<li class="nav-item"><a href="'. ($extern ? $index : $dir.$index) .'" title="'.$name.'"'. ($extern ? ' target="_blank"' : '') .' class="nav-link'.$class.'">'.$name.'</a>'.$split.'</li>
			';
						}


			elseif ($bereich == 2 && $lock<1) 	{
				$n++;

				$nav_meta .= '						<li><a href="'. ($extern ? $index : $dir.$index) .'" title="'.$name.'"'. ($extern ? ' target="_blank"' : '') .'>'.$name.'</a></li>'.$split.'
';
				$nav_meta_dd .= '						<a href="'. ($extern ? $index : $dir.$index) .'" title="'.$name.'"'. ($extern ? ' target="_blank"' : '') .' class="dropdown-item">'.$name.'</a>
';
				$nav_meta_mobile .= '					<li class="mobileOn"><a href="'. ($extern ? $index : $dir.$index) .'" title="'.$name.'"'. ($extern ? ' target="_blank"' : '') .' class="nav-link meta-nav'.$class.'">'.$name.'</a></li>
';
			}
			elseif ($bereich == 3 && $lock<1) 	{
				$nav_footer .= '		    <div class="col-2">
				<a href="'.$dir.$index.'" class="nav-link'.($id == $cid ? ' active' : '').'">'.$name.'</a>
		    </div>
';
				$nav_footer_mobile .= '		<li class="nav-item mobileOn"><a href="'.$dir.$index.'" class="nav-link trenn '.($id == $cid ? ' active' : '').'">'.$name.'</a></li>
';
			}

			if ($bereich == 3) 	$nav_log .= '		<li><a href="'.$dir.$index.'" '.$class.' title="'.$name.'">'.$name.'</a></li>'."\n\t";
		}
	}
}

// _____ hauptnavi




// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// KUNDEN REGISTRIERUNG PRÜFEN UND WEITERLEITEN
$optin = isset($_GET["optin"]) ? $_GET["optin"] : 0;

if($optin) {
	$sql = "SELECT mid FROM morp_intranet_user WHERE SID='$optin'";
	$res = safe_query($sql);
	if(mysqli_num_rows($res)>0) {
		$sql = "UPDATE morp_intranet_user SET optin=1 WHERE SID='$optin'";
		$res = safe_query($sql);
		
		$output = '
			<h2>'.textvorlage(40).'</h2>
		';
		$lan = $lan == "de" ? "en" : "de";
		$output .= '
			<h2>'.textvorlage(40).'</h2>
		';
	}
	else $output = '
		<h2>Wir können Ihre Daten nicht zuordnen</h2>
		<h2>We can not assign your data</h2>
	';

	include("design/header_inc.php");
	include("design/top.php");
	include("design/empty.php");
	die('</body></html>');
}


/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
# LOGGED ???
/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

 
$firstLogin = 0;
$checkLogSession = get_token();
$userIsLogIn = isset($_SESSION["mIL"]) ? $_SESSION["mIL"] : '';

$haslogin = get_db_field($cid, 'lock', 'morp_cms_nav', 'navid');
if($haslogin) {
	// checkLogin($haslogin);
	if ($_SESSION["mid"] == '' || $checkLogSession != $userIsLogIn) redirect($dir . '/de/login');
	else if($checkLogSession == $userIsLogIn) {
		$haslogin = 0;
		$mid = $_SESSION["mid"];
	}
}

// print_r($_GET);
$loginreset = $_GET["loginreset"] ? 1 : 0;
$aktivierung = $_GET["aktivierung"] ? $_GET["aktivierung"] : 0;
$reset = $_GET["reset"] ? 1 : 0;

$cancelEvent = $_REQUEST['cancelEvent'] ? 1 : 0;

if ($aktivierung && $reset) {
	$sql = "SELECT * FROM `morp_intranet_user` WHERE secure='".($aktivierung)."'";
	$res = safe_query($sql);
	$x = mysqli_num_rows($res);

	if ($x > 0) {
		$row = mysqli_fetch_object($res);
		$_SESSION["uname"] = $row->uname;
		$_SESSION["pd"] = $row->pw;
		$_SESSION["mid"] = $row->mid;
		$_SESSION["secure"] = $aktivierung;
		
//print_r($_SESSION);

	   # $sql = "UPDATE `morp_intranet_user` set secure='' WHERE mid='".$row->mid."'";
	   # $res = safe_query($sql);

		$hn="profil";
		$cont="profil";
		$newpass=1;
		redirect($dir.'?hn=profil&cont=profil&newpass=1');
		exit();
	} else {
		include("design/header_inc.php");
		include("design/login.php");
		die('</body></html>');
	}
} elseif ($loginreset) {
	$output = '';
	include("page/login-reset.php");
	include("design/header_inc.php");
	include("design/top.php");
	include("design/empty.php");

	die('</body></html>');
} elseif ($cancelEvent) {
	$output = '';
	require_once("page/cancel-event.php");
	include("design/header_inc.php");
	include("design/top.php");
	include("design/empty.php");

	die('</body></html>');
} 
// elseif ($haslogin) {
// 	$cid = in_array($cid, $id_allowed_not_login) ? $cid : $morpheus["home_ID"][$lan];
// 
// 	include("design/header_inc.php");
// 	include("design/top.php");
// 	include("design/login.php");
// 	include("design/footer_inc.php");
// 	include("design/footer-tracking.php");
// 
// 	die('</body></html>');
// }


/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////










# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
// subnavigation
# es werden alle ebenen der subnav ausgelesen

$parent_arr = array(1=>$hn_id);
$set_lnk 	= eliminiere($hn)."/";

$sn2 = ''; $sn3 = ''; $sn4 = ''; $sn5 = '';

foreach ($_GET as $key=>$val) {
	if (preg_match("/^sn/", $key)) {
		$set_lnk .= eliminiere($val)."/";
		$parent_arr[substr($key,2)] = $id_arr[$set_lnk];
		$$key = $id_arr[$set_lnk];
	}
}

if ($vorschau && $cid != $hn_id) {
	$parent_arr[] = $sn2; $parent_arr[] = $sn3; $parent_arr[] = $sn4; $parent_arr[] = $sn5;
}

// print_r($parent_arr);
# $out .= print_r($parent_arr, 1);

$split_arr = array();
$ct = 0;
$sub_arr = array();


$intern = '';

if ($intern && $logged != "brand-pixel") { 	# wenn zugangsgeschuetzte seiten im system sind

}

else	{
	$sub0 = ''; $sub1 = ''; $sub2 = ''; $sub3 = ''; $sub4 = ''; $sub5 = '';

	foreach ($parent_arr as $key=>$val) {		# alle subnavigationsebenen werden durchlaufen, sofern diese geklickt wurden
		if ($val) {
			$ebene 		= ($key + 1);
			$sn_aktiv 	= "sn".$ebene;			# die aktive/geklickte subnavigations ID wird global als sn plus ebene definert


			$sql = "SELECT * FROM `morp_cms_nav`
				WHERE
					ebene=".$ebene." AND
					parent=".$val." AND
					sichtbar = 1
				ORDER BY `sort`";

			$res = safe_query($sql);

			$set_link = '';						# hier wird der pfad fuer die subnavigation zusammen gestellt
			for($n = 1; $n < $ebene; $n++) $set_link .= $nav_arr[$n].'/';

			while ($row = mysqli_fetch_object($res)) {
				$id		= $row->navid;
				$name	= $row->name;
				$des	= $row->design;
				$visib	= $row->sichtbar;
				$lnk	= $row->lnk;
				$lock	= 0; // $row->lock;

				//echo $val;
				if($lock && !$IAMIN) {}
				elseif ($name) {
					$nnm 	= strtolower(eliminiere($name));	# sonderzeichen, leerzeichen, u.v.w. werden entfernt

					$sub	= "sub".$ebene;

					// manuell gesetzte links
					$extern 	= 0;
					$index		= "";
					$liclass 	= '';

					if ($lnk && preg_match("/^http/", $lnk))	{ $index = $lnk; $extern = 1; }
					elseif ($lnk) 								$index = $navID[$lnk];
					// _manuell

					if ($$sn_aktiv == $id) 	{
						$class 			= ' active';			# aktive navigationselemente werden gekennzeichnet
						$liclass 			= ' active';				# aktive navigationselemente werden gekennzeichnet
						$split 			= '<!-- '.($id).' -->';
						$design			= $des;
						$split_arr[] 	= $ebene;
						$nav_arr[]		= $nnm;
						# $cid			= $id;
						$breadcrumb 	.= '<li><a href="'.$dir.($multilang ? $lan.'/' : '').$navID[$id].'"><i class="fa fa-angle-right"></i> '.$name.'</a></li>';
						if($lan=="en") $langpar = $row->langpar;
						else {
							$langpar = get_db_field($id, 'navid', 'morp_cms_nav', 'langpar');
						}
					}
					elseif($ebene > 2)	{
						$class = '';
						$split 			= '<!-- '.($id).' -->';
					}
					else	{
						$class = '';
						$split = '';
					}

					if ($visib && $index) 				$$sub	.= "<li><a href=\"". ($extern ? $index : $dir.$index) ."\"". ($extern ? ' target="_blank"' : '') ."".$class.">XXXXXX ".$name."</a>".$split."</li>\n";

					elseif ($visib && $ebene == 3) 	{
														$$sub	.= '<li><a href="'.$dir.($multilang ? $lan.'/' : '').$navID[$id].'"'.$class.'>'.$name.'</a></li>';
														$sub_arr[]=$id;
													}

					elseif ($visib) 					$$sub	.= '<li class="nav-item"><a href="'.$dir.($multilang ? $lan.'/' : '').$navID[$id].'" class="nav-link'.$class.'">'.$name.'</a>'.$split.'</li>';

				}
			}
		}
	}


	if ($ebene > 1) {
		for ($i=2; $i <= $ebene; $i++) {
			$tmp = "sub".$i;
			$dat = $$tmp;

			if ($i == 2) $nav_s = $dat;
			elseif ($dat) {
				$nav_s = str_replace('<!-- '.($i).' -->', '<ul>'.$dat."</ul>", $nav_s);
			}
		}
	}
	if ($ebene > 2) {
		for ($i=3; $i <= $ebene; $i++) {
			$tmp = "sub".$i;
			$dat = $$tmp;

			if ($i == 3) $nav_s2 = $dat;
			elseif ($dat) $nav_s2 = str_replace("<!-- ".$i." -->", "<ul>".$dat."</ul>", $nav_s);
		}
	}

}
if ($nav_s) $nav_s = $nav_s;
$nav_sUL = '<ul>'.$nav_s.'</ul>';

// $nav_h = str_replace("<!-- split".$hn_id." -->", $nav_sUL, $nav_h);

// print_r($sub_arr);

/* *************************** NEW *****************************/
/* *************************** NEW *****************************/
/* *************************** NEW *****************************/
// $dropDownMenu = '';

/*********. UNTERNAVIGATION 3. Ebene mit aufnehmen */
/*
print_r($parent_arr);
if(count($sub_arr)>0) {
	foreach($sub_arr as $getid) {
		$dropDownMenu = get_nav($getid, $parent_arr[4], '', 0, $parent_arr, 4);
		if($dropDownMenu) $sub3 = preg_replace('/<!-- '.($getid).' -->/', "\n".'		<ul class="hovermenu">'."\n".$dropDownMenu.'</ul>', $sub3);
	}
}
*/
/******/

// echo $sub3;

/* *************************** SUB 3 in nav // fuer AGIS *****************************/
/* *************************** SUB 3 in nav // fuer AGIS *****************************/
/* *************************** SUB 3 in nav // fuer AGIS *****************************/

if($sub3) $sub3 = '
<nav class="navbar navbar-sub">
	<div class="container-fluid">
		<div class="container container-xl">
			<div class="collapse navbar-collapse" id="navbarSub">
	            <ul class="nav navbar-nav">
'.$sub3.'
	            </ul>
	    	</div>
		</div>
	</div>
</nav>
';

/* *************************** SUB 3 in nav // fuer AGIS *****************************/
/* *************************** SUB 3 in nav // fuer AGIS *****************************/
/* *************************** SUB 3 in nav // fuer AGIS *****************************/



function get_nav($getid, $aktiv, $giveClass, $ul, $parent_arr, $getebene) {
	global $dir, $navID, $lan;
	// print_r($navID);
	if($ul) $ret = '
			<ul'.$giveClass.'>
';
	else $ret = '';


	$sql = "SELECT * FROM `morp_cms_nav`
		WHERE
			parent=".$getid." AND
			sichtbar=1
		ORDER BY `sort`";
	$res = safe_query($sql);

	if(mysqli_num_rows($res) > 0) {
		while ($row = mysqli_fetch_object($res)) {
			$id = $row->navid;

			if ($aktiv == $id) 	$class = ' class="active"';
			else $class = '';

			$split = get_nav($id, $parent_arr[$getebene++], '', 1, $parent_arr);

			$ret .= '				<li'.$class.'><a href="'.$dir.$lan.'/'.$navID[$id].'">'.$row->name.'</a>'.$split.'</li>
';
		}

		if ($ul) $ret .= '			</ul>
';
	}
	else $ret = '';

	return $ret;
}

/* VU: if there are menu all entries, category, then get css form morpheus */
function getCssMorpheus() {
	global $hn;

	if($hn == 'all-entries' || $hn == 'categories' || $hn == 'hashtag' || $hn == 'diary')
	 return true;
   
   return false; 	  
}
/* END */

/* VU: check check login */
function checkLogin($haslogin) {
	global $dir;

	//print_r($_REQUEST);
	
	if ($_SESSION["mid"] == '' && $_REQUEST['hn'] != '' && $_REQUEST['hn'] != 'home' && $_REQUEST['hn'] != 'login' && $_REQUEST['hn'] != 'register')
	 redirect($dir . '/de/login');
}
/* END */ 

/* *************************** NEW ENDE *****************************/
/* *************************** NEW ENDE *****************************/
/* *************************** NEW ENDE *****************************/

// echo $sub2;
//////////////////////////////////////////////////////////////////////////////////////////////
// NAVIGATION __ FERTIG ___  ___  ___  ___  ___  ___  ___  ___  ___  ___  ___  ___  ___  ___
//////////////////////////////////////////////////////////////////////////////////////////////

/* ***************************             *****************************/
/* *************************** WEITER ZUR NÄCHSTEN SEITE :) ************/
/* ***************************             *****************************/


include("nogo/orderedList_de.inc");
$orderedListFind = array_flip($orderedList);

$pos = $orderedListFind[$cid];
$ctOL = count($orderedList);

// print_r($orderedList);

if($pos > 1)	$PREVID = $pos - 1;
else 			$PREVID = $ctOL;

if($pos <= $ctOL) 	$NEXTID = $pos + 1;
else 				$NEXTID = 1;

 $PREV = $orderedList[$PREVID];
 $NEXT = $orderedList[$NEXTID];

// echo $PREV.$NEXT.'<br>P:'.$PREVID.'- N: '.$NEXTID;


if($NEXTID) {
	$targetNm = utf8_encode($navarrayFULL[$NEXT]);
	$ziel = getUrl($NEXT, $lan, 1);
	$nextPage = '<a accesskey="2" href="'.$ziel.'">'.$targetNm.' &nbsp; <i class="fa fa-step-forward"></i></a>';
}
if($PREVID) {
	$targetNm = utf8_encode($navarrayFULL[$PREV]);
	$ziel = getUrl($PREV, $lan, 1);
	$prevPage = '<a accesskey="1" href="'.$ziel.'"><i class="fa fa-step-backward"></i> &nbsp; '.$targetNm.'</a>';
}



// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .

	
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
//     3   CONTENT / TEXT / INHALT
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .


//$meta_arr 	= array("title", "desc", "keyw", "footer");
$meta_arr 	= array("title", "desc", "keyw");
$img_arr 	= array();
$n_nm		= "content";
$detail 	= isset($_GET["detail"]) ? $_GET["detail"] : '';
$leftimage	= '';

$rb_headl = '';

$hashtag_search = $_GET["ht"] ? $_GET["ht"] : '';

global $anker, $tref, $tabstand, $tende, $tclass, $klasse, $klasse2, $tabstand_bottom, $position, $uniqueID, $tschmal, $animation, $animation_time;

global $replace_string;
$replace_string = 'anker:';
$pattern = '/(anker:+)\d/';

// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + 
// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + 
// if not logged set ID to home if cid is not allowed -  IMpressum / Datenschutz are allowed
// global $eventid, $loginid, $registerid, $eventlist_id, $event_url_id,$event_register_id;
// $id_allowed_not_login = array(
// 	14,15,16,5,6,18,4	
// );
// $login_ID = $lan == "de" ? 16 : 100;
// $loginid = $lan == "de" ? 15 : 100;
// $registerid = $lan == "de" ? 14 : 100;
// $eventlist_id = $lan == "de" ? 8 : 100;
$profile_id = $lan == "de" ? 7 : 100;
$kontakt_id = $lan == "de" ? 18 : 100;
// $event_url_id = $lang == 1 ? 2 : 130;
// $event_register_id = $lang == 1 ? 21 : 150;
// 	
// if ($haslogin) $cid = in_array($cid, $id_allowed_not_login) ? $cid : $login_ID;
// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + 
// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + 

// echo $cid;

if ($cid) {

	$sql = "SELECT `lock`, fbimage FROM `morp_cms_nav` WHERE navid=$cid";
	$res = safe_query($sql);
	$row = mysqli_fetch_object($res);
	$islock = $row->lock;

	#if($islock && !$IAMIN) die('Sie sind nicht befugt!<br><br><br><a href="'.$dir.'">Zur Startseite</a>');
	#elseif($islock) echo('SPÄTER NUR FÜR BERECHTIGTE !!!!!!!!');

	$fbimage = $row->fbimage;


	$meta_fertig = '';

	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	// Hier alle Variablen setzen, die ggf im Template gesetzt werden
	$output='';
	$headerImg = '';
	$footer = '';
	$zusatz = '';
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

	// VU: change sql to show link from comment
	if(!$cidValue)
	  $query = "SELECT * FROM `morp_cms_content` c LEFT JOIN morp_cms_image i ON i.imgid=c.img1, `morp_cms_nav` n WHERE c.navid=".$cid." AND n.navid=c.navid AND ton=1 ORDER BY tpos";
	else 
	  $query = 'SELECT * FROM `morp_cms_content` c LEFT JOIN morp_cms_image i ON i.imgid=c.img1, `morp_cms_nav` n WHERE c.navid=1 AND n.navid=c.navid AND ton=1 and c.cid = '.$cidValue.' ORDER BY tpos';
	// END
	$result 	= safe_query($query);

	while ($row = mysqli_fetch_object($result)) {
		if ($row->emotional && !$leftimage) {
			$sql = "SELECT * FROM `morp_cms_image` WHERE imgid=".$row->emotional;
			$res = safe_query($sql);
			$rw  = mysqli_fetch_object($res);
			$leftimage = $rw->imgname;
		}

		$vid		= $row->vid;
		if ($vid) {
			$sql = "SELECT * FROM `morp_cms_content` c LEFT JOIN morp_cms_image i ON i.imgid=c.img1 WHERE cid=$vid";
			$res = safe_query($sql);
			$rw = mysqli_fetch_object($res);
			$throw = $rw;
		}
		else $throw = $row;

		$text		= $throw->$n_nm;
		$templ_id 	= $throw->tid;
		$templ_headl= $throw->theadl;
		$templ_lnk 	= $throw->tlink;
		$anker		= $templ_lnk;
		$twidth		= $throw->twidth;
		$theight	= $throw->theight;
		$templ_bgr 	= $throw->tbackground;
		$tfoto 		= $throw->timage;
		$tcolor		= $throw->tcolor;
		$tref		= $throw->tref;
		$tende		= $throw->tende;
		$tabstand	=$throw->tabstand;
		$tabstand_bottom = $throw->tabstand_bottom;
		$tclass		=$throw->tclass;
		$klasse		=$throw->klasse;
		$klasse2	=$throw->klasse2;
		$tschmal	= $throw->tschmal;
		$animation	= $throw->animation;
		$animation_time	= $throw->animation_time;
		$content_id	=$throw->cid;
		$uniqueID	= 'edit_'.$content_id;
		$position	=$throw->tpos;
		
		$style 		= '';

		// $foto 		= $row->imgname;

		$templ_lnk_anz = '';
		$templ_lnk_box = '';
		$foto_lnk = '';
		$foto_url = '';

	  	# # # # auswertung text startet
		# # # # auswertung text startet

		$get = (get_cms_text($text, $lang, $dir));
		$get = str_replace("u".chr(204).chr(136), 'ü', $get);
		$get = preg_replace_callback($pattern, "replace_string", $get);
 

/*
		for($i=1; $i<= strlen($get); $i++) {
			echo $get[$i].ord($get[$i]).'<br>';
		}
*/
		if($content_id == 28) $get = setLink($get, '', 'box');
		else $get = setLink($get, '', 'underline');
		$get = str_replace("u".chr(204).chr(136), 'ü', $get);
		$get = str_ireplace($hashtag_search, '<span id="'.eliminiere($hashtag_search).'"></span>'.strtoupper($hashtag_search), $get);


		// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		// hole Template
		include("templates/". ($templ_id ? $templ_id : 1) .".php");

		if ($templ_id == 70)				$content = "headertext";
		elseif ($templ_id == 400 && $cid != 400)			$content = "slider";
		# elseif ($templ_id == 80)		$content = "footer";
		else							$content = "output";

		//echo $content;
		// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		// fuelle Template mit Content / in durch $content zugeiwesene Var
		$$content .= str_replace(
			array("#cont#", "#col#", "#headl#", "#foto#", "#style#", "#link#", "#link_anz#", "#link_box#", "#link_pur#", "<!-- SUBNAV03 -->", "#DIR#", ), 
			array($get, $templ_bgr, $templ_headl, $foto_url, $style, $templ_lnk, $templ_lnk_anz, $templ_lnk_box, $foto_lnk, $sub3, $dir, ), 
				$template);
		
		// $$content .= str_replace(array("#cont#", "#col#", "#headl#", "#foto#", "#style#", "#link#", "#link_anz#", "#link_box#", "#link_pur#", "<!-- SUBNAV03 -->"), array($get, $templ_bgr, $templ_headl, $foto_url, $style, $templ_lnk, $templ_lnk_anz, $templ_lnk_box, $foto_lnk, $sub3), $template);

		$tref = '';
	# # # # # # # # # # # # # # # # # # # # # # # # # # #

		if (!$meta_fertig) {
			foreach ($meta_arr as $meta) {
				$meta_		= $meta;
				$$meta = $throw->$meta_;
			}

			# META Infos zusammenstellen
			if ($ebene > 2) $zusatz = $_GET["sn".($ebene-1)];
			else			isset($_GET["hn"]) ? $_GET["hn"] : '';

#			if (!$title && $zusatz)	$title = $zusatz;
#			if (!$desc)		$desc = substr(get_raw_text ($text, $lan), 0, 250);
#			if (!$keyw)		$keyw = $zusatz;

			$meta_fertig = 1;
		}
	}
}

$reinText = strip_tags($output);
$reinText = preg_replace(array("/\n/", "/<br \/>/", "/\s+/"), array(" ", " ", " "), $reinText);

if (!$title)	{
	$title = $navarrayFULL[$cid];
}
if (!$desc)	{
	$zusatz = wort_anz($reinText, 150, 0);
	$desc = trim($zusatz);
}


global $nMetaTitle, $nMeatDesc;

if($nMetaTitle) $title = $nMetaTitle;
if($nMeatDesc) $desc = $nMeatDesc;

# if (!$keyw)		$keyw = $zusatz;

// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
//     4   AUSGABE
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .
// .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .   .

	
# $output = utf8_decode($output);
// echo 'xxxxxx'.$design;

$zufall=rand(0,999);

// if($mobile && $design == 2) $design = 3;

include("design/header_inc.php");
include("design/top.php");
// if($_GET['hn'] == 'home' || $_GET['hn'] == '') 
// 	include("design/top-triangles.php");

if ($design) 	include("design/design-".$design.".php");
else 			include("design/design-1.php");

// if ($cid==15) {
// 	include("design/login.php");
// }

include("design/footer_inc.php");
include("design/footer-tracking.php");
//include("tinymce.php");

?>

</body>
</html>