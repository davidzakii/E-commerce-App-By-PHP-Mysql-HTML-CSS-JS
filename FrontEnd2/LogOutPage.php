<?php
session_start();
setcookie('user_Id', '', time() - 1);
session_unset();
session_destroy();
header("location: index.php");
?>