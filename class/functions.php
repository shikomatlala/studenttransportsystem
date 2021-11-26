<?php



function editNav()
{
 return "
    <div class=\"topnav\" id=\"myTopnav\">
    <ul>
        <li> " . button("", "Create Auction","onclick", "createAuction()", "linkButton") . "</li>
        <li> " . button("", "My Active Bids","onclick", "addStudent()", "linkButton") . "</li>
        <li> " . button("", "My Active Autions","", "", "linkButton") . "</li>
        <li> " . button("", "Purchases","", "", "linkButton") . "</li>
        <li> " . button("", "My Sales","", "", "linkButton") . "</li>
    </ul>
</div>";

}



function button($id, $caption, $action, $function, $class)
{
    return "<button class=\"$class\" id=\"$id\" $action=\"$function\">$caption</button>";
}

?>