<?php
$host = "";
$user = "";
$pass = "";
$db   = "";
$conn = @mysql_connect($host,$user,$pass) or die(mysql_error());
@mysql_select_db($db,$conn) or die(mysql_error());
?>