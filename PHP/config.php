<?php
########## MySql details #############
$username =     "climbingmanager"; //mysql username
$password =     "pass";            //mysql password
$hostname =     "localhost";       //hostname
$databasename = "alltables";       //databasename

//connect to database
$conn = new mysqli($hostname, $username, $password, $databasename);

?>