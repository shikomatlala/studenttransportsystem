<?php
    include_once "../../config/connect.php";
    include_once "currentBusReservations.php";
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

        <h3>Your Current Bus Reservations </h3><br>
        " . $class_table .  "
    </div>
</body>";
echo $html;

?>
