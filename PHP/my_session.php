<?php
if (!session_id()){session_start();};

$in = $_POST['var_in'];
if ($in == 'all') {
    print_r($_SESSION);
} else {
    print_r($_SESSION[$in]);
}