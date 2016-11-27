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

    if(isset($_POST['type'])){
    	$uid = $_POST["uid"];
	    $msgType = $_POST["msgType"];
	    $msgTitle = $_POST["msgTitle"];
	    $msgDecorate = $_POST["msgDecorate"];
	    $msgArea = $_POST["msgArea"];
	    $msgAddress = $_POST["msgAddress"];
	    $msgPrice = $_POST["msgPrice"];
	    $msgConstruct = $_POST["msgConstruct"];
	    
	    $sql_msg = "INSERT INTO estate_info (uid, title, room_type, area, address, price, construct, info_type) VALUES('".$uid."','".$msgTitle."', '".$msgDecorate."', '".$msgArea."', '".$msgAddress."', '".$msgPrice."', '".$msgConstruct."', '".$msgType."')";
	    $result_insert = mysql_query($sql_msg);
	    $sql = "SELECT * FROM estate_info ORDER BY create_time DESC LIMIT 1";
	    $result = mysql_query($sql);
	    $row = mysql_fetch_assoc($result);
	    $eid = $row["eid"];

	    if($result_insert){
	        $json_res = array("code"=>200,"eid"=>$eid);
	    }else{
	        $json_res = array("code"=>404);
	    }
	    echo json_encode($json_res, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }

    if(isset($_POST['eid'])){
    	$eid = $_POST['eid'];
		//头像上传
		$oldfilename=$_FILES['upfile']['name'];//含文件后缀名

		 //取得保存文件的临时文件名（含路径）
		$filename=$oldfilename;
		$savedir = "./upload/"; 
		$savedir=$savedir.$filename;
		$dir = "./php/upload/" . $filename;
		if(move_uploaded_file($_FILES['upfile']['tmp_name'],$savedir)){
			$sql = "UPDATE `estate_info` SET `image` = '".$dir."' WHERE eid = '".$eid."'";
			$result = mysql_query($sql);
			$num = mysql_affected_rows();
			if($num){
				$json_res = array("code"=>200);
			}else{
				$json_res = array("code"=>400);
			}
		}else{
		 	$json_res = array("code"=>400);
		}

		echo json_encode($json_res, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }

    mysql_close($conn);
?>