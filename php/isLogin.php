<?php
	//查询用户是否处于登录状态
    header('content-type:application/json;charset=utf8');
    
    session_start();
    // 判断用户是否登录
    if(isset($_SESSION["admin"]) && $_SESSION["admin"] === true){
        $json_admin = array("admin"=>true,"username"=>$_SESSION["username"],"userid"=>$_SESSION["userid"]);
    }else{
        $json_admin = array("admin"=>false);
    }
    echo json_encode($json_admin, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
?>