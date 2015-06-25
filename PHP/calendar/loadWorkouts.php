<?php if (!session_id()){session_start();}; ?>
<?php
    function dateRange($start_date, $end_date, $date_check)
    {
      // Convert to timestamp
      $start_ts = strtotime($start_date);
      $end_ts = strtotime($end_date);
      $check_ts = strtotime($date_check);
    
      // Check that user date is between start & end
      return (($check_ts >= $start_ts) && ($check_ts <= $end_ts));
    }
    
    function sameDate($date1, $date2) {
        // convert to timestamp
        $date1_ts = strtotime($date1);
        $date2_ts = strtotime($date2);
        
        return ($date1_ts == $date2_ts);
    }
?>
<?php
if (!session_id()){session_start();};

    // load calendar information
    $calendar = $_SESSION['calendar'];
    $start = $calendar['StartDate'];
    $end = $calendar['EndDate'];
    
    //echo $start;
    
    $date = $_POST['date'];
    
    //echo $currentDate;
    
    // set timezome
    date_default_timezone_set('America/Denver');
    
    // load all workout information
    $arcs = $_SESSION['arc'];
    $hangs = $_SESSION['hang'];
    $campuss = $_SESSION['campus'];
    $lbcs = $_SESSION['lbc'];
    $oms = $_SESSION['om'];
    $others = $_SESSION['other'];
    
    // get workouts in the calendar
    $curWorkouts = array(
                        "curArcs"       => array(),
                        "curHangs"      => array(),
                        "curCampuss"    => array(),
                        "curOms"        => array(),
                        "curOthers"     => array(),
                         );
    
    /*
    $dayWorkouts = array(
                        "curArcs"       => array(),
                        "curHangs"      => array(),
                        "curCampuss"    => array(),
                        "curOms"        => array(),
                        "curOthers"     => array(),
                         );
    */
    //$calStart = strtotime($start);
    //$calEnd = strtotime($end);
    
    $arcCount = 0;
    $arcDone = False;
    
    $hangCount = 0;
    $hangDone = False;
    
    $campusCount = 0;
    $campusDone = False;
    
    $omCount = 0;
    $omDone = False;
    
    $lbcCount = 0;
    $lbcDone = False;
    
    $otherCount = 0;
    $otherDone = False;
    
    
    //debugging
    /*
    echo $calStart;
    echo $calEnd;
    */
    
    $i = 0;
    while ($done < count($curWorkouts)) {
        
        // check arcs
        if (($i < count($arcs)) && ($arcDone == False)) {
            $checkDate = $arcs['arc' . $i]['date'];
            
            //debugging
            /* 
            echo '<br><br>ARCS<br>';
            echo $checkDate;
            echo '<br>' . dateRange($calStart, $calEnd, $checkDate);
            echo '<br><br>';
            */
            
            if (sameDate($date, $checkDate)) {
                $curWorkouts["curArcs"][$arcCount] = $arcs['arc' . $i];
                $arcCount++;
            }
        } else {
            $arcDone = True;
            $done++;
        }
        
        // check Hangs
        if (($i < count($hangs)) && $hangDone == False) {
            $checkDate = $hangs['hang' . $i]['date'];
            //print_r($hangs[$i]);
            
            //debugging
            //echo "DATE: " . $date . "<br>";
            //echo "CHECK: " . $checkDate . "<br>";
            
            if (sameDate($date, $checkDate)) {
                $curWorkouts["curHangs"][$hangCount] = $hangs['hang' . $i];
                $hangCount++;
            }
        } else {
            $hangDone = True;
            $done++;
        }       
        
        // check Campus
        if (($i < count($campuss)) && $campusDone == False) {
            $checkDate = $campuss['campus' . $i]['date'];
            
            if (sameDate($date, $checkDate)) {
                $curWorkouts["curCampuss"][$campusCount] = $campuss['campus' . $i];
                $campusCount++;
                
            }
        } else {
            $campusDone = True;
            $done++;
        } 
        
        // check OM
        if (($i < count($oms)) && $omDone == False) {
            $checkDate = $oms['om' . $i]['date'];
            
           if (sameDate($date, $checkDate)) {
                $curWorkouts["curOms"][$omCount] = $oms['om' . $i];
                $omCount++;
            }
        } else {
            $omDone = True;
            $done++;
        }
        
        // check LBCs
        if (($i < count($lbcs)) && $lbcDone == False) {
            $checkDate = $lbs['lbc' . $i]['date'];
            
            if (sameDate($date, $checkDate)) {
                $curWorkouts["curLBCs"][$omCount] = $lbcs['lbc' . $i];
                $lbcCount++;
            }
        } else {
            $omDone = True;
            $done++;
        }  
        
        // Check Others
        if (($i < count($others)) && $otherDone == False) {
            $checkDate = $others['other' . $i]['date'];
            
            if (sameDate($date, $checkDate)) {
                $curWorkouts["curOthers"][$otherCount] = $others['other' . $i];
                $otherCount++;
            }
        } else {
            $otherDone = True;
            $done++;
        }      
        
        
        $i++;
    }
    
    
    // debugging
    //print_r($curWorkouts);
    //echo "<br><br>";
    // print the workouts for the day
    $dayWorkouts = array();
    $workoutKeys = array_keys($curWorkouts);
    $workoutCount = 0;
    foreach ($workoutKeys as $workoutType) {
        $workoutsArr = $curWorkouts[$workoutType];
        foreach($workoutsArr as $workout) {
            
            if (strtotime($workout['date']) == strtotime($date)) {
                // echo key($curWorkouts);
                switch ($workoutType) {
                    case "curArcs":
                        $workoutName = "ARC";
                        break;
                    case "curHangs":
                        $workoutName = "Hangboard";
                        break;
                    case "curOms":
                        $workoutName = "OM";
                        break;
                    case "curCampuss":
                        $workoutName = "Campus";
                        break;
                    case "curLBCs":
                        $workoutName = "LBC";
                        break;
                    case "curOthers":
                        $workoutName = "Others";
                        break;
                }
                
                //echo $workoutName;
                
                if (!in_array($workoutName, $dayWorkouts)) {
                    
                    // echo '<p>' . $workoutName . '</p>';
                    
                    $dayWorkouts[$workoutCount] = $workoutName;
                    $workoutCount++;
                }
                
                break;
            }
                    
            
        }
    }
    
    //print_r($dayWorkouts);
    
    $workoutTypes = array("ARC", "Hangboard", "OM", "LBC", "Campus", "Others");

    foreach ($workoutTypes as $type) {
        if (in_array($type, $dayWorkouts)) {
            echo    "<div class='addWorkout added " . $type . "'>
                        <h3>" . $type . "</h3>
                    </div>";
        }

    }
    
    foreach ($workoutTypes as $type) {
        
        if (!in_array($type, $dayWorkouts)) {
            echo    "<div class='addWorkout notAdded " . $type . "'>
                        <h3>" . "Add " . $type . "</h3>
                    </div>";
        }
    }  
                
                
?>