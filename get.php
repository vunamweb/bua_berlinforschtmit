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
// $data = $_POST["data"];

$sql = "SELECT text, name, einfuehrungstext FROM $table WHERE $tid=".$kind."";
$res = safe_query($sql);
$row = mysqli_fetch_object($res);

$text = explode("\n", $row->text);

$ret = '                                <p id="breadc">Berlin forscht | '.$row->name.'</p>
                                <div class="overflow-auto">                                
                                        <div id="gesagt">'.($row->einfuehrungstext ? '<p>'.$row->einfuehrungstext.'</p>' : '');


$sql = "SELECT mediaID FROM morp_stimmen_media WHERE $tid=".$kind."";
$res = safe_query($sql);

$table 	= 'morp_media';
$tid 	= 'mediaID';
$nameField 	= "mp3";
while($row = mysqli_fetch_object($res)) {
    $media = $row->media;

    $sql = "SELECT $nameField, dauer, textonline FROM $table WHERE public='true' AND $tid =".trim($file);
    $res = safe_query($sql);
    $row = mysqli_fetch_object($res);
    $filename = 'mp3/'.$row->$nameField;
    if(file_exists($filename)) $ret .= '<audio controls class=""><source src="../'.$filename.'" type="audio/mpeg"></audio>';
    if($row->textonline) $ret .= '<article><p>'.$row->textonline.'</p></article>';
	
}
    
    $tmp .= implode('</p></article><article><p>', $text);    
    $ret .= '
<article>
    <p>'.$tmp.'</p>
';

$ret .= '</article>
';
// }

echo $ret .= '
                                        </div>                                        
                                </div>';
