<?php
    //Select the students current bus reservations
    include_once "../../config/connect.php";
    $userId = (int)$_SESSION['userId'];
    $sql = "SELECT user.userId, fName,  lName, reservation.resDate resDate, startTime, endTime,(SELECT `name` 
                                                                                                FROM `campus` 
                                                                                                WHERE `campusId` = trip.startPoint) startPoint, 
                                                                                                (SELECT `name` 
                                                                                                FROM `campus` 
                                                                                                WHERE `campusId` = trip.destination) destination
            FROM reservation, user, trip, campus a, campus b
            WHERE reservation.tripId = 3
            AND trip.tripId = reservation.tripId
            AND a.campusId = trip.startPoint
            AND b.campusId = trip.destination
            AND reservation.studentId = user.userId;";
    $sql;
    $result = mysqli_query($link, $sql);
    $class_table = "";
    if(mysqli_num_rows($result)>0)
    {
        $class_table .= "\n\t<table>\n<tr>";
        $class_table .= "\n\t\t<th>Student Number</th>";
        $class_table .= "\n\t\t<th>First Name</th>";
        $class_table .= "\n\t\t<th>Last Name</th>";
        $class_table .= "\n\t\t<th>Date</th>";
        $class_table .= "\n\t\t<th>Departure Time</th>";
        $class_table .= "\n\t\t<th>Destination Time</th>";
        $class_table .= "\n\t\t<th>Starting Point</th>";
        $class_table .= "\n\t\t<th>Destination</th>";
        $class_table .= "\n\t</tr>";
        while($row = mysqli_fetch_assoc($result))
        {
            $class_table .= "\n\t<tr>";
            $class_table .= "\n\t\t<td>" .$row['userId'] . "</td>";
            $class_table .= "\n\t\t<td>" .$row['fName'] . "</td>";
            $class_table .= "\n\t\t<td>" .$row['lName'] . "</td>";
            $class_table .= "\n\t\t<td>" .$row['resDate'] . "</td>";
            $class_table .= "\n\t\t<td>" .$row['startTime'] . "</td>";
            $class_table .= "\n\t\t<td>" .$row['endTime'] . "</td>";
            $class_table .= "\n\t\t<td>" .$row['startPoint'] . "</td>";
            $class_table .= "\n\t\t<td>" .$row['destination'] . "</td>";
            $class_table .= "\n\t</tr>";
        }
        $class_table .= "\n\t</table>";
    }
?>