<?php
 if($_GET['Id']){
    $Id = $_GET['Id'];
 }else {
    echo "<h1 style='text-align:center;margin-top:50%'>Wrong page!!</h1>";
    die();
 }
 include_once '../inc/config.php';
 $selQuery = "SELECT `image` FROM product WHERE Id = $Id";
 $result = $connect->query($selQuery);
 $imageName = $result->fetch(PDO::FETCH_ASSOC);
 $imageName = $imageName['image'];
 $query = "DELETE FROM `product` WHERE `Id` = $Id";
 $deleteOrderQuery = "DELETE FROM `order` WHERE `product_id` = $Id";
 $res = $connect->query($query);
 $deleteOrderResult = $connect->query($deleteOrderQuery);
 if($res){
   unlink("../assets/products/images/$imageName");
   unlink("../../FrontEnd2/img/products/$imageName");
    header("location: index.php");
 }
 ?>