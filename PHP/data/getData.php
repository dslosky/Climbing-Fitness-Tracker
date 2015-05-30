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

//$qry = "select * from calendar,arc,hangboard,campus,lbc,limitboulder,om,other,userinfo where calendar.userid=arc.userid=hangboard.userid=campus.userid=lbc.userid=limitboulder.userid=om.userid=other.userid=userinfo.userid=(select id from users where username=".$username.")";

/*
$qry = "select calendar.*,arc.*,hangboard.*,campus.*,lbc.*,limitboulder.*,om.*,other.*,userinfo.* from calendar
left join arc on arc.userid = (select id from users where username='".$username."')
left join hangboard on hangboard.userid = (select id from users where username='".$username."')
left join campus on campus.userid = (select id from users where username='".$username."')
left join lbc on lbc.userid = (select id from users where username='".$username."')
left join limitboulder on limitboulder.userid = (select id from users where username='".$username."')
left join om on om.userid = (select id from users where username='".$username."')
left join other on other.userid = (select id from users where username='".$username."')
left join userinfo on userinfo.userid = (select id from users where username='".$username."')
where calendar.id = (select id from users where username='".$username."')";

,null,null,null,null,null,null,null,null,null,null,null


$qry = "select *,null,null,null,null,null,null,null,null,null,null,null from calendar where calendar.userid = $id
UNION
select * from hangboard where hangboard.UserID = $id";/*
UNION ALL
select *,null,null,null,null,null,null,null,null,null from campus where campus.UserID = $id";
*/
//$qry = "select * from hangboard where hangboard.UserID = $id";

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
$_SESSION['lbc'] = $lbcArray;
$_SESSION['om'] = $omArray;
$_SESSION['other'] = $otherArray;
$_SESSION['user'] = $userArray;

// close database connection
$conn->close();
exit();
?>