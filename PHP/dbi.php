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
                // delete all arcs with this date
                $sql = "DELETE FROM arc where date='$arc[0]'";
                if ($conn->query($sql) === TRUE) {
                    echo "Old records deleted";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                
                $deleted = TRUE;
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
                            '$arc[0]',
                            '$arc[1]',
                            '$arc[2]',
                            '$arc[3]',
                            '$arc[4]',
                            '$arc[5]',
                            $arc[6])";
    
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }



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

