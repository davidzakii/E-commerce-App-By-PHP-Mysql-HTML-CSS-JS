<?php 
include_once '../inc/config.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
  include_once '../inc/validate.php';
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
    $timeImage = time().$image;
    checkExt($ext,$allowedExt);
  }
  $password = sha1($_POST['password']);
  $conPassword = sha1($_POST['confirmPassword']);
  checkName($userName);
  checkEmail($email);
  duplicateEmail($email);
  checkpassword($password,$conPassword);

  // foreach($usersEmails as $userEmail){
  //   if($email == $userEmail['email']){
  //     global $errors;
  //     $errors['existEmail']='Email Already Exist';
  //   }
  // }

  if(empty($errors)){
    if(empty($image)){
      $query = "INSERT INTO `users` ( `user_name`, `email`, `password`)  VALUES ('$userName','$email','$password') ";
    }else {
      copy($tmp_name,"../assets/users/".$timeImage);
      copy($tmp_name,"../../FrontEnd2/img/users/".$timeImage);
      $query = "INSERT INTO `users` ( `user_name`, `email`, `password`,`image`)  VALUES ('$userName','$email','$password','$timeImage') ";
    }
    try{
      $res = $connect->query($query);
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
              <p class="alert alert-success">Add Successfully</p>
            <?php } ?>
                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                  <div class="card-body">
                    <h4 class="card-title">Add User</h4>
                    <div class="form-group row">
                      <label
                        for="userName"
                        class="col-sm-3 text-end control-label col-form-label"
                        >User Name (<span style="color: red;">*</span>)</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          id="userName"
                          name="userName"
                          placeholder="Enter Your Name Here"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="email"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Email (<span style="color: red;">*</span>)</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          id="email"
                          name="email"
                          placeholder="Enter Your  Email Here"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="image"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Add Image</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="file"
                          class="form-control"
                          name='image'
                          id="image"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="pass"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Password (<span style="color: red;">*</span>)</label
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
                        >Confirm Password (<span style="color: red;">*</span>)</label
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
                    <input type="submit" value="Create" class="btn-primary">
                    <span>Every input has red * is rquired </span>
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
</html>
