<?php
include_once 'Inc/config.php';
$query = 'SELECT * FROM product';
$result = $connect->query($query);
$products = $result->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'Inc/head.php'?>
  </head>
  <body>
    <section id="header">
      <?php include './Inc/header.php' ?>
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
          </div>
          <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
        <?php } ?>
      </div>
    </section>

    <section id="banner" class="section-m1">
      <?php include './Inc/banner.php' ?>
    </section>

    <section id="product2" class="section-p1">
      <h2>New Arrivals</h2>
      <p>Summer Collection New Modern Design</p>
      <div class="pro-container">
        <div class="pro">
          <img src="img//products/n1.jpg" alt="" />
          <div class="des">
            <span>adidas</span>
            <h5>Carton Astronaut T-shirts</h5>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h4>$78</h4>
          </div>
          <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
        <div class="pro">
          <img src="img//products/n2.jpg" alt="" />
          <div class="des">
            <span>adidas</span>
            <h5>Carton Astronaut T-shirts</h5>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h4>$78</h4>
          </div>
          <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
        <div class="pro">
          <img src="img//products/n3.jpg" alt="" />
          <div class="des">
            <span>adidas</span>
            <h5>Carton Astronaut T-shirts</h5>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h4>$78</h4>
          </div>
          <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
        <div class="pro">
          <img src="img//products/n4.jpg" alt="" />
          <div class="des">
            <span>adidas</span>
            <h5>Carton Astronaut T-shirts</h5>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h4>$78</h4>
          </div>
          <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
        <div class="pro">
          <img src="img//products/n5.jpg" alt="" />
          <div class="des">
            <span>adidas</span>
            <h5>Carton Astronaut T-shirts</h5>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h4>$78</h4>
          </div>
          <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
        <div class="pro">
          <img src="img//products/n6.jpg" alt="" />
          <div class="des">
            <span>adidas</span>
            <h5>Carton Astronaut T-shirts</h5>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h4>$78</h4>
          </div>
          <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
        <div class="pro">
          <img src="img//products/n7.jpg" alt="" />
          <div class="des">
            <span>adidas</span>
            <h5>Carton Astronaut T-shirts</h5>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h4>$78</h4>
          </div>
          <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
        <div class="pro">
          <img src="img//products/n8.jpg" alt="" />
          <div class="des">
            <span>adidas</span>
            <h5>Carton Astronaut T-shirts</h5>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h4>$78</h4>
          </div>
          <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
      </div>
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
      let aLimitFeatuerUser = document.querySelectorAll('.pro-container .pro a i');
          for (let i = 0; i < aLimitFeatuerUser.length; i++) {
               aLimitFeatuerUser[i].addEventListener('click', (e) => {
               alert('please login in to get more feature');
               e.preventDefault();
          });
      }
    </script>
  </body>
</html>
