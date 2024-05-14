<?php

    $db_name = "budget_db";
    $db_port = 3307;
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "\$root2024$";
    
    try {
        $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);
    }
    catch(error) {
        echo "Error connection to database";
    }
?>