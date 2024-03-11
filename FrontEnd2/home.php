<?php
if($_GET['user_Id']){
  $user_Id = $_GET['user_Id'];
}else {
  echo "<h1 style='text-align:center;margin-top:50%'>Wrong page!!</h1>";
  die();
}

include_once './Inc/config.php';
$productsQuery = 'SELECT * FROM product';
$productsResult = $connect->query($productsQuery);
$products = $productsResult->fetchAll(PDO::FETCH_ASSOC);

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
      <a href="home.php?user_Id=<?php echo $user['user_Id'] ?>">
        <img src="img/logo.png" class="logo" alt="" />
      </a>
      <div>
        <ul id="navbar">
          <li><a class="active" href="home.php?user_Id=<?php echo $user['user_Id'] ?>">Home</a></li>
          <li><a id="btnShop" href="shop.php?user_Id=<?php echo $user['user_Id'] ?>">Shop</a></li>
          <li id="lg-bag">
            <a id="btnCart" href="cart.php?user_Id=<?php echo $user['user_Id'];?>"><i class="fa fa-shopping-bag"></i></a>
          </li>
          <a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
        </ul>
      </div>
      <div id="mobile">
        <a href="cart.php?user_Id=<?php echo $user['user_Id'];?>"><i class="fa fa-shopping-bag"></i></a>
        <i id="bar" class="fas fa-outdent"></i>
      </div>
    </section>

    <section id="hero">
      <?php include './Inc/hero.php' ?>
    </section>

    <section id="feature" class="section-p1">
      <?php include './Inc/feature.php' ?>
    </section>

    <section id="product1" class="section-p1">
      <h2>Featured Products</h2>
      <p>Summer Collection New Modern Design</p>
      <div class="pro-container">
      <?php foreach($products as $product){ ?>
        <div class="pro">
          <img src="../admin/assets/products/images/<?php echo $product['image']?>" alt="" />
          <div class="des">
            <span><?php echo $product['category']?></span>
            <h5><?php echo $product['description']?></h5>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h4><?php echo $product['price']?></h4>
            <h1 class="productId" style="display: none;"><?php echo $product['Id']?></h1>
          </div>
          <a href="sProduct?prodict_Id=<?php $product['Id'] ?>"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
        <?php } ?>
      </div>
    </section>

    <section id="banner" class="section-m1">
      <?php include './Inc/banner.php' ?>
    </section>

    <section id="sm-banner" class="section-p1">
      <?php include './Inc/sm-banner.php' ?>
    </section>

    <section id="banner3" class="section-p1">
      <?php include './Inc/banner3.php' ?>
    </section>

    <section id="newsletter" class="section-p1 section-m1">
      <?php include './Inc/newsletter.php' ?>
    </section>
    <footer class="section-p1">
      <?php include './Inc/footer.php' ?>
    </footer>
    <script src="script.js"></script>
    <script>
      <?php include './script2.php' ?>
    </script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const pro = document.querySelectorAll('#product1 .pro');
        const productId = document.querySelectorAll('#product1 .pro .productId');
        for(let i=0;i<pro.length;i++){
          pro[i].addEventListener('click',function(){
            window.location.href = `./sProduct.php?Id=${productId[i].textContent}&user_Id=<?php echo $user['user_Id'] ?>`;
          })
        }
      });
    </script>
  </body>
</html>
