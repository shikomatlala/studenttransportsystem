<?php
function header_html_($style_link)
{
    $url = $_SERVER['REQUEST_URI'];
    //index location
    $js_file = "";
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
            }
        }
    }
    $js_file .= "index.js";  
    $out = "<!DOCTYPE html>\n<html lang=\"en\" xmlns=\"http://www.w3.org/1999/xhtml\">";
    $out .= "
    <head>
        <meta charset=\"utf-8\" />
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <link rel=\"stylesheet\" href=\"$style_link\" />
        <title>Bidding System</title>
        <meta charset=\"UTF-8\" />
    </head>
    <body>
    <script src=\"$js_file\"></script>
    \n";

    return $out;
}

function header_html($style_link)
{
    $url = $_SERVER['REQUEST_URI'];

    //index location
    $js_file = "";
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
            }
        }
    }
    $js_file .= "index.js";  
    $out = "\n<html lang=\"en\" xmlns=\"http://www.w3.org/1999/xhtml\">";
    $out .= "
    <head>
        <meta charset=\"utf-8\" />
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <link rel=\"stylesheet\" href=\"$style_link\" />
        <title>Bidding System</title>
        <meta charset=\"UTF-8\" />
    </head>
    <body>
    <div class=\"topnav\" id=\"myTopnav\">
        <ul>
            <li><a href=\"../home/admin_home.php\">Home</a></li>
            <li> " . button("", "Brows Autions","onclick", "viewGroups()", "linkButton") . "</li>
            <li><a href=\"../../../index.php\">Log out</a></li>
        </ul>
    </div>
    <script src=\"$js_file\"></script>
    \n";

    return $out;
}


?>