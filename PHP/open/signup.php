<?php

include_once "$_SERVER[DOCUMENT_ROOT]/PHP/config.php";
 
session_start();
$username = $_POST['username'];
$password = ($_POST['password']);
$qry = "SELECT username FROM Users WHERE username='".$username."'";
$result = $conn->query($qry);

if ($result != False) {
    $row = $result->fetch_assoc();
    $num_row = $result->num_rows;
} else {
    $num_row = 0;
};

$result->close();
if( $num_row == 1 ) {
    
    // the username already exists
    echo 'false';
    
}
else {
    // insert into database
    $qry = "INSERT INTO Users (username, password) VALUES ('".$username."', '".$password."')";
    $result = $conn->query($qry);
    
    $_SESSION['username'] = $row['username'];
    echo $qry;
    echo 'true';
}

?>