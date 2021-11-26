<?php
session_start();
$database = "studentTransportSystem";
$password = "";
$username = "root";
$servername = "localhost";
$userTypes = array("Student", "Manager");

//CREATE SESSION VARIABLES
//echo ($_SERVER['REQUEST_URI']); //The reason why I did this echo was to test if the $_SERVER['REQUEST_URI']; works
$link = mysqli_connect($servername, $username, $password, $database);
if($link == false){
    die ("ERROR: Could not connect " . mysqli_connect_error());
}
else{
    //The thing with the header is that it changes with time sometimes the header will mean this and on the other times it will mean something else
    //This means that the header name should be dynamic
    $url = $_SERVER['REQUEST_URI'];

    //index location
    $js_file = "";
    $css_file = "";
    //loop through the slashes
    $y = 0;
    for($x = 0; $x < strlen($url); $x++)
    { 
        //now display all the slashes
        //Now the goal is to cut the first two slashes
        if($url[$x] === "/")
        {
            $y++;
            if($y >= 4)
            {
                $js_file .= ".." .  $url[$x];
                $css_file .= ".." .  $url[$x];
            }
        }
    }
    $js_file .= "config/javaScript/index.js";  
    $css_file .= "config/styles/index.css";
    $out = "connected!
<!DOCTYPE html>\n<html lang=\"en\" xmlns=\"http://www.w3.org/1999/xhtml\">";
    $out .= "
    <head>
        <meta charset=\"utf-8\" />
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <link rel=\"stylesheet\" href=\"$css_file\" />
        <meta charset=\"UTF-8\" />
        <script src=\"$js_file\"></script>\n";

    echo $out;
}

?>
