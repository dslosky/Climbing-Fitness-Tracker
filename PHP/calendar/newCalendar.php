<?php
    // put new calendar into database
    if (!session_id()){session_start();};
    include_once("$_SERVER[DOCUMENT_ROOT]/PHP/config.php");
    
    $start = $_POST['startDate'];
    $end = $_POST['endDate'];
    $weekCount = $_POST['weeks'];
    
    $qry = "INSERT INTO Calendar (UserID, StartDate, EndDate, weeks) VALUES ('" . $_SESSION['id'] . "', '" . $start . "', '" . $end . "', '" . $weekCount . "')";
   
    $calendars = $conn->query($qry);
   
    $qry = "SELECT * from Calendar where UserID=" . $_SESSION['id'];
 
    $calendars = $conn->query($qry);
    // add calendar to the calendar array
    if ($calendars != false) {
        $calArray = [];
        $i = 0;
        while ($row = $calendars->fetch_assoc()){
            $calArray['calendar' . $i] = $row;
            $i++;
        };
    };
    
    $_SESSION['calendars'] = $calArray;
    $_SESSION['calendar'] = end($_SESSION['calendars']);
    
    // save all new workouts
    
    
    
    
    $conn->close();
    // load calendar to page
    
    include_once "$_SERVER[DOCUMENT_ROOT]/PHP/calendar/loadCalendar.php";

?>