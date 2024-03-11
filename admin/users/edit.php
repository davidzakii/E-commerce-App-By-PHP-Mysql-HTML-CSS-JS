<!-- <?php 
 if($_GET['user_Id']){
    $user_Id = $_GET['user_Id'];
 }else {
    echo "<h1 style='text-align:center;margin-top:50%'>Wrong page!!</h1>";
    die();
 }
include_once '../inc/config.php';
$userQuery = "SELECT * FROM `users` WHERE `user_Id`= $user_Id";
$userResult = $connect->query($userQuery);
$user = $userResult->fetch(PDO::FETCH_ASSOC);
if($_SERVER['REQUEST_METHOD']=='POST'){
  include_once '../inc/validate.php';
  // $usersEmailsQuery = 'SELECT `email` FROM users';
  // $usersEmailsResult = $connect->query($usersEmailsQuery);
  // $usersEmails = $usersEmailsResult->fetchAll(PDO::FETCH_ASSOC);

  $userName = $_POST['userName'];
  $email = $_POST['email'];
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
    $updateQuery = "UPDATE `users` SET 
                `user_name` = '$userName',
                `email` = '$email',
                `password` = '$password'
                WHERE `user_Id` = $user_Id";
    try{
      $res = $connect->query($updateQuery);
    }catch (PDOException $e){
      echo "Error: " . $e->getMessage();
    }
  }
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <?php include '../inc/head.php' ?>
  </head>
  <body>
    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
      <header class="topbar" data-navbarbg="skin5">
        <?php include '../inc/nav.php' ?>
      </header>
      <aside class="left-sidebar" data-sidebarbg="skin5">
        <?php include '../inc/aside.php' ?>
      </aside>
      <div class="page-wrapper">
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Add User</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Library
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
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
              <p class="alert alert-success">Update Successfully</p>
            <?php } ?>
                <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?user_Id=$user_Id"; ?>">
                  <div class="card-body">
                    <h4 class="card-title">Add User</h4>
                    <div class="form-group row">
                      <label
                        for="userName"
                        class="col-sm-3 text-end control-label col-form-label"
                        >User Name</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          id="userName"
                          name="userName"
                          value="<?php echo $user['user_name'] ?>"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="email"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Email</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          id="email"
                          name="email"
                          value="<?php echo $user['email'] ?>"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="pass"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Password</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="password"
                          class="form-control"
                          id="pass"
                          name="password"
                          placeholder="Password Here"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="conPass"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Confirm Password</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="password"
                          class="form-control"
                          id="conPass"
                          name="confirmPassword"
                          placeholder="Confirm Password Here"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                    <input type="submit" value="Update" class="btn-primary">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <footer class="footer text-center">
          <?php include '../inc/footer.php' ?>
        </footer>
      </div>
    </div>
    <?php include '../inc/scripts.php'; ?>
  </body>
</html> -->
