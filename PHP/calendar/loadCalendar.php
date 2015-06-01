<?php
    $calendar = $_SESSION['calendar'];
    $start = $calendar['StartDate'];
    
    //echo $start;
    
    //$date = new DateTime($start);
    //$date = date_create("" . $start . "");
    /*
    try {
        $date = new DateTime($start);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit(1);
    }
    */
    
    date_default_timezone_set('America/Denver');
    
    switch (date('l', strtotime($start))) {
    
        case "Monday":
            $dayStart = 1;
            break;
        case "Tuesday":
            $dayStart = 2;
            break;
        case "Wednesday":
            $dayStart = 3;
            break;
        case "Thursday":
            $dayStart = 4;
            break;
        case "Friday":
            $dayStart = 5;
            break;
        case "Saturday":
            $dayStart = 6;
            break;
        case "Sunday":
            $dayStart = 0;
            break;
    }
    
    echo '<div class="scrollBox">';
    
    for ($i = 1; $i <= $calendar['weeks']; $i++) {
        echo '<div class="row calRow">
                <div class="col-xs-2"></div>
                <div class="col-xs-2">
                    <h3>Week ' . $i . '</h3>
                </div>';
    
        for ($j = 1; $j <= 7; $j++) {
            
            $date = date('m/d/Y', strtotime($start . " +". ($j + (7*$i - 7) - 1 - $dayStart) ." days"));
    
    
            echo '<div class="col-xs-1" style="">
                    <div class="calDay day' . $j . 'week' . $i . '">
                        <div class="dayInfo" style="text-align: center; font-weight: bold; font-size: .85em">
                            <p>' . $date . '</p>
                        </div>
                        <div class="workoutTitle" style="opacity: 0;">
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
                 
            //$date->add(new DateInterval('P1D'));
        }
    
        echo '</div>';
        echo '<div class="row calSpacer">
                <div class="col-xs-12"><p> </p></div>
              </div>';
        
        //echo '<div class="row calSpacer"></div>';
        
    }
    echo '</div>';
?>