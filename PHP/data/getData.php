<?php
if (!session_id()){session_start();};
// connect to database
include_once "$_SERVER[DOCUMENT_ROOT]/PHP/config.php";


$_SESSION['username'] = $_COOKIE['username'];
$_SESSION['id'] = $_COOKIE['id'];

echo 'user: ' . $_SESSION['username'];
echo 'id: ' . $_SESSION['id'];

$username = $_SESSION['username'];
$id = $_SESSION['id'];

// get all information out of the database. This should probably be one request...
$calqry = "select * from calendar where calendar.userid = $id order by id";
$arcqry = "select * from arc where arc.userid = $id order by id";
$hangqry = "select * from hangboard where hangboard.userid = $id order by id";
$campusqry = "select * from campus where campus.userid = $id order by id";
$lbcqry = "select * from lbc where lbc.userid = $id order by id";
$limitqry = "select * from limitboulder where limitboulder.userid = $id order by id";
$omqry = "select * from om where om.userid = $id order by id";
$otherqry = "select * from other where other.userid = $id order by id";
$userqry = "select * from userinfo where userinfo.userid = $id order by userid";

$calendars = $conn->query($calqry); 
$arc = $conn->query($arcqry); 
$hang = $conn->query($hangqry);
$campus = $conn->query($campusqry);
$lbc = $conn->query($lbcqry);
$limitB = $conn->query($limitqry);
$om = $conn->query($omqry);
$other = $conn->query($otherqry);
$user = $conn->query($userqry);



// extract info from sql objects

if ($calendars != false) {
    $calArray = [];
    $i = 0;
    while ($row = $calendars->fetch_assoc()){
        $calArray['calendar' . $i] = $row;
        $i++;
    };
};

if ($arc != false) {
    $arcArray = [];
    $i = 0;
    while ($row = $arc->fetch_assoc()){
        $arcArray['arc' . $i] = $row;
        $i++;
    };
};

if ($hang != false) {
    $hangArray = [];
    $i = 0;
    while ($row = $hang->fetch_assoc()){
        $hangArray['hang' . $i] = $row;
        $i++;
    };
};

if ($campus != false) {
    $campusArray = [];
    $i = 0;
    while ($row = $campus->fetch_assoc()){
        $campusArray['campus' . $i] = $row;
        $i++;
    };
};

if ($lbc != false) {
    $lbcArray = [];
    $i = 0;
    while ($row = $lbc->fetch_assoc()){
        $lbcArray['lbc' . $i] = $row;
        $i++;
    };
};

if ($limitB != false) {
    $limitArray = [];
    $i = 0;
    while ($row = $limitB->fetch_assoc()){
        $limitArray['limit' . $i] = $row;
        $i++;
    };
};

if ($om != false) {
    $omArray = [];
    $i = 0;
    while ($row = $om->fetch_assoc()){
        $omArray['om' . $i] = $row;
        $i++;
    };
};

if ($other != false) {
    $otherArray = [];
    $i = 0;
    while ($row = $other->fetch_assoc()){
        $otherArray['other' . $i] = $row;
        $i++;
    };
};

if ($user != false) {
    $userArray = [];
    $i = 0;
    while ($row = $user->fetch_assoc()){
        $userArray['user' . $i] = $row;
        $i++;
    };
};
// store arrays as session variables

$_SESSION['calendars'] = $calArray;
$_SESSION['arc'] = $arcArray;
$_SESSION['hang'] = $hangArray;
$_SESSION['campus'] = $campusArray;
$_SESSION['limit'] = $limitArray;
$_SESSION['lbc'] = $lbcArray;
$_SESSION['om'] = $omArray;
$_SESSION['other'] = $otherArray;
$_SESSION['user'] = $userArray;

// close database connection
$conn->close();
exit();
?>