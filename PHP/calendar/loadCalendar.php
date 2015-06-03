<?php
    $calendar = $_SESSION['calendar'];
    $start = $calendar['StartDate'];
    $end = $calendar['EndDate'];
    
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
            <div class="col-xs-2"></div>
            <div class="col-xs-10">
                <div class="newDate"><h2>' . date('F', strtotime($start . " +". ($dayCount - $dayStart)  ." days")) . ', ' . date('Y', strtotime($start . " +". ($dayCount - $dayStart)  ." days")) . '</h2></div>
            </div>
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
                        <div class="col-xs-2"></div>
                        <div class="col-xs-10">
                            <div class="newDate"><h2>' . date('F', strtotime($start . " +". ($dayCount - $dayStart)  ." days")) . ', ' . date('Y', strtotime($start . " +". ($dayCount - $dayStart)  ." days")) . '</h2></div>
                        </div>';
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