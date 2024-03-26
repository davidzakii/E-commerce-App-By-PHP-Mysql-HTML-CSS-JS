<?php
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
      <a href="home.php">
        <img src="img/logo.png" class="logo" alt="" />
      </a>
      <div>
        <ul id="navbar">
          <li><a class="active" href="home.php">Home</a></li>
          <li><a id="btnShop" href="shop.php">Shop</a></li>
          <li id="lg-bag">
            <a id="btnCart" href="cart.php"><i class="fa fa-shopping-bag"></i> <span id="cartItemCount"></span></a>
          </li>
          <a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
        </ul>
      </div>
      <div id="mobile">
        <a href="cart.php"><i class="fa fa-shopping-bag"></i></a>
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
          <img src="./img/products/<?php echo $product['image']?>" alt="" />
          <div class="des">
            <span><?php echo $product['category']?></span>
            <h5><?php echo $product['name']?></h5>
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
          <a href="#" class="addCart" 
           data-id="<?php echo $product['Id']; ?>"
           data-title="<?php echo $product['name']; ?>"
           data-price="<?php echo $product['price']; ?>"
           data-image="./img/products/<?php echo $product['image']?>">
           <i class="fa-solid fa-cart-shopping"></i>
          </a>
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
            window.location.href = `./sProduct.php?Id=${productId[i].textContent}`;
          })
        }

        const cartItemCount = document.getElementById('cartItemCount');
        const addCartButtons = document.querySelectorAll('.addCart');
        const user_Id = <?php echo json_encode($user_Id); ?>;
        const cart = JSON.parse(localStorage.getItem(`cart_${user_Id}`)) || [];
          addCartButtons.forEach((button) => {
            button.addEventListener('click', function(event) {
                  event.preventDefault();
                  // Extract product information from data attributes
                  const productId = button.dataset.id;
                  const title = button.dataset.title;
                  const price = button.dataset.price;
                  const image = button.dataset.image;
                  // Your cart handling logic here
                  const cartItem = {
                      id: productId,
                      title: title,
                      quantity: 1,
                      price: price,
                      image: image
                  };
                  // Add the item to the cart
                  addToCart(cartItem);
                  alert('Item added to the cart!');
                  updateCartCount();
                  event.stopPropagation();
            });
          });

          function addToCart(item) {
            const cart = JSON.parse(localStorage.getItem(`cart_${user_Id}`)) || [];
            const existingItem = cart.find(cartItem => cartItem.id === item.id);
            if (existingItem) {
            // If item already exists in the cart, update quantity and price
            existingItem.quantity++;
            } else {
            // If item doesn't exist in the cart, add it
            cart.push(item);
            }
            // Update the cart in local storage
            localStorage.setItem(`cart_${user_Id}`, JSON.stringify(cart));
          }
              // Function to update the cart count display
        function updateCartCount() {
          const cart = JSON.parse(localStorage.getItem(`cart_${user_Id}`)) || [];
          const totalCount = cart.reduce((total, item) => total + item.quantity, 0);
          // Update the cart count element on the page
          if (cartItemCount) {
          cartItemCount.textContent = totalCount;
          }
        }
        // Initial update of the cart count when the page loads
        updateCartCount();
      });
    </script>
  </body>
</html>
