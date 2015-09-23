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

$workoutType = $_POST['workout'];

if ($workoutType == 'arc') {
    $workouts = $_SESSION['arc'];
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

echo '<div class="popupHeader ARC">';

                 if ($workoutType=='arc') {
                    echo '<h1>Add ARC</h1>';
                 } elseif ($workoutType=='om') {
                    echo '<h1>Add OM</h1>';
                 } elseif ($workoutType=='hangboard') {
                    echo '<h1>Add Hangboard</h1>';
                 } elseif ($workoutType=='limit') {
                    echo '<h1>Add Limit Boulder</h1>';
                 } elseif ($workoutType=='bl') {
                    echo '<h1>Add Boulder Ladder</h1>';
                 } elseif ($workoutType=='other') {
                    echo '<h1>Add Other</h1>';
                 }
                 
echo           '</div>
                
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
                    
                    <div class="arcSets">';
                    
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
                    
                    <!--
                    <div class="workoutOption arcDate">
                        <label for="Date">Date: </label>
                    </div>
                    
                    <div class="workoutOption arcDate">
                        <label for="Date">Date: </label>
                        <input class="date" name="Date" type="text"/>
                    </div>
                    -->
                </div>
                
                <div class="windowOptions">
                    
                    <div class="windowOption save">
                        <h3>Save</h3>
                    </div>
                    
                    <div class="windowOption cancel">
                        <h3>Cancel</h3>
                    </div>

                </div>';

?>