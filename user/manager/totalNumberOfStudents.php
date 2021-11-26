<?php
    //Select the students current bus reservations
    include_once "../../config/connect.php";
    $userId = (int)$_SESSION['userId'];
    $sql = "SELECT COUNT(studentId) \"totStudents\"
    FROM reservation
    WHERE tripId = 3";
    $sql;
    $result = mysqli_query($link, $sql);
    $totalNumberOfStudents = null;
    if(mysqli_num_rows($result)>0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $totalNumberOfStudents = $row['totStudents'];
        }
    }
?>