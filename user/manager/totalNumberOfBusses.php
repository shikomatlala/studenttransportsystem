<?php
    //Select the students current bus reservations
    include_once "../../config/connect.php";
    $userId = (int)$_SESSION['userId'];
    $sql = "SELECT CEILING(COUNT(studentId) / 63) \"totBuses\"
    FROM reservation
    WHERE tripId = 3";
    $sql;
    $result = mysqli_query($link, $sql);
    $totalNumberOfBusses = null;
    if(mysqli_num_rows($result)>0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $totalNumberOfBusses = $row['totBuses'];
        }
    }
?>