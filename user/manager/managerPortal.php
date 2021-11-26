<?php
    include_once "../../config/connect.php";
    include_once "allStudentsBusReservations.php";
    include_once "totalNumberOfBusses.php";
    include_once "totalNumberOfStudents.php";
    include_once "totalNumberOfEmptySeats.php";
    $fname = $_SESSION['userFName'];
    $lname = $_SESSION['userLName'];
    $html = "       <title>Student Portal</title>
</head>
<body>
    <br><a href=\"../../index.php\">Log out</a><br>
    <div id=\"portalSpace\">
        <br>
        <h1>Welcome  | " . $fname . " " . $lname  .  "</h1>
        <h2>Student Bus Reservation System</h2>

        <div id=\"reservationDiv\">
        <button id=\"createReservation\" name=\"createReservation\" onclick=\"makeReservation()\" >Make Reservation</button>
        </div>
        <h3>Logisic Report For Trip<br>Acardia Campus - Sosh South Campus At 08:00 - 08:45</h3>
        <p> * Total Number of Buses: " . $totalNumberOfBusses . "</p>
        <p> * Total Number of Students: " . $totalNumberOfStudents . "</p>
        <p> * Total Number of Empty Seats: " . $totalNumberOfEmptySeats . "</p>
        <h3>Todays Bus Reservations</h3><br>
        <p>The following is a list of all students that are taking busses today</p>
        " . $class_table .  "
    </div>
</body>";
echo $html;

?>
