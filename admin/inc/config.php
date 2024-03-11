<?php 
$serverName = "localhost";
$username = "root";
$password = "";
$dbname = "project";

try{
    $connect = new PDO("mysql:host=$serverName;dbname=$dbname;charset=utf8mb4",$username,$password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    echo $e->getMessage();
}

?>