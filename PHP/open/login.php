<?php
if (!session_id()){session_start();};
include_once "$_SERVER[DOCUMENT_ROOT]/PHP/config.php";
 
$username = $_POST['username'];
$password = $_POST['password'];
$qry = "SELECT username,id FROM Users WHERE username='".$username."' and password='".$password."'";

$result = $conn->query($qry);

if ($result != False) {
    $row = $result->fetch_assoc();
    $num_row = $result->num_rows;
} else {
    $num_row = 0;
};

$result->close();
if( $num_row == 1 ) {
    
    setcookie("username", $row['username'], time() + 600000, "/");
    setcookie("id", $row['id'], time() + 600000, "/");
    
    $_SESSION['username'] = $row['username'];
    $_SESSION['id'] = $row['id'];
    echo 'true';
    
}
else {
    
    echo 'false';

}

$conn->close();
exit();
?>