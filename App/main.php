<?php

/*
 * To change this template use Tools | Templates.
 */
?>

<HTML>
    <head>
        <title>RCTL</title>
        
        <link href="/CSS/bootstrap.css" rel="stylesheet">
        <link href="/CSS/jquery-ui.css" rel="stylesheet">
        <link href="/CSS/main.css" rel="stylesheet">
        
    </head>
    <body>
        
        <!----------------------------- Log in window ------------------------------ -->
        <div class="loginBox">
            <nav class="main-nav">
                <ul>
                    <!-- all your main menu links here -->
                    <li><a class="cd-signin" href="#0">Sign in</a></li>
                    <li><a class="cd-signup" href="#0">Sign up</a></li>
                </ul>
            </nav>
            
            
            
        </div>
        <!-- ----------------------------------------------------------------------- -->
        
        <div class="contentContainer">
            <div class="header">
                <div class="row">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="nav">
                                <div class="container">
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
                                        <li><a href="#">RCTM Page</a></li>
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
                                            Load Workouts <span class="caret"></span></button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li class="emptyClick"><a href="#">Empty</a></li>
                                                <li class="beginnerClick"><a href="#">Beginner</a></li>
                                                <li class="intermediateClick"><a href="#">Intermediate</a></li>
                                                <li class="advancedClick"><a href="#">Advanced</a></li>
                                                <li class="previousClick"><a href="#">Previous</a></li>
                                                </ul>
                                        </div>
                                        <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        View Previous <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Date1</a></li>
                                            <li><a href="#">Date2</a></li>
                                        </ul>
                                        </div>
                                        <button type="button" class="btn btn-primary">Delete</button>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            



            <div class="pagecontentContainer">
                
                <div class="row weekDays">
                        <div class="col-xs-4"></div>
                        <div class="col-xs-1" style="left: 1.2%">
                            <p>Sunday</p>
                        </div>
                        <div class="col-xs-1" style="left: 1.2%">
                            <p>Monday</p>
                        </div>
                        <div class="col-xs-1" style="left: .8%">
                            <p>Tuesday</p>
                        </div>
                        <div class="col-xs-1" style="left: 0%">
                            <p>Wednesday</p>
                        </div>
                        <div class="col-xs-1" style="left: .3%">
                            <p>Thursday</p>
                        </div>
                        <div class="col-xs-1" style="left: 1%">
                            <p>Friday</p>
                        </div>
                        <div class="col-xs-1" style="left: .3%">
                            <p>Saturday</p>
                        </div>
                    </div>
                
                <div class="scrollBox">
                    
                    <div class="calendarContainer">
                        <!--
                        <?php
                            for ($i = 1; $i <= 14; $i++) {
                                echo '<div class="row calRow">
                                        <div class="col-xs-2"></div>
                                        <div class="col-xs-2">
                                            <h3>Week ' . $i . '</h3>
                                        </div>';

                                for ($j = 1; $j <= 7; $j++) {

                                    echo '<div class="col-xs-1">
                                            <div class="calDay day' . $j . 'week' . $i . '">
                                                <div class="dayInfo">
                                                    <p>date</p>
                                                </div>
                                                <div class="workoutTitle">
                                                    <h3>Workout</h3>
                                                </div>
                                                <div class=dayDate>
                                                </div>
                                                <div class="caldayGradbottom">
                                                </div>
                                                <div class="caldayGradtop">
                                                </div>
                                                <div class="caldayGradleft">
                                                </div>
                                                <div class="caldayGradright">
                                                </div>
                                            </div>
                                         </div>';
                                }

                                echo '</div>';
                                echo '<div class="row calSpacer">
                                        <div class="col-xs-12"><p> </p></div>
                                      </div>';
                                
                                echo '<div class="row calSpacer"></div>';

                            }
                        ?>
-->
                    </div>
                </div>
            </div>               
        </div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="/JS/jquery-ui.js"></script>
        <script src="/JS/bootstrap.js"></script>
        <script src="/JS/App.js"></script>
    </body>
</HTML>