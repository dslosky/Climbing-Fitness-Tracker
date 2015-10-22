<?php
    // get session info
    if (!session_id()){session_start();};
        
    // functions
    function delete_workout($type, $date, $conn) {
        if ($type === 'arc') {
            // delete from DB
            $sql = "DELETE FROM arc where date='" .$date . "'";
                if ($conn->query($sql) === TRUE) {
                    echo "Old records deleted <br>";
                    echo $sql;
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                
            // removes all arcs from the session
            foreach (array_keys($_SESSION['arc']) as $arc_tmp) {
                if ($_SESSION['arc'][$arc_tmp]['date'] === $date) {
                    unset($_SESSION['arc'][$arc_tmp]);
                }
            }
        } else if ($type === 'om') {
            $sql = "DELETE FROM om where date='" . $date . "'";
            if ($conn->query($sql) === TRUE) {
                echo "Old records deleted";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
            // removes all OMs from the session
            foreach (array_keys($_SESSION['om']) as $om_tmp) {
                if ($_SESSION['om'][$om_tmp]['date'] === $date) {
                    unset($_SESSION['om'][$om_tmp]);
                }
            }
        } else if ($type === 'hangboard') {
            $sql = "DELETE FROM arc where date='" . $date . "'";
            if ($conn->query($sql) === TRUE) {
                echo "Old records deleted";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
            // removes all arcs from the session
            foreach (array_keys($_SESSION['hang']) as $hang_tmp) {
                if ($_SESSION['hang'][$hang_tmp]['date'] === $date) {
                    unset($_SESSION['hang'][$hang_tmp]);
                }
            }
        } else if ($type === 'limit_bouldering') {
            $sql = "DELETE FROM limitboulder where date='" . $date . "'";
            if ($conn->query($sql) === TRUE) {
                echo "Old records deleted";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
            // removes all arcs from the session
            foreach (array_keys($_SESSION['limit']) as $lb_tmp) {
                if ($_SESSION['limit'][$lb_tmp]['date'] === $date) {
                    unset($_SESSION['limit'][$lb_tmp]);
                }
            }
        }
    }
    
    
    ////////////////// SUBMIT FUNCTIONS ////////////////////
    
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
                    if ($_SESSION['arc'][$arc_tmp]['date'] === $arc[0]) {
                        unset($_SESSION['arc'][$arc_tmp]);
                    }
                }
                
                $deleted = TRUE;
            }
            
            # create arc hash that we can add to $_SESSION
            $fields = ["date",
                       "location",
                       "duration",
                       "comments",
                       "terrain",
                       "difficulty",
                       "setnum"];
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
                                     setnum)
                    VALUES ($user_id,
                            '" . $arc_hash['date'] . "',
                            '" . $arc_hash['location'] . "',
                            '" . $arc_hash['duration'] . "',
                            '" . $arc_hash['comments'] . "',
                            '" . $arc_hash['terrain'] . "',
                            '" . $arc_hash['difficulty'] . "',
                             " . $arc_hash['setnum'] . ")";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
    
            $arc_num = count($_SESSION['arc']);
            $_SESSION['arc']['arc' . $arc_num] = $arc_hash;
        }   
    }
    
    function submit_om($user_id, $oms, $conn) {
        
        echo 'OMS in: ';
        print_r($oms);
        echo '<br><br>';
        
        $deleted = FALSE;
        
        foreach ($oms as $om) {
            
            //echo "<br><br>arc: " . $arc . "<br><br>";
            
            $om = explode('!%$%!', $om);
            
            for ($i = 0; $i < count($om); $i++) {
                if (empty($om[$i])) {
                    $om[$i] = " ";
                }
            }
            
            if ($deleted == FALSE) {
                
                // delete all OMs with this date from DB
                $sql = "DELETE FROM om where date='" . $om[0] . "'";
                if ($conn->query($sql) === TRUE) {
                    echo "Old records deleted";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                
                // removes all OMs from the session
                foreach (array_keys($_SESSION['om']) as $om_tmp) {
                    if ($_SESSION['om'][$om_tmp]['date'] === $om[0]) {
                        unset($_SESSION['om'][$om_tmp]);
                    }
                }
                
                $deleted = TRUE;
            }
            
            # create arc hash that we can add to $_SESSION
            $fields = ["date",
                       "crag",
                       "total_time",
                       "comments",
                       "description",
                       "route",
                       "rating",
                       "setNum"];
            $fields = array_flip($fields);
            $om_hash = array();
            foreach (array_keys($fields) as $field) {
                $om_hash[$field] = $om[$fields[$field]];
            }

            $sql = "INSERT INTO om (UserID,
                                     date,
                                     crag,
                                     total_time,
                                     comments,
                                     description,
                                     route,
                                     rating,
                                     daynum)
                    VALUES ($user_id,
                            '" . $om_hash['date'] . "',
                            '" . $om_hash['crag'] . "',
                            "  . $om_hash['total_time'] . ",  
                            '" . $om_hash['comments'] . "',
                            '" . $om_hash['description'] . "',
                            '" . $om_hash['route'] . "',
                            '" . $om_hash['rating'] . "',
                            " . $om_hash['setNum'] . ")";
                            
                            //. $om_hash['total_time'] . 

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
    
            $om_num = count($_SESSION['om']);
            $_SESSION['om']['om' . $om_num] = $om_hash;
        }   
    }
    
    function submit_hangboard($user_id, $hangs, $conn) {
        
        $deleted = FALSE;
        
        foreach ($hangs as $hang) {
            
            $hang = explode('!%$%!', $hang);
            
            for ($i = 0; $i < count($hang); $i++) {
                if (empty($hang[$i])) {
                    $hang[$i] = " ";
                }
            }
            
            if ($deleted == FALSE) {
                
                // delete all arcs with this date from DB
                $sql = "DELETE FROM arc where date='$hang[0]'";
                if ($conn->query($sql) === TRUE) {
                    echo "Old records deleted";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                
                // removes all arcs from the session
                foreach (array_keys($_SESSION['hang']) as $hang_tmp) {
                    if ($_SESSION['hang'][$hang_tmp]['date'] === $hang[0]) {
                        unset($_SESSION['hang'][$hang_tmp]);
                    }
                }
                
                $deleted = TRUE;
            }
            
            # create arc hash that we can add to $_SESSION
            $fields = ["date",
                       "weight",
                       "humidity",
                       "temp",
                       "rep_duration",
                       "rest_duration",
                       "grip",
                       "goal",
                       "resistance",
                       "reps",
                       "comments",
                       "daynum"];
            $fields = array_flip($fields);
            $hang_hash = array();
            foreach (array_keys($fields) as $field) {
                $hang_hash[$field] = $hang[$fields[$field]];
            }

            $sql = "INSERT INTO hangboard (UserID,
                                           date,
                                           weight,
                                           humidity,
                                           temp,
                                           rep_duration,
                                           rest_duration,
                                           grip,
                                           goal,
                                           resistance,
                                           reps,
                                           comments,
                                           daynum)
                    VALUES ($user_id,
                            '" . $hang_hash['date'] . "',
                            " . $hang_hash['weight'] . ",
                            " . $hang_hash['humidity'] . ",
                            " . $hang_hash['temp'] . ",
                            " . $hang_hash['rep_duration'] . ",
                            " . $hang_hash['rest_duration'] . ",
                            '" . $hang_hash['grip'] . "',
                            " . $hang_hash['goal'] . ",
                            " . $hang_hash['resistance'] . ",
                            " . $hang_hash['reps'] . ",
                            '" . $hang_hash['comments'] . "',
                             " . $hang_hash['daynum'] . ")";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
    
            $hang_num = count($_SESSION['hang']);
            $_SESSION['hang']['hang' . $hang_num] = $hang_hash;
        }   
    }
    
    function submit_limit($user_id, $lbs, $conn) {
        
        $deleted = FALSE;
        
        foreach ($lbs as $lb) {
            
            $lb = explode('!%$%!', $lb);
            
            for ($i = 0; $i < count($lb); $i++) {
                if (empty($lb[$i])) {
                    $lb[$i] = " ";
                }
            }
            
            if ($deleted == FALSE) {
                
                // delete all arcs with this date from DB
                $sql = "DELETE FROM limitboulder where date='$lb[0]'";
                if ($conn->query($sql) === TRUE) {
                    echo "Old records deleted";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                
                // removes all arcs from the session
                foreach (array_keys($_SESSION['limit']) as $lb_tmp) {
                    if ($_SESSION['limit'][$lb_tmp]['date'] === $lb[0]) {
                        unset($_SESSION['limit'][$lb_tmp]);
                    }
                }
                
                $deleted = TRUE;
            }
            
            # create arc hash that we can add to $_SESSION
            $fields = ["date",
                       "location",
                       "duration",
                       "numproblems",
                       "wbl",
                       "description",
                       "grade",
                       "attempts",
                       "comments",
                       "setnum"];
            $fields = array_flip($fields);
            $lb_hash = array();
            foreach (array_keys($fields) as $field) {
                $lb_hash[$field] = $lb[$fields[$field]];
            }

            $sql = "INSERT INTO limitboulder (UserID,
                                           date,
                                           location,
                                           duration,
                                           numproblems,
                                           wbl,
                                           description,
                                           grade,
                                           attempts,
                                           comments,
                                           setnum)
                    VALUES ($user_id,
                            '" . $lb_hash['date'] . "',
                            '" . $lb_hash['location'] . "',
                            " . $lb_hash['duration'] . ",
                            " . $lb_hash['numproblems'] . ",
                            '" . $lb_hash['wbl'] . "',
                            '" . $lb_hash['description'] . "',
                            '" . $lb_hash['grade'] . "',
                            " . $lb_hash['attempts'] . ",
                            '" . $lb_hash['comments'] . "',
                            " . $lb_hash['setnum'] . ")";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
    
            $lb_num = count($_SESSION['limit']);
            $_SESSION['limit']['limit' . $lb_num] = $lb_hash;
        }   
    }


    /***********************************************************************/
    $user_id = $_SESSION['id'];
    
        
    // connect to database
    include_once "$_SERVER[DOCUMENT_ROOT]/PHP/config.php";
    $type = $_POST['type'];
    
    if ($_POST['del'] === 'NO') {
    // seperate workouts
    $workouts = explode('%!$!%', $_POST['workouts']);
    
    
        if ($type === 'arc') {
            submit_arc($user_id, $workouts, $conn);
            
        } else if ($type === 'om') {
            submit_om($user_id, $workouts, $conn);
            
        } else if ($type === 'hangboard') {
            submit_hangboard($user_id, $workouts, $conn);
            
        } else if ($type === 'limit_bouldering') {
            submit_limit($user_id, $workouts, $conn);
            
        }
    
    } else {
        $date = $_POST['date'];
        delete_workout($type, $date, $conn);
    }

    $conn->close;
    exit();

