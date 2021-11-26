<?php
    include_once "../config/connect.php";
    include_once "../class/user.php";
    $_SESSION['userId'] = 0;
    $_SESSION['userFName'] = "";
    $_SESSION['userLName'] = "";
    $_SESSION['userType'] = "";
    if(isset($_POST['submitLogin'])){
        //Get the values
        $userName = (int)$_POST['userIdInput'];
        $userPassword = $_POST['userPasswordInput'];
        //Create an SQL statement to get he information that you are looking for
        $sql = "SELECT * FROM `user` WHERE `userId`=" . $userName . " AND `password`=\"" . $userPassword . "\"";
        $result = mysqli_query($link, $sql);
        $userType = 0;
        if(mysqli_num_rows($result) > 0){
            //Find the user type
            while($row = mysqli_fetch_assoc($result)){
                //Show the hightest number
                $userType = (int)$row['userTypeId'];
                $_SESSION['userId'] = $row['userId'];
                $_SESSION['userFName'] = $row['fName'];
                $_SESSION['userLName'] = $row['lName'];
                $_SESSION['userType'] = $userType;
            }
            if($userType == 2 ){//User is Manager
                
                // include_once "student/studentPortal.php";//Now we need to actually jump to this page and not call it
                header("LOCATION: manager/managerPortal.php");

            }
            else{
                header("LOCATION: student/studentPortal.php");
            }
        }

    }


