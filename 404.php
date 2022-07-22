<?php
include("nogo/config.php");
$lan = "de";
$dir = $morpheus["url"];
$page404 = 1;

include_once("nogo/funktion.inc");
include("nogo/".$lan.".inc");
include("nogo/navarray_".$lan.".php");
include("nogo/navID_".$lan.".inc");
include("nogo/db.php");
dbconnect();
// SETTINGS KUNDEN LADEN
$sql = "SELECT * FROM morp_settings WHERE 1";
$res = safe_query($sql);
while($row = mysqli_fetch_object($res)) {
	$morpheus[$row->var] = $row->value;
}
include("design/header_inc.php");
include("design/top.php");

?>

<main>
	<div style="display: block; height: 200px; "></div>
	
	<div class="container text-center">
		
		<H1>Fehler: Die gewünschte Seite ist nicht vorhanden</H1>
		<H1>Error: The requested page does not exist</H1>
		<p>&nbsp;</p>
		
		<p><a href="<?php echo $dir; ?>">Zur Startseite</a></p>
	</div>
</main>


</body>
</html>