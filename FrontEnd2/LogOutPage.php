<?php
session_start();
setcookie('user_Id', '', time() - 1);
if(isset($_SESSION['user_Id'])){
    unset($_SESSION['user_Id']);
 }
header("location: index.php");
?>