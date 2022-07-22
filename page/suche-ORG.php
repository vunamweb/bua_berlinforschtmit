<?php
/* Zeichenkette in Zahl umwandeln

$num = intval($string);           //in Ganzzahl umwandeln
$num = floatval($string);         //in Gleitkommazahl

	Zahl in Zeichenkette
$str = strval($zahl);

  	Prüfen, ob variable bereits verwendet wurde
if ( isset($variable) ) { ... }

  	Typprüfungen
   if ( is_numeric($variable) ) { ... }   //numerischer Typ
   if ( is_string($variable) ) { ... }    //Zeichenkette
*/
global $lan, $navID;

$suche = isset($_GET["suche"]) ? $_GET["suche"] : '';
// print_r($_GET);

$suche 	= trim(utf8_decode($suche));
// $suche 	= substr(trim(utf8_decode($suche)),0,30);


// TRACKING der Suchbegriffe //
$dat = date("Y-m-d H:m:s");
$sql = "INSERT morp_suche_track set suche='$suche', time='$dat'";
safe_query($sql);
// ===========================================================//

$ersetz	= array ("ä","ö","ü","Ä","Ö","Ü","ß");
$durch = array ("ae","oe","ue","Ae","Oe","Ue","ss");
$suche = str_replace($ersetz, $durch, $suche);


$ersetz	= array (" und ",  " and ",  " oder ",  " or ",  ' + ',  ' +',  '+ ',  '+');
$marker = str_replace($ersetz, array(" ", " ", " ", " ", " ", " ", " ", " "), $suche);
$sstr 	= explode(" ", $marker);
$sstr 	= array_unique($sstr);

// print_r($sstr);
$newarr = array();
foreach ($sstr as $search) {
	if($search) $newarr[] = $search;
}
$sstr = $newarr;

$db1 	= "morp_suche_count";
$db2 	= "morp_suche_keyw";
$anz 	= "anz".$lan;

$output = '';

$output = '<h2>Sie suchen nach: '.implode(" UND ", $sstr).'</h2>
	<p>&nbsp;</p>
';

# $arr 	= array(1=>"Inhalt", 2=>"connect-uebersicht", 3=>"connect-detail", 4=>"Seminar");

$arr 	= array(1=>"Inhalt");

$sql 	= "SELECT mc1.navid, mc1.art FROM ";
$whe 	= " WHERE ";
$x	 	= 0;
$ersetz = array();
$ersetzP = array();


foreach ($sstr as $search) {
	if($search) {
		$x++;
		$ersetz[]  = '<span class="marker">'.strToUpper($search).'</span>';
		$ersetzP[] = '<strong>'.strToUpper($search).'</strong>';

		$sql .= ($x > 1 ? ", " : "") . "$db1 mc".$x.", $db2 mk".$x;

		$whe .= ($x > 1 ? " AND " : "") . "
			mc".$x.".kid=mk".$x.".kid AND
			mk".$x.".keyw LIKE '%".$search."%'";

		if ($x > 1) $whe .= " AND mc1.navid=mc".$x.".navid ";
	}
}

echo $sql .= $whe ."
		ORDER BY mc1.$anz, mc1.art ASC
";

// die();

$res = safe_query($sql);
$n 	 = mysqli_num_rows($res);


$arr1 = array();

while ($row = mysqli_fetch_object($res)) {
	#$id  = $row->kid;
	#$de  = $row->keyw;
	$ni  = $row->navid;
	$art = $row->art;
	#$stid = $row->stid;
	#$an  = $row->$anz;

	$tmp = "arr".$art;
	if ($art && $ni) {
		array_push($$tmp, $ni);
	}
}


# print_r($arr1);
# print_r($arr2);
# print_r($arr3);
# print_r($arr4);
# print_r($marker);
# print_r($ersetz);

if (count($arr1) > 0) {
	$such = implode($arr1, " OR n.navid=");

	$sql = "SELECT n.navid, name FROM morp_cms_nav n, morp_cms_content c
			WHERE
				n.navid=c.navid AND
				(
				n.navid=$such
				)
			GROUP BY n.navid
	";

	$res = safe_query($sql);
	$ct  = mysqli_num_rows($res);

	while ($row = mysqli_fetch_object($res)) {
		$id  = $row->navid;
		$de  = $row->name;
		# $co  = substr(get_raw_text($row->content), 0, 2000);
//		$co  = get_raw_text($row->content);
		# $co  = get_cms_text($row->content, $lan, $dir);

		$anzeige = 0;

		// if (strpos($co, "produktbox")) unset($anzeige);

/*
		if (($anzeige)) {
			// content holen und in einzelne saetze zerlegen
			$str 	 = str_replace(array("\r", "\n", "\t", "&nbsp;", "  "), " ", strip_tags($co));
			$str_arr = explode(".", $str);
			$ausg	 = "";

			foreach($str_arr as $satz) {
				unset($tmp);
				foreach ($sstr as $val) {
					if (stripos($satz, $val) > 0 && !$tmp) $tmp = $satz."... ";
				}
				if ($tmp) $ausg .= $tmp;
			}

			$ausg = str_ireplace($sstr, $ersetz, $ausg);
		}
		$output .= '<h2 class="serg">&raquo; <a href="'.$dir.$navID[$id].'">'.$de.'</a></h2>
					' .($ausg ? '<p>'.$ausg.'</p>' : '<p>'.substr($co, 0, 80).'...</p>') .'
';
*/
		$output .= '<p style="margin-bottom:20px;">&raquo; <a href="'.$dir.$navID[$id].'">'.$de.'</a></p>
';
	}
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////


	if ($ct < 1 && $cct < 1) $output = '
	<h2>Ihre Such-Anfrage "<i>'.$suche.'</i>" hat kein Ergebnis erzielt</h2>';

?>