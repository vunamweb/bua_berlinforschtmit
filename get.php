<?php 
include("nogo/config.php");
include("nogo/funktion.inc");
include("nogo/db.php");
dbconnect();

$table 		= 'morp_stimmen';
$tid 		= 'stID';
$nameField 	= "name";
$sortField 	= 'reihenfolge';

// print_r($_POST);

$kind = $_POST["kind"];
$level = $_POST["level"];
$data = $_POST["data"];

$sql = "SELECT text, name, einfuehrungstext FROM $table WHERE $tid=".$kind."";
$res = safe_query($sql);
$row = mysqli_fetch_object($res);

$text = explode("\n", $row->text);

$ret = '                                <p id="breadc">Berlin forscht | '.$row->name.'</p>
                                <div class="overflow-auto">                                
                                        <div id="gesagt">'.($row->einfuehrungstext ? '<p>'.nl2br($row->einfuehrungstext).'</p>' : '');
$ret .= '<h2>Stimmen</h2>';

$sql = "SELECT mediaID FROM morp_stimmen_media WHERE $tid=".$kind."";
$res = safe_query($sql);

$table 	= 'morp_media';
$tid 	= 'mediaID';
$nameField 	= "mp3";
while($row = mysqli_fetch_object($res)) {
    $media = $row->mediaID;
    $sql = "SELECT $nameField, dauer, textonline FROM $table WHERE ck01=1 AND ck02=1 AND ck03=1 AND $tid=$media";
    $rs = safe_query($sql);
    $rw = mysqli_fetch_object($rs);
	
    $filename = 'mp3/'.$rw->$nameField;
    if($rw->$nameField && file_exists($filename)) $ret .= '<audio controls class=""><source src="'.$morpheus["url"].$filename.'" type="audio/mpeg"></audio>';
    if($rw->textonline) $ret .= '<article><p>'.nl2br($rw->textonline).'</p></article>'; 
}
    
    $tmp .= implode('</li><li>', $text);    
    $ret .= '
	<h2>Aussagen</h2>
<article>
    <ul><li>'.$tmp.'</li></ul>
';

$ret .= '</article>
';
// }

echo $ret .= '
                                        </div>                                        
                                </div>';
