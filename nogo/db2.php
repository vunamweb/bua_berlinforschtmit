<?php

function dbconnect2 ()
{
	global $morpheus, $mylink2;

	$dbname		= $morpheus["dbname2"];
	$user		= $morpheus["user2"];
	$password	= $morpheus["password2"];
	$server		= $morpheus["server"];

	$mylink2 = mysqli_connect($server,$user,$password,$dbname);
	$mylink2->set_charset("utf8");
	// print_r($mylink);
	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
}
function dbclose2 ()
{
	mysqli_close($mylink2);
}
function safe_query2 ($query = "")
{
	global	$mylink2;
	// echo $query."<br>";
	if (empty($query)) { return FALSE; }
	
	// if (!empty($query_debug)) { print "<pre>$query</pre>\n"; }
	$result = mysqli_query($mylink2, $query);

	return $result;
}

// 
// function dbconnect ()
// {
// 	global $morpheus, $mylink2;
// 
// 	$dbname		= $morpheus["dbname"];
// 	$user		= $morpheus["user"];
// 	$password	= $morpheus["password"];
// 	$server		= $morpheus["server"];
// 
// 	$mylink2 = mysqli_connect($server,$user,$password,$dbname);
// 	$mylink2->set_charset("utf8");
// 	// print_r($mylink);
// 	/* check connection */
// 	if (mysqli_connect_errno()) {
// 		printf("Connect failed: %s\n", mysqli_connect_error());
// 		exit();
// 	}
// }
// function dbclose ()
// {
// 	mysqli_close($mylink2);
// }
// function safe_query ($query = "")
// {
// 	global	$mylink2;
// 	// echo $query."<br>";
// 	if (empty($query)) { return FALSE; }
// 	
// 	// if (!empty($query_debug)) { print "<pre>$query</pre>\n"; }
// 	$result = mysqli_query($mylink2, $query);
// 
// 	return $result;
// }