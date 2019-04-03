<?php
error_reporting(0);
$connect= mysqli_connect('localhost','root','','clgmnt');
if(!$connect)
{
	printf("Can't connect to MySQL Server.", mysqli_connect_error());
	exit;
}

date_default_timezone_set("Asia/Kolkata");
?>