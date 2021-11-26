<?php
    //Are we going to call this page? 
    include_once "../../config/connect.php";
    if(isset($_POST['reservation']))
    {
        $x =0;
        $startPointId = null;
        $destinationPoint = null;
        $reservation = json_decode($_POST['reservation']);
        $startTime = null;
        $tripId = null;
        $resDate = null;
        $studNumber = $_SESSION['userId'];
        foreach($reservation as $field)
        {
            echo "\n ROW: " . $x . "\n";
            if($x == 0)
            {
                $resDate = $field;
                echo "\t\tRes Date = " . $resDate;
            }
            if($x == 1)
            {
                $startTime = $field;
                echo "\t\tStart Time = " . $startTime;
            }
            if($x == 3)
            {
                $sql = "SELECT campusId FROM campus WHERE `name`= \"" . $field . "\"";
                $result = mysqli_query($link, $sql);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $startPointId = $row['campusId'];
                    }
                }
                echo "\t\tStart Point ID = " . $startPointId;
            }
            if($x == 4)
            {
                $sql = "SELECT campusId FROM campus WHERE `name`= \"" . $field . "\"";
                $result = mysqli_query($link, $sql);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $destinationPoint = $row['campusId'];
                    }
                }
                echo "\t\tDestination Point ID = " . $destinationPoint;
            }
            $x++;
        }
        //Get the trip ID
        $sql = "SELECT tripId FROM `trip` WHERE startPoint = $startPointId AND destination = $destinationPoint AND startTime =\"$startTime\"";
        $result = mysqli_query($link, $sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $tripId = $row['tripId'];
            }
        }
        echo "\nThe trip ID is " . $tripId;
        echo "\nThe student Number is " . $_SESSION['userId'];
        echo "\nThe reservation Date is " . $resDate . "\n";
    
        $sql = "INSERT INTO reservation (resDate, studentId, tripId) VALUES (\"$resDate\", $studNumber, $tripId)";
        if(mysqli_query($link, $sql))
        {
            echo "Trip Added Successfully";
        }
        else
        {
            echo "Trip Not Added";
        }
        
         
    }