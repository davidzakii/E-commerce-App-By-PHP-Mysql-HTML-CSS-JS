<?php
 if($_GET['user_Id']){
    $user_Id = $_GET['user_Id'];
 }else {
    echo "<h1 style='text-align:center;margin-top:50%'>Wrong page!!</h1>";
    die();
 }
 include_once '../inc/config.php';

 $userQuery = "SELECT `image` FROM `users` WHERE `user_Id`=$user_Id";
 $userQueryResult = $connect->query($userQuery); 
 $user = $userQueryResult->fetch(PDO::FETCH_ASSOC);
 $userImage = $user['image'];

 $deleteUserQuery = "DELETE FROM `users` WHERE `user_Id` = $user_Id";
 $res = $connect->query($deleteUserQuery);
 if($res){
   unlink("../assets/users/$userImage");
    header("location: index.php");
 }
 ?>