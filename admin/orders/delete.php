<?php
 if($_GET['code']){
    $code = $_GET['code'];
 }else {
    echo "<h1 style='text-align:center;margin-top:50%'>Wrong page!!</h1>";
    die();
 }
 include_once '../inc/config.php';

 $deleteOrderQuery = "DELETE FROM `order` WHERE `code` = $code";
 $deleteOrderResult = $connect->query($deleteOrderQuery);
 if($deleteOrderResult){
    header("location: index.php");
 }
 ?>