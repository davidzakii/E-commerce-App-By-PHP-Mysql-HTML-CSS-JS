<?php 
if($_GET['user_Id']){
  $user_Id = $_GET['user_Id'];
}else {
  echo "<h1 style='text-align:center;margin-top:50%'>Wrong page!!</h1>";
  die();
}
include_once './Inc/config.php';
$productQuery = "SELECT * FROM `product`";
$productResult = $connect->query($productQuery);
$products = $productResult->fetchAll(PDO::FETCH_ASSOC);

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
          <li><a id="btnHome"  href="home.php?user_Id=<?php echo $user['user_Id'] ?>">Home</a></li>
          <li><a id="btnShop" class="active" href="shop.php?user_Id=<?php echo $user['user_Id'] ?>">Shop</a></li>
          <li id="lg-bag">
            <a id="btnCart" href="cart.php?user_Id=<?php echo $user['user_Id'];?>"><i class="fa fa-shopping-bag"></i></a>
          </li>
          <a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
        </ul>
      </div>
      <div id="mobile">
        <a id="btnManuCart" href="cart.php?user_Id=<?php echo $user['user_Id'];?>"><i class="fa fa-shopping-bag"></i></a>
        <i id="bar" class="fas fa-outdent"></i>
      </div>
    </section>

    <section id="page-header">
      <h2>#stayhome</h2>
      <p>Save more with coupons & up to 70% off!</p>
    </section>

    <section id="product1" class="section-p1">
      <div class="pro-container">
        <?php foreach($products as $product) { ?>
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
          <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
        <?php } ?>
      </div>
    </section>

    <!-- <section id="pagination" class="section-p1"></section> -->
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
