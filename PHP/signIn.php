<?php
// define variables and initialize with empty values
$Errs['Empty'] = " ";
$exists['Empty'] = " ";
$formComplete = 0;

$myEmail = "das294@nau.edu";
date_default_timezone_set('America/Phoenix');
$Time = time();
$theTime = date("Y-m-d-H-i-s", $Time);



// This method is executed when the user hits submit! It checks to make sure all the necessary fields have been completed
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $servername = "localhost";
    $username = "dan";
    $password = "pass";
    $dbname = "mytestdatabase";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    // These will be set to 1 when the user enters correct usernames and passwords, these will be checked to see if the
    // user can access the main page
    $user = 0;
    $pass = 0;
    
    
    if (empty($_POST["username"])) {
        $nameErr = "Missing";
        $Errs['username'] = "Missing";
    } else {
        $username = $_POST["username"];
        $qry = "SELECT UserName FROM Users";
        $result = $conn->query($qry);
        
        $UserNames = array();
        $n = 0;
        while ($row = $result->fetch_assoc()) {
            $UserNames[$n] = $row['UserName'];
            $n++;
        }
        
        if (in_array($username, $UserNames)) {
            $user = 1;
            
            for ($n = 0; $n<= count($UserNames)-1; $n++) {
                if ($UserNames[$n] == $username) {
                    $UserIndex = $n;
                }
            }
            
            if (empty($_POST["password"])) {
                $nameErr = "Missing";
                $Errs['password'] = "Missing";
            } else {
                $qry = "SELECT Password FROM Users";
                $result = $conn->query($qry);
                
                $Passes = array();
                $n = 0;
                while ($row = $result->fetch_assoc()) {
                    $Passes[$n] = $row['Password'];
                    $n++;
                }
            
                if ($Passes[$UserIndex] == $_POST["password"]) {
                    $pass = 1;
                    
                    // Get the other information about the user and save it in _SESSION
                    $qry = "SELECT * FROM Users WHERE UserName = '" . $username . "'";
                    $result = $conn->query($qry);
                    
                    $UserInfo = $result->fetch_assoc();
                    session_start();
                    
                    $_SESSION['UserIndex'] = $UserIndex;
                    $_SESSION['UserInfo'] = $UserInfo;
                    
                    // Create a log entry for the user's loginform
                    date_default_timezone_set('America/Phoenix');
                    $Time = time();
                    $theTime = date("Y-m-d-H-i-s", $Time);
                    
                    $qry = "INSERT INTO Logs (UserName, Login) VALUES ('" . $UserInfo['UserName'] . "', '" . $theTime . "')";
                    $result = $conn->query($qry);
                   
                    }
            }
        }
     }
    
    // This if statement checks to see if all the fields have been filled. If they have, it sends the email to my school address
    if ($user == 1 && $pass == 1) {
        header("Location: loggedin.php"); 
    }
    else {
        echo "<p style='color:red'>Please Enter a Valid Username and Password</p>"; // if the message is incomplete, the user is sent back to fix it!
        
    }
    
    mysqli_close($conn);
    
}

?>