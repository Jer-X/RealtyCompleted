<?php
	//查询用户是否处于登录状态
    require './database.php';
    header('content-type:application/json;charset=utf8');

    $conn = mysql_connect($servername, $username, $password);
    if (!$conn){
        die('Could not connect: ' . mysql_error());
    }
    $db_sel=mysql_select_db($db,$conn);
    $sql = "set names utf8";
    mysql_query($sql,$conn);
    
    session_start();
    // 判断用户是否登录
    if(isset($_SESSION["admin"]) && $_SESSION["admin"] === true){
        $username = $_SESSION['username'];
        $uid = $_SESSION['userid'];
        $sql = "SELECT * FROM user_info WHERE uid = '".$uid."'";
        $result = mysql_query($sql);
        $row = mysql_fetch_assoc($result);
        $json_admin = array("admin"=>true,"username"=>$username,"userid"=>$row['uid'],"phone"=>$row['phone'],'frozen'=>$row['frozen'],'user_type'=>$row['user_type']);
    }else{
        $json_admin = array("admin"=>false);
    }
    echo json_encode($json_admin, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
?>