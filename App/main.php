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
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-5">
                            <h1 class="title">Training Calendar</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="optionsContainer">

            </div>

            <div class="pagecontentContainer">

                <div class="calendarContainer">
                    <?php
                        for ($i = 1; $i <= 14; $i++) {
                            echo '<div class="row calSpacer"></div>';
                            echo '<div class="row calRow">
                                    <div class="col-xs-2"></div>
                                    <div class="col-xs-2">
                                        <h3>Week ' . $i . '</h3>
                                    </div>';

                            for ($j = 1; $j <= 7; $j++) {

                                echo '<div class="col-xs-1">
                                        <div class="calDay" id="day' . $j . 'week' . $i . '">
                                            <div class="workoutTitle">
                                                <h3>Workout</h3>
                                            </div>
                                            <div class=dayDate>
                                            </div>
                                            <div class="dayInfo">
                                                <p>Info</p>
                                            </div>
                                        </div>
                                     </div>';
                            }

                            echo '</div>';
                            echo '<div class="row calSpacer">
                                    <div class="col-xs-12"><p> </p></div>
                                  </div>';

                        }
                    ?>
                </div>
            </div>
        </div>               
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="/JS/jquery-ui.js"></script>
        <script src="/JS/bootstrap.js"></script>
        <script src="/JS/App.js"></script>
    </body>
</HTML>