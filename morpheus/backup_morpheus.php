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

include("cms_include.inc");

$f = fopen($morpheus["dfile"], "w");
// $res 		= mysql_list_tables($morpheus["dbname"]);
$res = "SHOW TABLES FROM ".$morpheus["dbname"];
$res = safe_query($res);

$ausschluss = array(
"morp_newsletter",
"morp_newsletter_cont",
"morp_newsletter_track",
"morp_newsletter_versand",
"morp_newsletter_vt",
"morp_newsletter_vt_csv",
"morp_newsletter_vt_test",
"morp_newsletter_vt_test-nurich",
"morp_register",
);

while ($row = mysqli_fetch_row($res)) {
	#print_r($row);
    if(in_array($row[0], $ausschluss)) {}
    else $tables[] = $row[0];
}

# print_r($tables);

$n = 0;

foreach ($tables as $table) {
	# echo $table."<br>";
	fwrite($f,"DROP TABLE `$table`;\n");
	$sql = "SHOW CREATE TABLE `$table`";
	$res = safe_query($sql);

	if ($res) {
		$create = mysqli_fetch_array($res);
		$create[1] .= ";";
		$line = str_replace("\n", "", $create[1]);

		fwrite($f, $line."\n");
		$que 	= "SELECT * FROM `$table`";
		$result = safe_query($que);
		$num 	= mysqli_num_fields($result);

		while ($row = mysqli_fetch_array($result)){
			$n++;
		    $line = "INSERT INTO `$table` VALUES(";
		    for ($i=1;$i<=$num;$i++) {
		     	$line .= "'".mysqli_real_escape_string($mylink, stripslashes($row[$i-1]))."', ";
		    }
	    	$line = substr($line,0,-2);
	    	fwrite($f, $line.");\n");
	 	}
	}
}
fclose($f);

$link = "download.php?dfile=morpheus_db.sql";

#echo "<script language='javascript'>
#	parent.location = '$link';
#</script>";

echo '
<div id=content_big class=text>
';

echo "<p><strong>$n SQL Befehle geschrieben</strong></p>";

echo '<p>Bitte die Datei runterladen und archivieren.</p>
<p><a href="download.php?dfile=morpheus_db.sql"><strong>&raquo; Klicken Sie bitte hier um die Datenbank Sicherung zu Archivieren</strong></a></p>
<p><a href="download.php?dfile=backup-morpheus.zip"><strong>&raquo; Klicken Sie bitte hier um alle Dateien zu Sichern.</strong></a></p>
';
?>

</div>

</body>
</html>

<?php
/**
* @description rekursives erstellen eines zip archives mit php
* @inspired by @url http://andreknieriem.de
* @todo: rekursive blacklist's
*/

/*
 * Anmerkung: Der Ordner . bezeichnet immer den Ordner selbst. Der Ordner ..
 * den jeweils darüber liegenden Ordner. Leere Ordner enthalten nur . und ..
 * und sind darüber zu erkennen.
 * Ordner die nicht leer sind, werden durch die enthaltenden Ordner oder Dateien
 * übernommen.
 */

$path = __DIR__;
$path = explode("/", $path);
$x = count($path);
$x = $x-2;
$zippath = $path[$x];

// echo $zippath;

unlink("backup-morpheus.zip");

// zu zippender ordner
$folder = "../../$zippath/";

// file und dir counter
$fc = 0;
$dc = 0;

// die maximale Ausführzeit erhöhen
ini_set("max_execution_time", 300);

// Objekt erstellen und schauen, ob der Server zippen kann
$zip = new ZipArchive();
if ($zip->open("backup-morpheus.zip", ZIPARCHIVE::CREATE) !== TRUE) {
	die ("Das Archiv konnte nicht erstellt werden!");
}

echo "<pre>";
// Gehe durch die Ordner und füge alles dem Archiv hinzu
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));
foreach ($iterator as $key=>$value) {
	// echo "Key -- $value <br>";

  if(!is_dir($key)) { // wenn es kein ordner sondern eine datei ist
    // echo $key . " _ _ _ _Datei wurde übernommen</br>";
    $zip->addFile(realpath($key), $key) or die ("FEHLER: Kann Datei nicht anfuegen: $key");
    $fc++;

  } elseif (count(scandir($key)) <= 2) { // der ordner ist bis auf . und .. leer
    // echo $key . " _ _ _ _Leerer Ordner wurde übernommen</br>";
    $zip->addEmptyDir(substr($key, -1*strlen($key),strlen($key)-1));
    $dc++;

  } elseif (substr($key, -2)=="/.") { // ordner .
    $dc++; // nur für den bericht am ende

  } elseif (substr($key, -3)=="/.."){ // ordner ..
    // tue nichts

  } else { // zeige andere ausgelassene Ordner (sollte eigentlich nicht vorkommen)
    echo $key . "WARNUNG: Der Ordner wurde nicht ins Archiv übernommen.</br>";
  }
}
echo "</pre>";

// speichert die Zip-Datei
$zip->close();

// bericht
echo "<h4>Das Archiv wurde erfolgreich erstellt.</h4>";
echo "<p>Ordner: " . $dc . "</br>";
echo "Dateien: " . $fc . "</p>";
?>