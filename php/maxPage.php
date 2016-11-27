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

    $sql = "SELECT * FROM `estate_info`";
    $total = mysql_query($sql);
    $total = mysql_affected_rows();
    $maxIndex = ceil($total/15);

    echo $maxIndex;
?>