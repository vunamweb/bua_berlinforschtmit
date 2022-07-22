<?php
function dbconnect ()
{
	global $morpheus, $mylink;

	$dbname		= $morpheus["dbname"];
	$user		= $morpheus["user"];
	$password	= $morpheus["password"];
	$server		= $morpheus["server"];

	$mylink = mysqli_connect($server,$user,$password,$dbname);
	$mylink->set_charset("utf8");
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
}
function dbclose ()
{
	mysqli_close($mylink);
}
function safe_query ($query = "")
{
	global	$mylink;
	// echo $query."<br>";
	if (empty($query)) { return FALSE; }
	
	// if (!empty($query_debug)) { print "<pre>$query</pre>\n"; }
	$result = mysqli_query($mylink, $query);

	return $result;
}