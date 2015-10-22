<?php
if (!session_id()){session_start();};

function dateRange($start_date, $end_date, $date_check) {
  // Convert to timestamp
  $start_ts = strtotime($start_date);
  $end_ts = strtotime($end_date);
  $check_ts = strtotime($date_check);

  // Check that user date is between start & end
  return (($check_ts >= $start_ts) && ($check_ts <= $end_ts));
}

//include($_SERVER[DOCUMENT_ROOT] . "/PHP/data/getData.php");

// load calendar information
$calendar = $_SESSION['calendar'];
$start = $calendar['StartDate'];
$end = $calendar['EndDate'];

// set timezome
date_default_timezone_set('America/Denver');

// load all workout information
$arcs = $_SESSION['arc'];
$hangs = $_SESSION['hang'];
$campuss = $_SESSION['campus'];
$lbs = $_SESSION['limit'];
$lbcs = $_SESSION['lbc'];
$oms = $_SESSION['om'];
$others = $_SESSION['other'];

// get workouts in the calendar
$curWorkouts = array(
                    "curArcs"       => array(),
                    "curHangs"      => array(),
                    "curCampuss"    => array(),
                    "curLbs"        => array(),
                    "curLbcs"       => array(),
                    "curOms"        => array(),
                    "curOthers"     => array(),
                     );

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

$lbCount = 0;
$lbDone = False;

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
$done = 0;
while ($done < count($curWorkouts)) {
    
    // check arcs
    if (($i < count($arcs)) && ($arcDone == False)) {
        $checkDate = $arcs['arc' . $i]['date'];
        
        if (dateRange($start, $end, $checkDate)) {
            $curWorkouts["curArcs"][$arcCount] = $arcs['arc' . $i];
            $arcCount++;
        }
    } elseif ($arcDone == False) {
        $arcDone = True;
        $done++;
        //echo 'arc';
    }
    
    // check Hangs
    if (($i < count($hangs)) && ($hangDone == False)) {
        $checkDate = $hangs['hang' . $i]['date'];
        //print_r($hangs[$i]);
        
        if (dateRange($start, $end, $checkDate)) {
            $curWorkouts["curHangs"][$hangCount] = $hangs['hang' . $i];
            $hangCount++;
        }
    } elseif ($hangDone == False) {
        $hangDone = True;
        $done++;
        //echo 'hang';
    }       
    
    // check Campus
    if (($i < count($campuss)) && ($campusDone == False)) {
        $checkDate = $campuss['campus' . $i]['date'];
        
        if (dateRange($start, $end, $checkDate)) {
            $curWorkouts["curCampuss"][$campusCount] = $campuss['campus' . $i];
            $campusCount++;
            
        }
    } elseif ($campusDone == False) {
        $campusDone = True;
        $done++;
        //echo 'campus';
    } 
    
    // check OM
    if (($i < count($oms)) && ($omDone == False)) {
        $checkDate = $oms['om' . $i]['date'];
        
        if (dateRange($start, $end, $checkDate)) {
            $curWorkouts["curOms"][$omCount] = $oms['om' . $i];
            $omCount++;
        }
    } elseif ($omDone == False) {
        $omDone = True;
        $done++;
        //echo 'om';
    }
    
    
    // check Limit Boulders
    if (($i < count($lbs)) && ($lbDone == False)) {
        
        $checkDate = $lbs['limit' . $i]['date'];

       if (dateRange($start, $end, $checkDate)) {
            $curWorkouts["curLbs"][$lbCount] = $lbs['limit' . $i];
            $lbCount++;
        }
        
    } elseif ($lbDone == False) {
        $lbDone = True;
        $done++;
        
        //echo 'LB';
    }
    
    
    // check LBCs
    if (($i < count($lbcs)) && ($lbcDone == False)) {
        $checkDate = $lbs['lbc' . $i]['date'];
        
        if (dateRange($start, $end, $checkDate)) {
            $curWorkouts["curLBCs"][$omCount] = $lbcs['lbc' . $i];
            $lbcCount++;
        }
    } elseif ($lbcDone == False) {
        $lbcDone = True;
        $done++;
        //echo 'lbc';
    }  
    
    // Check Others
    if (($i < count($others)) && ($otherDone == False)) {
        $checkDate = $others['other' . $i]['date'];
        
        if (dateRange($start, $end, $checkDate)) {
            $curWorkouts["curOthers"][$otherCount] = $others['other' . $i];
            $otherCount++;
        }
    } elseif ($otherDone == False) {
        $otherDone = True;
        $done++;
        //echo 'other';
    }
    
    $i++;
}

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

$startDate = date('Y/m/d', strtotime($start));
$endDate = date('m/d/Y', strtotime($end));

$monthCount = abs(date('m', strtotime($end)) - date('m', strtotime($start)));

list($prevYear, $prevMonth, $prevDay) = split('/', $startDate);

// account for the date object having a zero based month
if (date('m', strtotime($start . " -" . $dayStart . " days")) != date('m', strtotime($start))) {
    $prevMonth = $prevMonth - 1;
} else {
    
}

// we will count this up as we have to repeat week numbers
$repeat = 0;
$dayCount = 0;

// make space
echo '<div class="row calSpacer">
        <div class="col-xs-12"><p> </p></div>
      </div>';

echo '<div class="row calRow">
            <div class="newDate"><h2>' . date('F', strtotime($start . " +". ($dayCount - $dayStart)  ." days")) . ', ' . date('Y', strtotime($start . " +". ($dayCount - $dayStart)  ." days")) . '</h2></div>
       </div>';

//for ($i = 1; $i <= $calendar['weeks'] + $monthCount + 1; $i++) {
  for ($i = 1; $i <= $calendar['weeks'] + $repeat; $i++) {
    
    $date = date('m/d/Y', strtotime($start . " +". ($dayCount - $dayStart) ." days"));
    list($month, $day, $year) = split('/', $date);
    
    //echo 'MONTH: ' . $month;
    //echo 'PREVMONTH: ' . $prevMonth;
    if ($month == $prevMonth) {
        echo '<div class="row calRow">
                <div class="col-xs-2"></div>
                <div class="col-xs-2">
                    <h3>Week ' . ($i - $repeat) . '</h3>
                </div>';
                
    } else {
        echo "<div>";
        $repeat++;
    }

    // loop through days of the week
    for ($j = 1; $j <= 7; $j++) {
        
        $date = date('m/d/Y', strtotime($start . " +". ($dayCount - $dayStart) ." days"));
        list($month, $day, $year) = split('/', $date);
        
        if ($month != $prevMonth) {   // We are in a new month!
            
            //echo "MONTH: " . $month;
            //echo "PREV: " . $prevMonth;
            
            echo "</div>";            // end current row     
               
            // make space
            echo '<div class="row calSpacer">
                    <div class="col-xs-12"><p> </p></div>
                  </div>';   
                            
            // print new date
            echo '<div class="row calRow">
                        <div class="newDate"><h2>' . date('F', strtotime($start . " +". ($dayCount - $dayStart)  ." days")) . ', ' . date('Y', strtotime($start . " +". ($dayCount - $dayStart)  ." days")) . '</h2></div>
                  ';
            $prevMonth = $month;      // setup next previous month
            $repeat++;                     // Have next week print the same number
            $lastJ = $j;              // So we know which day of the week to start with in the next row
            
            $makeSpace = false;
            
            break;
        

            
        } else if ($lastJ > $j) {
            
            echo '<div class="col-xs-1" style="">
                    <div class="calDay calDayEmpty day' . $j . 'week' . $i . '">
                    </div>
                 </div>';
            
            
            
        } else {

            echo '<div class="col-xs-1" style="">
                    <div class="calDay day' . $j . 'week' . ($i - $repeat) . '">
                        <div class="dayInfo" style="">
                            <p>' . $day . '</p>
                            <p class="date" style="display: none">' . $date . '</p>
                        </div>
                        <div class="workoutTitle" style="">';
            
            // print the workouts for the day
            $dayWorkouts = array();
            $workoutKeys = array_keys($curWorkouts);
            $workoutCount = 0;
            foreach ($workoutKeys as $workoutType) {
                $workoutsArr = $curWorkouts[$workoutType];
                foreach($workoutsArr as $workout) {
                    //print_r($workout);
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
                            case "curLbs":
                                $workoutName = "Limit Bouldering";
                                break;
                            case "curLBCs":
                                $workoutName = "LBC";
                                break;
                            case "curOthers":
                                $workoutName = "Others";
                                break;
                        }
                        
                        if (!in_array($workoutName, $dayWorkouts)) {
                            
                            echo '<p class="workoutName">' . $workoutName . '</p>';
                            
                            $dayWorkouts[$workoutCount] = $workoutName;
                            $workoutCount++;
                        }
                        
                        break;
                    }
                            
                    
                }
            }
            echo       '</div>
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
           
           /*      
            if ($date == $endDate) {
                break;
            }
             */
           
           $makeSpace = true;
                 
            $lastJ = 0;
            $dayCount++;
             
        }
        
        if (($date == $endDate) && ($makeSpace)) {
            break;
        }
             
    }

    // close the row
    echo '</div>';
    
    // make space between rows
    if ($makeSpace) {
        echo '<div class="row calSpacer">
                <div class="col-xs-12"><p> </p></div>
              </div>';
    }
    
    if (($date == $endDate) && ($makeSpace)) {
        break;
    }
    
    //echo '<div class="row calSpacer"></div>';
    
}
echo '</div>';
  
  
?>