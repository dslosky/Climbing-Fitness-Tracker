<!DOCTYPE HTML>

<?php
// define variables and initialize with empty values
$Errs['Empty'] = " ";
$exists['Empty'] = " ";
$formComplete = 0;

$myEmail = "das294@nau.edu";
date_default_timezone_set('America/Phoenix');
$Time = time();
$theTime = date("Y-m-d-H-i-s", $Time);

/* 

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


*/
?>

<html>
<head>
    <title>Sign In</title>
    <link rel="stylesheet" href="/CSS/bootstrap.css">
    <link rel="stylesheet" href="/CSS/login.css">
</head>

<body>
    
    <div class="jumbotron">
        <div class='row'>
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h1>Rock Climber's Training Log</h1>
            </div>
        </div>
        <div class='row'>
            <div class="col-md-3"></div>
            <div class="col-md-5">
                <h3>Log in or sign up!</h3>
            </div>
        </div>

    </div>
    
    <br>
    
        <div class="loginform">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> <!-- This runs the method post and returns to this document when the form is submitted -->
        <?php

            // Creates arrays with all the info we need to build our form
            $labels = array("Username: ", "Password: ");
            $names = array("username", "password");
            $formType = array("text", "text");
                
            // this for loop creates the form!
            for($i = 0; $i < count($labels); $i++) {
                
                // Checks to see if the name of this field is stored in the variable Errs where we log the names of the empty required fields 
                // This is done so we can setup an error message for this field      
                if (array_key_exists($names[$i], $Errs)){
                    echo "<div class='row'>\n
                            <div class='col-md-4'></div>\n
                            <div class='col-md-1'>\n
                                <p>$labels[$i]</p>\n
                            </div>\n
                            <div class='col-md-1'>\n
                                <p><input type='$formType[$i]' name='$names[$i]'></p>\n
                            </div>";
                    
                    echo "<div class='col-md-1'>\n
                            <p>*Please Complete This Field</p>
                          </div>
                          </div>"; 
                } 
                
                // Checks to see if the field has been completed correctly. If so, we should be able to get the page to reload with the field
                // already filled... This doesn't quite work yet
                elseif (array_key_exists($names[$i], $exists)){
                    $key = $names[$i];

                    echo "<div class='row'>\n
                            <div class='col-md-4'></div>\n
                            <div class='col-md-1'>\n
                                <p>$labels[$i]</p>\n
                            </div>\n
                            <div class='col-md-1'>\n
                                <p><input type='$formType[$i]' name='$names[$i]' value='$_POST[$key]'></p>\n
                            </div>
                          </div>";
                } 
                
                else {
                    echo "<div class='row'>\n
                            <div class='col-md-4'></div>\n
                            <div class='col-md-1'>\n
                                <p>$labels[$i]</p>\n
                            </div>\n
                            <div class='col-md-1'>\n
                                <p><input type='$formType[$i]' name='$names[$i]'></p>\n
                            </div>
                          </div>"; 
                }
            }
            echo "<br>";
                    
        ?>
            <div class="row">
                <div class="col-md-5"></div>
                <div class='col-md-1'>
                    <input type = "submit" value = "Sign In" />
                </div>
                
                <div class='col-md-1'>
                    <p> or <a href=signup.php>Sign Up</a></p> 
                </div>
                
            </div>
        </form>
    </div>
    
                    

        
</body>
    
    
</html>