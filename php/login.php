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

    $username = $_POST["username"];
    $user_password = $_POST["password"];

    $sql = "SELECT * FROM user_info WHERE username = '".$username."' AND password = '".$user_password."'";
    $result = mysql_query($sql);
    $num = mysql_num_rows($result);


    if($num){
        if($num == 0){
            $json_res = array("code"=>100);
        }
        $row=mysql_fetch_assoc($result);
        $json_res = array("code"=>200,"username"=>$username,"uid"=>$row['uid'],"phone"=>$row['phone'],'frozen'=>$row['frozen'],'user_type'=>$row['user_type']);
        session_start();
        $_SESSION["admin"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["userid"] = $row['uid'];
    }else{
        $json_res = array("code"=>404);
    }

    echo json_encode($json_res, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    mysql_close($conn);
?>