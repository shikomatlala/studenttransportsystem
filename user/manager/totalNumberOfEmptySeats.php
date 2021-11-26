<?php
    //Select the students current bus reservations
    include_once "../../config/connect.php";
    $userId = (int)$_SESSION['userId'];
    $sql = "SELECT 63 - (COUNT(studentId) % 63) \"emptySeats\"
    FROM reservation
    WHERE tripId = 3";
    $sql;
    $result = mysqli_query($link, $sql);
    $totalNumberOfEmptySeats = null;
    if(mysqli_num_rows($result)>0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $totalNumberOfEmptySeats = $row['emptySeats'];
        }
    }
?>