<?php
session_start();
setcookie('Id', '', time() - 1);
if(isset($_SESSION['Id'])){
    unset($_SESSION['Id']);
 }
header("location: LoginPage.php");
?>