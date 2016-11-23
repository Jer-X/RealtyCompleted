<?php
require 'database.php';

$file = './php/msg2.txt';
$content = file_get_contents($file);
$content = explode('#',$content);

$img = array();
$title = array();
$construct = array();
$area = array();
$decorate = array();
$address = array();
$price = array();

for($i = 0; $i<count($content)-1; $i+=11){
	
  $str = $content[$i];
  $str= str_replace(PHP_EOL,'', $str);
  array_push($img,$str);
  
  $str = $content[$i+1];
  $str= str_replace(PHP_EOL,'', $str);
	array_push($title,$str);
	
  $str = $content[$i+2];
	array_push($construct,$str);
	
  $str = $content[$i+3];
	array_push($area,$str);
	
  $str = $content[$i+4];
	array_push($decorate,$str);
	
  $str = $content[$i+5].$content[$i+6].$content[$i+7].$content[$i+8];
	array_push($address,$str);
	
  $str = $content[$i+9].$content[$i+10];
	array_push($price,$str);
}

$conn = mysql_connect($servername,$username,$password);

$seldb = mysql_select_db($db, $conn);
if (!$seldb)
{
  mysql_query("CREATE DATABASE estate_db CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';",$conn); 
  mysql_select_db('estate_db');
}

$dbinit_str="
CREATE TABLE IF NOT EXISTS user_info(
  uid INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  username VARCHAR(10) NOT NULL,
  password VARCHAR(20) NOT NULL,
  phone VARCHAR(11) NOT NULL,
  frozen INT NOT NULL DEFAULT 0,
  user_type INT DEFAULT 0 COMMENT '用户的类型',
  UNIQUE KEY(`uid`)
) DEFAULT CHARSET = utf8;
";
mysql_query($dbinit_str);

$dbinit_str="
CREATE TABLE IF NOT EXISTS estate_info(
  eid INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  uid INT NOT NULL DEFAULT 1,
  image VARCHAR(200) NOT NULL,
  title VARCHAR(100) NOT NULL,
  area INT NOT NULL,
  address VARCHAR(100) NOT NULL,
  price VARCHAR(8) NOT NULL,
  room_type VARCHAR(10) NOT NULL,
  info_type INT NOT NULL COMMENT '信息的类型' DEFAULT 1,
  construct VARCHAR(20) NOT NULL DEFAULT '精装修',
  reliable INT NOT NULL DEFAULT 1,
  create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY (`eid`) 
) DEFAULT CHARSET = utf8;
";
mysql_query($dbinit_str);

$dbinit_str="
create table if not exists complain(
	complainant int not null comment '投诉者id',
	respondent int not null comment '被投诉者id',
	eid int not null comment '房产信息id'
) DEFAULT CHARSET = utf8;
";
mysql_query($dbinit_str);

$dbinit_str="
create table if not exists message  (
	uid int not null comment '留言人id',
	eid int not null comment '被留言房产信息id',
	content varchar(255) not null comment '留言内容'
) DEFAULT CHARSET = utf8;
";
mysql_query($dbinit_str);

$sql = "set names utf8";
mysql_query($sql,$conn);

$result = mysql_query("SELECT * FROM estate_info", $conn);
$num_rows = mysql_num_rows($result);

if($num_rows<=0){
  for($i=0;$i<count($title);$i++){
    $sql = "INSERT INTO estate_info (image,title,area,address,price,construct,room_type) VALUES('".$img[$i]."','". $title[$i] ."','".$area[$i]."','".$address[$i]."','".$price[$i]."','".$construct[$i]."','".$decorate[$i]."')";
    mysql_query($sql,$conn);
  }
}

$sql = "INSERT INTO user_info (username,password,phone,user_type) VALUES ('11@11.com','111','11111111111','1')";
mysql_query($sql);

mysql_close($conn);
?>