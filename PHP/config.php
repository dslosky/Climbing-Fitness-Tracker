<?php

#import credentials
include_once 'creds/cred-config.php';

########## MySql details #############
$username =     USER;       //mysql username
$password =     PASSWORD;   //mysql password
$hostname =     HOST;       //hostname
$databasename = DATABASE;   //databasename

//connect to database
$conn = new mysqli($hostname, $username, $password, $databasename);
?>