<?php

include_once "$_SERVER[DOCUMENT_ROOT]/PHP/config.php";
 
session_start();
$username = $_POST['username'];
$password = ($_POST['password']);
$qry = "SELECT username FROM Users WHERE username='".$username."' and password='".$password."'";

$result = $conn->query($qry);

if ($result != False) {
    $row = $result->fetch_assoc();
    $num_row = $result->num_rows;
} else {
    $num_row = 0;
};

$result->close();
if( $num_row == 1 ) {
    
    $_SESSION['username'] = $row['username'];
    echo 'true';
    
}
else {
    
    echo 'false';

}

?>