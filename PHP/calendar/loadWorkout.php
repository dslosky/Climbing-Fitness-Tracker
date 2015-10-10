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


// set timezome
date_default_timezone_set('America/Denver');

$workoutType = strtolower($_POST['workout']);

if ($workoutType === 'arc') {
    $workouts = $_SESSION['arc'];
} else if ($workoutType === 'om') {
    $workouts = $_SESSION['om'];
}

$date = $_POST['date'];

$curWorkouts = array();

$count = 0;
foreach ($workouts as $workout) {
    
    $checkDate = $workout['date'];
    
    if (sameDate($date, $checkDate)) {
        
        $curWorkouts[$count] = $workout;
        $count++;
    }
    
}

                 if ($workoutType === 'arc') {
                    make_arc_form($curWorkouts, $date);
                
                 } elseif ($workoutType === 'om') {
                    make_om_form($curWorkouts, $date);
                    
                 } elseif ($workoutType === 'hangboard') {
                    echo '<h1>Add Hangboard</h1>';
                 } elseif ($workoutType === 'limit') {
                    echo '<h1>Add Limit Boulder</h1>';
                 } elseif ($workoutType === 'bl') {
                    echo '<h1>Add Boulder Ladder</h1>';
                 } elseif ($workoutType === 'other') {
                    echo '<h1>Add Other</h1>';
                 }

window_options();

////////////////////// Functions ///////////////////////////

function make_arc_form($curWorkouts, $date) {

    echo '<div class="popupHeader ARC">
               <h1>Add ARC</h1>
          </div>
                    
                    <div class="arcInfoContainer">
                        <div class="workoutOption arcDate">
                            <label for="Date">Date: </label>
                            <p class="date">' . $date . '</p>
                        </div>
    
                        <div class="workoutOption arcLoc">
                            <label for="Location">Location: </label>
                            <input class="location" name="Location" type="text" value="' . $curWorkouts[0]['location'] . '"/>
                        </div>
                        
                        <div class="workoutOption arcDiff">
                            <label for="Difficulty">Difficulty: </label>
                            <input class="difficulty" name="Difficulty" type="text" value="' . $curWorkouts[0]['difficulty'] . '"/>
                        </div>
                        
                        <div class="workoutOption arcDesc double">
                            <label for="Description">Description of Terrain: </label>
                            <textarea class="desc" name="Description" placeholder="Enter your description here">' . $curWorkouts[0]['description'] . '</textarea>
                        </div>
                        
                        <div class="arcSetsHead workoutOption double">
                            <label>Sets:</label>
                            <p class="col-1" style="">Set:</p>
                            <p class="col-2" style="">Duration:</p>
                            <p class="col-3" style="">Comments:</p>
                        </div>
                        
                        <div class="arcSets Sets">';
                        
                        $setNum = 1;
                        foreach ($curWorkouts as $workout) {
                            
                            echo '<div class="set"> 
                                    <p class="setNum col-1">' . $setNum . '</p>
                                    <input class="duration col-2" name="duration" value="' . $workout['duration'] . '"/>
                                    <input class="comments col-3" name="comments" value="' . $workout['comments'] . '"/>
                                    <div class="deleteSet"><p>delete</p></div> 
                                </div>';
                                
                            $setNum++;
                        }
                        
    echo               '</div>
                        
                        <div class="addSet">
                            <h3>Add Set</h3>
                        </div>
                        
                    </div>';
    
}

function make_om_form($curWorkouts, $date) {
//<input class="time" name="Time" type="text" value="' . $curWorkouts[0]['total_time'] . '"/>
    echo '<div class="popupHeader OM">
               <h1>Add Outdoor Mileage</h1>
          </div>
                    
                    <div class="omInfoContainer">
                        <div class="workoutOption omDate">
                            <label for="Date">Date: </label>
                            <p class="date">' . $date . '</p>
                        </div>
    
                        <div class="workoutOption omLoc">
                            <label for="crag">Crag: </label>
                            <input class="crag" name="crag" type="text" value="' . $curWorkouts[0]['crag'] . '"/>
                        </div>
                        
                        <div class="workoutOption omTime">
                            <label for="Location">Total Time: </label>
                            <select class="total_time">';
                        
                        // create the dropdown menu for total time with the correct
                        // option selected
                        for ($i = 0; $i < 200; $i = $i + 5) {
                            if ($i == $curWorkouts[0]['total_time']) {
                                echo '<option value=' . $i . ' selected="true">' . $i . '</option>';
                            } else {
                                echo '<option value=' . $i . '>' . $i . '</option>';
                            }
                        }
                            
                        
    echo                   '</select>
                            <label for="time" style="margin-left: 10px">minutes</label>
                        </div>
                        
                        <div class="workoutOption omDesc double">
                            <label for="Description">Description of Terrain: </label>
                            <textarea class="desc" name="Description" placeholder="Enter your description here">' . $curWorkouts[0]['description'] . '</textarea>
                        </div>
                        
                        <div class="workoutOption omComments double">
                            <label for="Description">Comments: </label>
                            <textarea class="comments" name="Comments" placeholder="Comments on the climbing">' . $curWorkouts[0]['comments'] . '</textarea>
                        </div>
                        
                        <div class="omSetsHead workoutOption double">
                            <label>Sets:</label>
                            <p class="col-1" style="">Set:</p>
                            <p class="col-2" style="">Route Name:</p>
                            <p class="col-3" style="">Difficulty:</p>
                        </div>
                        
                        <div class="omSets Sets">';
                        
                        $setNum = 1;
                        foreach ($curWorkouts as $workout) {
                            
                            echo '<div class="set"> 
                                    <p class="setNum col-1">' . $setNum . '</p>
                                    <input class="route col-2" name="route" value="' . $workout['route'] . '"/>
                                    <select class="rating col-3">';
                                    /*
                                    <input class="rating col-3" name="rating" value="' . $workout['rating'] . '"/>
                                    */
                            
                            // make dropdown menu for om rating
                            $ratings = ['5.5', '5.6', '5.7', '5.8',
                                          '5.9', '5.10a','5.10b', '5.10c',
                                          '5.10d', '5.11a', '5.11b', '5.11c',
                                          '5.11d', '5.12a', '5.12b', '5.12c',
                                          '5.12d', '5.13a', '5.13b', '5.13c',
                                          '5.13d', '5.14a', '5.14b', '5.14c'];
                            foreach ($ratings as $rating) {
                                if ($rating === $workout['rating']) {
                                    echo '<option value=' . $rating . ' selected="true">' . $rating . '</option>';
                                } else {
                                    echo '<option value=' . $rating . '>' . $rating . '</option>';
                                }
                            }
                            
                            
                            echo   '</select>
                                    <div class="deleteSet"><p>delete</p></div> 
                                </div>';
                                
                            $setNum++;
                        }
                        
    echo               '</div>
                        
                        <div class="addSet">
                            <h3>Add Set</h3>
                        </div>
                        
                    </div>';
    
}

function window_options() {
echo '          <div class="windowOptions">
                    
                    <div class="windowOption save">
                        <h3>Save</h3>
                    </div>
                    
                    <div class="windowOption cancel">
                        <h3>Cancel</h3>
                    </div>

                </div>';
}

?>