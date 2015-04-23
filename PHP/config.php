<?php
########## MySql details #############
$username =     "climbingmanager"; //mysql username
$password =     "pass";            //mysql password
$hostname =     "localhost";       //hostname
$databasename = "allTables";       //databasename

//connect to database
$conn = new mysqli($hostname, $username, $password, $databasename);

?>