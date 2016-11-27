<?php 
	require './database.php';
	//header('content-type:application/json;charset=utf8');

	$conn=mysql_connect($servername,$username,$password);
	if (!$conn){
	    die('Could not connect: ' . mysql_error());
	}
	$db_sel=mysql_select_db($db,$conn);
	$sql = "set names utf8";
	mysql_query($sql,$conn);

	//$keyWord = $_POST['keyWord'];
	$key = $_POST['key'];
    $type = $_POST['type'];
    switch($type){
        case 1:
            $search_type = 'title';
            break;
        case 2:
            $search_type = 'area';
            break;
        case 3:
            $search_type = 'room_type';
            break;
        case 4:
            $search_type = 'construct';
            break;
        case 5:
            $search_type = 'address';
            break;
        case 6:
            $search_type = 'price';
            break;
    }

	$sql="SELECT eid,image,title,area,address,price,room_type,info_type,construct,reliable,create_time,user_type,username FROM estate_info,user_info WHERE estate_info.uid = user_info.uid AND user_info.frozen = '0' AND ".$search_type." LIKE '%".$key."%' ORDER BY create_time DESC";

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
            "user_type"=>$row["user_type"],
            'username'=>$row['username']
        );
        array_push($json_arr,$arr);
    }

    echo json_encode($json_arr, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    mysql_close($conn);
?>