<?php
    require './database.php';
    header('content-type:application/json;charset=utf8');
    
    $conn=mysql_connect($servername,$username,$password);
    if (!$conn){
        die('Could not connect: ' . mysql_error());
    }
    $db_sel=mysql_select_db($db,$conn);
    $sql = "set names utf8";
    mysql_query($sql,$conn);

    $index = $_POST['index'];
    $start = 15*($index-1);
    $end = 15*($index);
    
    $sql="SELECT eid,image,title,area,address,price,room_type,info_type,construct,reliable,create_time,user_type FROM estate_info,user_info WHERE estate_info.uid = user_info.uid ORDER BY create_time DESC LIMIT ".$start.",".$end;
    $result=mysql_query($sql,$conn);

    $json_arr=array();
    while($row=mysql_fetch_assoc($result)){
        $arr=array(
            "eid"=>$row["eid"],
            "image"=>$row['image'],
            "title"=>$row["title"],
            "area"=>$row["area"],
            "address"=>$row["address"],
            "price"=>$row["price"],
            "decorate"=>$row["room_type"],
            "info_type"=>$row["info_type"],
            "construct"=>$row["construct"],
            "reliable"=>$row["reliable"],
            "create_time"=>$row["create_time"],
            "user_type"=>$row["user_type"]
        );
        array_push($json_arr,$arr);
    }

    echo json_encode($json_arr, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    mysql_close($conn);
    
?>