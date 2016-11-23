<?php 
	session_start();
    unset($_SESSION["admin"]);
    unset($_SESSION["username"]);
    session_destroy();
?>