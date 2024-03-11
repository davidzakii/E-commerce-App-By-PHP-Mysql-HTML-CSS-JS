<?php
//86c16a459ecf39fd76a8e750f9d5074c4722f22b
include_once './Inc/config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $password = sha1($_POST["password"]);
  // Query to check if the user exists in the database
  try {
    $sql = "SELECT * FROM users WHERE email = '$email' AND `password` = '$password'";
    $result = $connect->query($sql);
    if($result->rowCount() > 0){
            // User exists, redirect to home page
            $user = $result->fetch(PDO::FETCH_ASSOC);
            $user_Id = $user['user_Id'];
            header("Location: home.php?user_Id=$user_Id");
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
    </style>
  </head>
  <body>
    <form id="loginForm" method="post">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required />
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required />
      <input type="submit" class="input-submit" value="Login" />
      <div class="go-login-page">
        <span>if you don't have account </span>
        <a href="registerPage.php">go to sign up page</a>
      </div>
    </form>
    <script>
      <?php     if ($_SERVER["REQUEST_METHOD"] == "POST"&&isset($result)&&$result->rowCount() == 0) { ?>
      alert("Email or password is not correct.");
      <?php } ?>
    </script>
    <!-- <script>
      let inputSubmit = document.querySelector("input[type='submit']");
      let loginForm = document.getElementById('loginForm');
      console.log(loginForm.getAttribute('action'));
      const users = JSON.parse(localStorage.getItem('users')) || [];
      function loginPage(event) {
        event.preventDefault();
        let email = document.getElementById('email');
        let password = document.getElementById('password');
        let findUser = users.find((user) => user.email === email.value);
        console.log(findUser);
        if (findUser && findUser.password === password.value) {
          window.location.href =
            'home.html?userName=' +
            encodeURIComponent(findUser.firstName + ' ' + findUser.lastName) +
            '&email=' +
            encodeURIComponent(findUser.email);
        } else {
          alert('email or password not correct');
          location.reload();
        }
      }
      inputSubmit.addEventListener('click', loginPage);
    </script> -->
  </body>
</html>
