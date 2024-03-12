<?php
session_start();
if(!isset($_SESSION['user_Id'])&&!isset($_COOKIE['user_Id'])){
  header('location: LoginPage.php');
}
if(isset($_GET['Id'])){
  //echo $_GET['Id'];
$Id = $_GET['Id'];
if(isset($_SESSION['user_Id'])){
  $user_Id = $_SESSION['user_Id'];
}
if(isset($_COOKIE['user_Id'])){
  $user_Id = $_COOKIE['user_Id'];
}
}else {
  echo "<h2 align='center'>Wrong Page</h2>";
  die();
}

include_once './Inc/config.php';
$query = "SELECT * FROM product WHERE Id=$Id";
$result = $connect->query($query);
$product = $result->fetch(PDO::FETCH_ASSOC);

$userQuery = "SELECT * FROM users WHERE `user_Id`= '$user_Id'";
$userResult = $connect->query($userQuery);
$user = $userResult->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
   <?php include './Inc/head.php' ?>
  </head>
  <body>
    <section id="header">
      <a href="#">
        <img src="img/logo.png" class="logo" alt="" />
      </a>

      <div>
        <ul id="navbar">
          <li><a id="btnHome" href="./home.php">Home</a></li>
          <li><a id="btnCart" class="active" href="./shop.php">Shop</a></li>
          <li id="lg-bag">
            <a href="cart.php"><i class="fa fa-shopping-bag"></i></a>
          </li>
          <a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
        </ul>
      </div>
      <div id="mobile">
        <a href="cart.html"><i class="fa fa-shopping-bag"></i></a>
        <i id="bar" class="fas fa-outdent"></i>
      </div>
    </section>

    <section id="prodetails" class="section-p1">
        <div class="single-pro-image">
            <img src="../admin/assets/products/images/<?php echo $product['image']?>" alt="" width="100%" id="mainImg" />
        </div>
        <div class="single-pro-details">
        <h6><?php echo $product['category']?></h6>
        <h2 id='totalPrice'>$<?php echo $product['price']?></h2>
        <span id="quantityInputContainer"></span>
        <span><button class="normal">Add To Cart</button>
        <h4>Product Details</h4>
        <span>
        <?php echo $product['description']?>
        </span>
      </div>
    </section>
    <section id="newsletter" class="section-p1 section-m1">
      <?php include './Inc/newsletter.php' ?>
    </section>

    <footer class="section-p1">
      <?php include './Inc/footer.php' ?>
    </footer>
    <script>
      <?php include './script2.php' ?>
    </script>
  </body>
</html>
