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
    $userphone = $_POST["telephone"];

    $sql = "SELECT username FROM user_info WHERE username = '".$username."'";
    $result = mysql_query($sql);
    $num = mysql_num_rows($result);

    if($num>0){
        // 该用户已经存在
        $json_res = array("code"=>204);
    }else{
        $sql_insert = "INSERT INTO user_info (username, password, phone) VALUES('".$username."', '".$user_password."', '".$userphone."')";
        $result_insert = mysql_query($sql_insert);
        if($result_insert){
            $sql = "SELECT uid,username,password FROM user_info WHERE username = '".$username."' AND password = '".$user_password."'";
            $result = mysql_query($sql);
            $row=mysql_fetch_assoc($result);
            $id = $row['uid'];
            $json_res = array("code"=>200,"username"=>$username,"uid"=>$id);
            session_start();
            $_SESSION["admin"] = true;
            $_SESSION["username"] = $username;
            $_SESSION["userid"] = $id;
        }else{
            $json_res = array("code"=>404);
        }
    }
    echo json_encode($json_res, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    mysql_close($conn);
?>