<?php
if (!session_id()){session_start();};

// If there is no username in cookies, send the user to login screen
if (!isset($_COOKIE['username'])) {
    header("location: $_SERVER[DOCUMENTROOT]/App/open.php", True);
};

// if there is a username stored in cookies but not the session
$count = 0;
while (!isset($_SESSION['username'])) {
    include_once "$_SERVER[DOCUMENTROOT]/PHP/data/getData.php";
    $count++;
    
    if ($count > 100) {
        header("location: $_SERVER[DOCUMENTROOT]/App/open.php", True);
    }
}



$username = $_SESSION['username'];

//if (count($calendars) > 0) {
if (isset($_SESSION['calendars']))  { 
    $calendars = $_SESSION['calendars'];
    
    // get all calendar names in array
    $calNames = [];
    foreach ($calendars as $cal) {
        array_push($calNames, $cal['StartDate'] . ' - ' . $cal['EndDate']);
    };
};



?>
<HTML>
    <head>
        <title>RCTL</title>
        
        <link href="/CSS/bootstrap.css" rel="stylesheet">
        <link href="/CSS/jquery-ui.css" rel="stylesheet">
        <link href="/CSS/calendar.css" rel="stylesheet">
        
    </head>
    <body>
        <div class="contentContainer">
            <div class="header">
                <div class="row">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav" style="width: 100%">
                                <div class="container" style="width: 100%">
                                    <ul class="pull-left">
                                        <li class="logo">LOGO</li>
                                        <li><a href="#">Calendar</a></li>
                                        <li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Logs<b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">ARC</a></li>
                                                <li><a href="#">Hangboard</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Stats<b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">ARC</a></li>
                                                <li><a href="#">Hangboard</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Other</a></li>
                                    </ul>
                                    <ul class="pull-right" style="display: inline-block">
                                        <li><a href="#" class="userInfo">Welcome, <?php echo $username; ?></a></li>
                                        <li><a href="#" class="logOut">Log Out</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="hangboardHeader">
                                <div class="hangboardPic_left">
                                    <img src="/Images/rpHangboardPic_left.jpg" />
                                </div>
                                <div class="hangboardPic_right">
                                    <img src="/Images/rpHangboardPic_right.jpg" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<!-- Add Calendar popup -->

            <div class="addCalPopup">
                <div class="row" style="width: 100%; right: 0px">
                    <div class="col-md-12" style="left: 5%; width: 100%">
                        <p class="exitAddCal" style="text-align: right; right: 3%; cursor: pointer; display: inline-block; position: absolute;">X</p>
                    </div>
                </div>
                <div class="addCalHeader">
                    <div class="row" style="width: 100%; text-align: center; margin: 0px;">
                        <h1 class="title">Create a Calendar</h1>
                    </div>
                </div>
                <div class="calOptionsContainer">
                    <div class="row newCalBuffer"></div>
                    <div class="row" style="width: 100%; text-align: center; margin: 0px; height: 10%;">
                        <div class="startDateContainer">
                            <p>Start Date: </p><input type="text" name="startDate" id="startDate" class="startDate"/>
                        </div>
                    </div>
                    <div class="row" style="width: 100%; text-align: center; margin: 0px; height: 10%;">
                        <div class="endDateContainer">
                            <p>End Date: </p><input type="text" name="endDate" id="endDate" />
                        </div>
                    </div>
                    <div class="row" style="width: 100%; text-align: center; margin: 0px; height: 20%;">
                        <div class="durationContainer">
                            <h2 style="width: 100%">Workout Duration: </h2>
                            <h3 style="width: 100%"> </h3>
                        </div>
                    </div>
                    <div class="selectWorkoutsContainer">

                        <select class="workoutsDrop" id="workoutsDrop">
                            <option value="" selected>-- Load Default Workouts --</option>
                            <option value="noneSelect">None</option>
                            <option value="beginnerSelect">Beginner</option>
                            <option value="intSelect">Intermediate</option>
                            <option value="advSelect">Advanced</option>
                            <option value="prevSelect">Previous</option>
                        </select>
                        
                    </div>
                    
                    <div class="createContainer">
                        <div class="createCal"><h1 class="go">Go</h1></div>
                    </div>
                </div>
            </div>
            
            
<!-- Calendar day popup -->
            
            <div class="calDayPopup">
                
                <div class="popupHeader">
                    <h1>Workouts</h1>
                    <h3 class="calDayTitle"></h3>
                </div>
                
                <!--
                <div class="row" style="width: 100%; right: 0px">
                    <div class="col-md-12" style="left: 5%; width: 100%">
                        <p class="exitCalDay" style="text-align: right; right: 3%; cursor: pointer; display: inline-block; position: absolute;">X</p>
                    </div>
                </div>
                -->
                
                <div class="workoutsContainer">
                    <div class="calDayWorkouts">
                    </div>
                </div>
                
                <div class="windowOptions">
                    
                    <div class="windowOption done">
                        <h2>Done</h2>
                    </div>

                </div>

            </div>
            
<!-- Add Arc -->

            <div class="addWorkoutPopup">
            </div>
            
<!-- Page Title -->            

            <div class="titleContainer">
                <div class="calendarTitle">
                    <div class="row">
                        <h1 class="title">Training Calendar</h1> 
                    </div>
                    <div class="row">
                        <div class="optionsContainer">
                            
                                <div class="optionsTitle">
                                    <p class="calendarOptionsButton"><span class="glyphicon glyphicon-chevron-right"></span>Calendar Options</p>
                                </div>
                                <div class="optionsBody">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary newCalButton">New</button>
                                        <button type="button" class="btn btn-primary calendarDateButton">Start Date</button>
                                        <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        View Previous <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <?php
                                                if (isset($calNames)) {
                                                    foreach ($calNames as $name) {
                                                        echo "<li><a href='#'>$name</a></li>";
                                                    };
                                                }
                                            ?>
                                        </ul>
                                        </div>
                                        <button type="button" class="btn btn-primary">Delete</button>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            

<!-- Calendar page content -->

            <div class="pagecontentContainer">
                
                <div class="row weekDays">
                        <div class="col-xs-4"></div>
                        <div class="col-xs-1" style="text-align: center; left: .25%">
                            <p>Sunday</p>
                        </div>
                        <div class="col-xs-1" style="text-align: center; left: .1%;">
                            <p>Monday</p>
                        </div>
                        <div class="col-xs-1" style="text-align: center">
                            <p>Tuesday</p>
                        </div>
                        <div class="col-xs-1" style="text-align: center; left: -.1%">
                            <p>Wednesday</p>
                        </div>
                        <div class="col-xs-1" style="text-align: center; left: -.15%">
                            <p>Thursday</p>
                        </div>
                        <div class="col-xs-1" style="text-align: center; left: -.25%">
                            <p>Friday</p>
                        </div>
                        <div class="col-xs-1" style="text-align: center; left: -.25%">
                            <p>Saturday</p>
                        </div>
                    </div>
                    
                        <?php
                            //if (count($calendars) > 0) {
                            if ((isset($calendars)) && (count($calendars) > 0)) {     
                                echo '<div class="calendarContainer full">';
                                
                                // run loadCalendar with a specific calendar loaded to the server
                                //$_SESSION['calendar'] = $calendars['calendar' . (count($calendars)-1)];
                                $_SESSION['calendar'] = end($calendars);
                                include_once "$_SERVER[DOCUMENT_ROOT]/PHP/calendar/loadCalendar.php";
                                
                                echo '</div>';
                            } else {
                                echo '<div class="calendarContainer empty">';
                            };
                        ?>
                        
                        <div class='emptyCal newCalButton'> 
                            <h1 style='margin-top: 10%'>You don't have any calendars</h1> 
                            <h3>Click here to create a new one!</h3> 
                        </div>

                </div>
            </div>               
        </div>
        
        <div class="bodyCover">
        </div>
        

        <!--
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        -->
        <script src="/JS/jquery-2.1.4.js"></script>
        <script src="/JS/jquery-ui.js"></script>
        <script src="/JS/jquery.cookie.js"></script>
        <script src="/JS/bootstrap.js"></script>
        <script src="/JS/calendar.js"></script>
        <script src="/JS/all.js"</script>
    </body>
</HTML>

<?php exit(); ?>