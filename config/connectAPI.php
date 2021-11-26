<?php
    session_start();
    $database = "studentTransportSystem";
    $password = "";
    $username = "root";
    $servername = "localhost";

    $link = mysqli_connect($servername, $username, $password, $database);
    if($link == false){
        die ("ERROR: Could not connect " . mysqli_connect_error());
    }
?>