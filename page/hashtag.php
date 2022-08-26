<?php
# # # # # # # # # # # # # # # # # # # # # # # # # # #
# www.pixel-dusche.de                               #
# björn t. knetter                                  #
# start 12/2003                                     #
# edit 27.11.2006                                   #
# post@pixel-dusche.de                              #
# frankfurt am main, germany                        #
# # # # # # # # # # # # # # # # # # # # # # # # # # #

include("../nogo/funktion.inc");
include("../nogo/config.php");
include("../nogo/db.php");

dbconnect();

$name = $_REQUEST['name'];

$query = 'insert into morp_hashtag(name)values("'.$name.'")';
safe_query($query);
?>