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

 $deleteUserOrderQuery = "DELETE FROM `order` WHERE `user_id` = $user_Id";
 $deleteOrderResult = $connect->query($deleteUserOrderQuery);

 if($res &&  $deleteOrderResult ){
   unlink("../assets/users/$userImage");
   unlink("../../FrontEnd2/img/users/$userImage");
   session_start();
   setcookie('user_Id', '', time() - 1);
   if(isset($_SESSION['user_Id'])){
      unset($_SESSION['user_Id']);
   }
 ?>
 <script>
   localStorage.removeItem("<?php echo "cart_$user_Id"?>")
 </script>
 <?php header("location: index.php"); ?>
 <?php }else {
   echo "Not Respond";
   die();
 } ?>
 