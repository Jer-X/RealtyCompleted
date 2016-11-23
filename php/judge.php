<?php 
	require './database.php';
    header('content-type:application/json;charset=utf8');
    $conn = mysql_connect($servername, $username, $password);
    if (!$conn){
        die('Could not connect: ' . mysql_error());
    }
    $db_sel=mysql_select_db($db,$conn);
    $sql = "set names utf8";
    mysql_query($sql,$conn);

    $uid = $_POST['uid'];

    //如果发布者一个月内发布了5条以上的信息，可知改用户是中介人员（个人用户一般没这么多房源），记入数据库。
    $sql = "SELECT create_time FROM estate_info WHERE `uid` = '".$uid."' ORDER BY create_time DESC";
    $result = mysql_query($sql);
    $num = mysql_num_rows($result);

    if($num > 5){
    	$sql = "SELECT create_time FROM estate_info WHERE `uid` = '".$uid."' ORDER BY create_time DESC LIMIT 5";
    	$result = mysql_query($sql);
    	$k = 0;

	    while($row = mysql_fetch_assoc($result)){
	    	if($k == 0){
	    		$start = $row;
	    	}
	    	if($k == 4){
	    		$end = $row;
	    	}
	    	$k++;
	    }

	    $time = strtotime($start['create_time']) - strtotime($end['create_time']);
	    $day = $time / (24*60*60*1000);
	    if($day < 30){
	    	$sql = "UPDATE `user_info` SET `user_type` = '1' WHERE `user_info`.`uid` = '".$uid."'";
	    	mysql_query($sql);
	    }
    }
    

    //如果一个月内有10条以上的信息有不同房源地址但却有相同的联系方式，这些信息的发布者是中介人员，记入数据库。
    $sql = "SELECT * FROM estate_info WHERE `uid` IN ( SELECT uid FROM user_info WHERE phone IN (SELECT phone FROM user_info WHERE uid = '".$uid."')) ORDER BY create_time DESC";
    $result = mysql_query($sql);
    $num = mysql_num_rows($result);

    if($num > 10){
    	$sql = "SELECT * FROM estate_info WHERE `uid` IN ( SELECT uid FROM user_info WHERE phone IN (SELECT phone FROM user_info WHERE uid = '".$uid."')) ORDER BY create_time DESC LIMIT 10";
    	$result = mysql_query($sql);
    	$j = 0;

    	while($row = mysql_fetch_assoc($result)){
	    	if($j == 0){
	    		$one = $row;
	    	}
	    	if($j == 1){
	    		$two = $row;
	    	}
	    	if($j == 2){
	    		$three = $row;
	    	}
	    	if($j == 3){
	    		$four = $row;
	    	}
	    	if($j == 4){
	    		$five = $row;
	    	}
	    	if($j == 5){
	    		$six = $row;
	    	}
	    	if($j == 6){
	    		$seven = $row;
	    	}
	    	if($j == 7){
	    		$eight = $row;
	    	}
	    	if($j == 8){
	    		$nine = $row;
	    	}
	    	if($j == 9){
	    		$ten = $row;
	    	}
	    	$j++;
	    }

	    $time = strtotime($one['create_time']) - strtotime($ten['create_time']);
	    $day = $time / (24*60*60*1000);
	    if($day < 30){
	    	$sql = "UPDATE `user_info` SET `user_type` = '1' WHERE `user_info`.`uid` IN ('".$one['uid']."','".$two['uid']."','".$three['uid']."','".$four['uid']."','".$five['uid']."','".$six['uid']."','".$seven['uid']."','".$eight['uid']."','".$nine['uid']."','".$ten['uid']."')";
	    	mysql_query($sql);
	    }
    }
?>