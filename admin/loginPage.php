<?php
include_once './inc/config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = sha1($_POST['password']);
  if(isset($_POST['rememberMe'])){
    $rememberMe = $_POST['rememberMe'];
  }

  try {
    $query = "SELECT * FROM `admin` WHERE `email`='$email' AND `password`='$password'";
    $result = $connect->query($query);
    $admin = $result->fetch(PDO::FETCH_ASSOC);
    if($result->rowCount()>0){
      $id = $admin['id'];
      if(isset($rememberMe)){
        setcookie('Id',$id,time()+10000);
        header("Location: products/index.php");
      }else {
        session_start();
        $_SESSION['Id'] = $id;
        header("Location: products/index.php");
      }
    }
  }catch (PDOException $e){
    echo 'ERORR!! '.$e->getMessage();
  }
}
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/scc2?family=Spartan:wght@100;200;300;400;500;600;700;800;900&display=swap"
    />
    <style>
      body {
        font-family: 'Spartan', sans-serif;
        background-color: #e3e6f3;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }
      form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
      }

      label {
        display: block;
        margin-bottom: 8px;
      }

      input {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
      }

      .input-submit {
        background-color: #4caf50;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
      }
      @media (max-width: 678px) {
        body {
          flex-direction: column;
        }
        form {
          max-width: 50%;
        }
      }
      .remember-me {
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .remember-me label {
        width: 50%;
      }
      .remember-me #rememberMe  {
        margin-left: -100px;
      }
      @media (max-width: 500px) {
        .remember-me #rememberMe  {
        margin-left: -20px;
      }
      }
    </style>
  </head>
  <body>
    <form id="loginForm" method="post">
      <label for="email">Email:</label>
      <input type="text" id="email" name="email" required />
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required />
      <div class="remember-me">
      <label for="rememberMe">Remember Me</label>
      <input type="checkbox" name="rememberMe" id="rememberMe">
      </div>
      <input type="submit" class="input-submit" value="Login" />
    </form>
    <script>
      <?php     if ($_SERVER['REQUEST_METHOD'] == 'POST'&&$result->rowCount()==0){  ?>
      alert("Admin Not Exist");
      <?php } ?>
    </script>
  </body>
</html>
