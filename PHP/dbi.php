<?php
    // get session info
    if (!session_id()){session_start();};
        
    // functions
    function submit_arc($user_id, $arcs, $conn) {
        
        $deleted = FALSE;
        
        foreach ($arcs as $arc) {
            
            echo "<br><br>arc: " . $arc . "<br><br>";
            
            $arc = explode('!%$%!', $arc);
            
            for ($i = 0; $i < count($arc); $i++) {
                if (empty($arc[$i])) {
                    $arc[$i] = " ";
                }
            }
            
            if ($deleted == FALSE) {
                
                // delete all arcs with this date from DB
                $sql = "DELETE FROM arc where date='$arc[0]'";
                if ($conn->query($sql) === TRUE) {
                    echo "Old records deleted";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                
                // removes all arcs from the session
                foreach (array_keys($_SESSION['arc']) as $arc_tmp) {
                    if ($_SESSION['arc'][$arc_tmp]['date'] == $arc[0]) {
                        unset($_SESSION['arc'][$arc_tmp]);
                    }
                }
                
                $deleted = TRUE;
            }
            
            echo "Should be empty arc: <br>";
            print_r($_SESSION['arc']);
            echo "<br><br>";
            
            # create arc hash that we can add to $_SESSION
            $fields = ["date",
                       "location",
                       "duration",
                       "comments",
                       "terrain",
                       "difficulty",
                       "daynum"];
            $fields = array_flip($fields);
            $arc_hash = array();
            foreach (array_keys($fields) as $field) {
                $arc_hash[$field] = $arc[$fields[$field]];
            }

            $sql = "INSERT INTO arc (UserID,
                                     date,
                                     location,
                                     duration,
                                     comments,
                                     terrain,
                                     difficulty,
                                     daynum)
                    VALUES ($user_id,
                            '" . $arc_hash['date'] . "',
                            '" . $arc_hash['location'] . "',
                            '" . $arc_hash['duration'] . "',
                            '" . $arc_hash['comments'] . "',
                            '" . $arc_hash['terrain'] . "',
                            '" . $arc_hash['difficulty'] . "',
                             " . $arc_hash['daynum'] . ")";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
    
            $arc_num = count($_SESSION['arc']);
            $_SESSION['arc']['arc' . $arc_num] = $arc_hash;
        }
        
        echo "SESSION OUT: <br>";
        print_r($_SESSION['arc']);
        
    }


    /***********************************************************************/
    $user_id = $_SESSION['id'];
    
        
    // connect to database
    include_once "$_SERVER[DOCUMENT_ROOT]/PHP/config.php";
    
    // seperate workouts
    echo "WORKOUTS: " . $_POST['workouts'] . "<br><br>";
    $workouts = explode('%!$!%', $_POST['workouts']);
    $type = $_POST['type'];
    
    if ($type == 'arc') {
        submit_arc($user_id, $workouts, $conn);
        
    }

    $conn->close;
    exit();

