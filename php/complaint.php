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

    $complainant = $_POST['u_id'];
    $eid = $_POST['e_id'];

    $sql = "SELECT uid FROM estate_info WHERE eid = '".$eid."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	$respondent = $row['uid'];

	if($complainant == $respondent){
		$json_res = array("code"=>400);
		echo json_encode($json_res, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		die();
	}

    $sql = "SELECT * FROM complain WHERE complainant = '".$complainant."' AND eid = '".$eid."'";
    $result = mysql_query($sql);
    $num = mysql_num_rows($result);

    if($num>0){
    	$json_res = array("code"=>400);
    }else{
    	$sql = "SELECT uid FROM estate_info WHERE eid = '".$eid."'";
    	$result = mysql_query($sql);
    	$row = mysql_fetch_assoc($result);
    	$respondent = $row['uid'];

    	$sql = "INSERT INTO complain (complainant,respondent,eid) VALUES ('".$complainant."','".$respondent."','".$eid."')";
    	$result = mysql_query($sql);
    	$num = mysql_affected_rows();
    	if($num){
    		$json_res = array("code"=>200);
    	}
    }

    echo json_encode($json_res, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
?>