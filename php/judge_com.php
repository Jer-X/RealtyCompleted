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

    $eid = $_POST['e_id'];
    //判断是否为假信息
    $sql = "SELECT * FROM complain WHERE eid = '".$eid."'";
    $num = mysql_query($sql);
    $num = mysql_affected_rows();

    if($num > 3){
    	$sql = "SELECT uid FROM estate_info WHERE eid = '".$eid."'";
    	$result = mysql_query($sql);
    	$row = mysql_fetch_assoc($result);

    	$uid = $row['uid'];
    	$sql = "UPDATE `estate_info` SET `reliable` = '0' WHERE `estate_info`.`eid` = '".$eid."'";
    	mysql_query($sql);
    	
    	$sql = "UPDATE `user_info` SET `frozen` = '1' WHERE `user_info`.`uid` = '".$uid."'";
    	mysql_query($sql);
    	$num = mysql_affected_rows();
    	if($num){
    		$json_res = array("code"=>200);
    	}else{
    		$json_res = array("code"=>400);
    	}

    	echo json_encode($json_res, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
?>