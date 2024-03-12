<?php 
include_once './Inc/config.php';
session_start();
if(!isset($_SESSION['user_Id'])&&!isset($_COOKIE['user_Id'])){
  header('location: LoginPage.php');
}
if(isset($_SESSION['user_Id'])){
  $user_Id = $_SESSION['user_Id'];
}
if(isset($_COOKIE['user_Id'])){
  $user_Id = $_COOKIE['user_Id'];
}
  $userQuery = "SELECT * FROM `users` WHERE `user_Id`=$user_Id";
  $userResult = $connect->query($userQuery);
  $user = $userResult->fetch(PDO::FETCH_ASSOC);
if($_SERVER['REQUEST_METHOD']=='POST'){
  include_once './Inc/validation.php';
  // $usersEmailsQuery = 'SELECT `email` FROM users';
  // $usersEmailsResult = $connect->query($usersEmailsQuery);
  // $usersEmails = $usersEmailsResult->fetchAll(PDO::FETCH_ASSOC);

  $userName = $_POST['userName'];
  $email = $_POST['email'];
  if(!empty($_FILES['image']['name'])){
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $imageArr=explode(".",$image);
    $ext=end($imageArr);
    $ext=strtolower($ext);
    $allowedExt=['jpg','png','jpeg','bmp'];
    checkExt($ext,$allowedExt);
  }
  $password = sha1($_POST['password']);
  $conPassword = sha1($_POST['confirmPassword']);
  checkName($userName);
  checkEmail($email);
  if($email == $user['email']){
    $email = $user['email'];
  }else {
    duplicateEmail($email);
  }
  checkpassword($password,$conPassword);

  // foreach($usersEmails as $userEmail){
  //   if($email == $userEmail['email']){
  //     global $errors;
  //     $errors['existEmail']='Email Already Exist';
  //   }
  // }
  if(empty($errors)){
    if(empty($image)){
      $updateQuery = "UPDATE `users` SET 
      `user_name` = '$userName',
      `email` = '$email',
      `password` = '$password'
      WHERE `user_Id` = $user_Id";
    }else {
      if($image == $user['image']){
        $updateQuery = "UPDATE `users` SET 
        `user_name` = '$userName',
        `email` = '$email',
        `password` = '$password',
        `image` = '$image'
        WHERE `user_Id` = $user_Id";
      }else {
        if (file_exists("./img/users/".$user['image'])) {
          unlink("./img/users/".$user['image']);
        } 
        if (file_exists("../admin/assets/users/".$user['image'])) {
          unlink("../admin/assets/users/".$user['image']);
        }
        copy($tmp_name,'./img/users/'.$image);
        copy($tmp_name,'../admin/assets/users/'.$image);
        $updateQuery = "UPDATE `users` SET 
        `user_name` = '$userName',
        `email` = '$email',
        `password` = '$password',
        `image` = '$image'
        WHERE `user_Id` = $user_Id";
      }
    }
    try{
      $res = $connect->query($updateQuery);
    }catch (PDOException $e){
      echo "Error: " . $e->getMessage();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile Update</title>
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

      .error-message {
        color: red;
        margin-top: -8px;
        margin-bottom: 16px;
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
      .disabled {
        opacity: 0.5;
        cursor: auto;
      }
      @media (max-width: 678px) {
        body {
          flex-direction: column;
        }
        form {
          max-width: 60%;
        }
      }
      .alert-danger {
        background-color: #ec9999;
      }
      .alert-success {
        background-color: #b4ff9a;
      }
    </style>
  </head>
  <body>
    <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?user_Id=$user_Id" ?>" id="registrationForm" method="post">
      <h2>Update Profile</h2>
      <?php
                    if(isset($errors)){
                    if(!empty($errors)){
                                            ?>
                    <div class="alert-danger">
                    <ul>
                    <?php foreach($errors as $error){  ?>
                    <li><?php echo $error?></li>
                <?php  }?>
                    </ul>
            </div>
                <?php }}?>
            <?php if(isset($res)){ ?>
              <p class="alert alert-success">Updated Successfully</p>
            <?php } ?>
      <label for="userName">User Name:</label>
      <input
        type="text"
        id="userName"
        name="userName"
        value="<?php echo $user['user_name'] ?>"
        required
        oninput="validateName(this, 'username just be string not include number and must contain more than 3 leters and must enter first name and last name.')"
      />

      <label for="email">Email:</label>
      <input
        type="email"
        id="email"
        name="email"
        value="<?php echo $user['email'] ?>"
        required
        oninput="validateEmail(this)"
      />

      <label for="file">Upload Image:</label>
      <input
        type="file"
        id="file"
        name="image"
        value="<?php if(!empty($user['image'])) echo $user['image']  ?>"
      />

      <label for="password">Password:</label>
      <input
        type="password"
        id="password"
        name="password"
        required
        oninput="validatePassword(this)"
      />

      <label for="confirmPassword">Confirm Password:</label>
      <input
        type="password"
        id="confirmPassword"
        name="confirmPassword"
        required
        oninput="validateConfirmPassword(this)"
      />

      <input
        type="submit"
        class="input-submit disabled"
        value="Update"
        disabled
      />
      <div class="go-login-page">
        <a href="home.php">go to Home page</a>
      </div>
    </form>

    <script>
      let submit = document.querySelector("input[type='submit']");
      let myForm = document.getElementById('registrationForm');

      function validateName(input, errorMessage) {
        const nameRegex = /^[a-zA-Z]{3,} [a-zA-Z]{3,}$/;
        const isValid = nameRegex.test(input.value);
        displayErrorMessage(input, isValid, errorMessage);
      }

      function validateEmail(input) {
        const emailRegex =
          /^[a-zA-Z]{3,}[0-9]*@(gmail|yahoo|outlook)\.(com|net|org)$/;
        const isValid = emailRegex.test(input.value);
        displayErrorMessage(input, isValid, 'Not a valid email.');
      }

      function validatePassword(input) {
        const passwordRegex =
          /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        const isValid = passwordRegex.test(input.value);
        displayErrorMessage(
          input,
          isValid,
          'Password should be more than 8 letters and contain uppercase, lowercase, number, special characters.'
        );
      }

      function validateConfirmPassword(input) {
        let password = document.getElementById('password');
        const isValid = input.value === password.value;
        displayErrorMessage(input, isValid, 'Passwords do not match.');
      }

      function displayErrorMessage(input, isValid, errorMessage) {
        const errorElement = input.nextElementSibling;
        if (!isValid) {
          if (
            !errorElement ||
            !errorElement.classList.contains('error-message')
          ) {
            const newErrorElement = document.createElement('div');
            newErrorElement.className = 'error-message';
            newErrorElement.textContent = errorMessage;
            input.parentNode.insertBefore(
              newErrorElement,
              input.nextElementSibling
            );
          }
        } else {
          if (
            errorElement &&
            errorElement.classList.contains('error-message')
          ) {
            errorElement.remove();
          }
        }
      }
      let userName = document.getElementById('userName');
      let email = document.getElementById('email');
      let password = document.getElementById('password');
      let confirmPassword = document.getElementById('confirmPassword');
      myForm.addEventListener('input', function () {
        const nameRegex = /^[a-zA-Z]{3,} [a-zA-Z]{3,}$/;
        const emailRegex =
          /^[a-zA-Z]{3,}[0-9]*@(gmail|yahoo|outlook)\.(com|net|org)$/;
        const passwordRegex =
          /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        let isValidUserName = nameRegex.test(userName.value);
        let isValidEmail = emailRegex.test(email.value);
        let isValidPassword = passwordRegex.test(password.value);
        let isValidConfirmPassword = passwordRegex.test(confirmPassword.value);
        if (
          isValidEmail &&
          isValidUserName &&
          isValidPassword &&
          isValidConfirmPassword &&
          confirmPassword.value == password.value
        ) {
          submit.removeAttribute('disabled');
          submit.classList.remove('disabled');
          submit.style.cursor = 'pointer';
        } else {
          submit.setAttribute('disabled', 'disabled');
          submit.classList.add('disabled');
          submit.style.cursor = 'auto';
        }
      });
      // function registerUser() {
      //   const userFromLocalStoreg =
      //     JSON.parse(localStorage.getItem('users')) || [];
      //   const findUser = userFromLocalStoreg.find(
      //     (user) => user.email === email.value
      //   );
      //   console.log(findUser);
      //   findUser.firstName = firstName.value;
      //   findUser.lastName = lastName.value;
      //   findUser.email = email.value;
      //   findUser.password = password.value;
      //   localStorage.setItem('users', JSON.stringify(userFromLocalStoreg));
      // }
      // myForm.addEventListener('submit', function () {
      //   window.location.href = 'home.html';
      // });
    </script>
  </body>
</html>
