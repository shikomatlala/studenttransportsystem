<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    include_once "../../../config/connectAPI.php";
    //I am not waiting for anything to be selected I just want to give out this information freely
    // $database = new Database();
    $sql = "SELECT DISTINCT(a.name) \"startPoint\" FROM trip, campus a,campus b WHERE trip.startPoint = a.campusId AND trip.startPoint = b.campusId";
    $result = mysqli_query($link, $sql);
    if(mysqli_num_rows($result)>0){
        $posts_arr = array();
        while($row = mysqli_fetch_assoc($result)){
            Extract($row);
            $post_item = array(
                'startPoint' => $startPoint,
            );
            array_push($posts_arr, $post_item);
        }
        echo json_encode($posts_arr);
    }
    else{
        echo json_encode(array('message'=> 'No posts found'));
    }
?>