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
	    	$result = mysql_query($sql);
	    	$num = mysql_affected_rows();
	    	if($num){
	    		echo 201;
	    	}
	    }
    }
    

    //如果一个月内有10条以上的信息有不同房源地址但却有相同的联系方式，这些信息的发布者是中介人员，记入数据库。(默认可使用同一手机号码)
    $sql = "SELECT * FROM estate_info WHERE `uid` IN ( SELECT uid FROM user_info WHERE phone IN (SELECT phone FROM user_info WHERE uid = '".$uid."')) AND DATE_SUB(CURDATE(),INTERVAL 30 DAY) ORDER BY create_time DESC";
    $result = mysql_query($sql);
    $num = mysql_num_rows($result);

    if($num > 10){
    	$sql = "SELECT address FROM estate_info WHERE uid = '".$uid."' ORDER BY create_time DESC LIMIT 1";
    	$result = mysql_query($sql);
    	$address = mysql_fetch_assoc($result)['address'];
    	
    	$sql = "SELECT address,uid FROM estate_info WHERE `uid` IN ( SELECT uid FROM user_info WHERE phone IN (SELECT phone FROM user_info WHERE uid = '".$uid."')) AND DATE_SUB(CURDATE(),INTERVAL 30 DAY) ORDER BY create_time DESC";
    	$result = mysql_query($sql);
    	$count = 0;
    	while($row = mysql_fetch_assoc($result)){
    		if($row['address'] != $address && $row['uid'] != $uid){
    			$count++;
    		}
    	}

    	if($count > 10){
    		$sql = "SELECT uid FROM estate_info WHERE `uid` IN ( SELECT uid FROM user_info WHERE phone IN (SELECT phone FROM user_info WHERE uid = '".$uid."')) ORDER BY create_time DESC";
	    	$result = mysql_query($sql);

	    	while($row = mysql_fetch_assoc($result)){
		    	$sql = "UPDATE `user_info` SET `user_type` = '1' WHERE `user_info`.`uid` ='".$row['uid']."'";
		    	mysql_query($sql);
		    }
		    echo 202;
    	}
    }
?>