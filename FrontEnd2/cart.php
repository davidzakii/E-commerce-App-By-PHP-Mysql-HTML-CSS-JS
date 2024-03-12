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
  $userQuery = "SELECT * FROM users WHERE `user_Id`= '$user_Id'";
  $userResult = $connect->query($userQuery);
  $user = $userResult->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once './Inc/head.php' ?>
  </head>
  <body>
    <section id="header">
      <a href="home.php">
        <img src="img/logo.png" class="logo" alt="" />
      </a>

      <div>
        <ul id="navbar">
          <li><a id="btnHome" href="home.php">Home</a></li>
          <li><a id="btnShop" href="shop.php">Shop</a></li>
          <li id="lg-bag">
            <a class="active" href="cart.php"
              ><i class="fa fa-shopping-bag"></i
            ></a>
          </li>
          <a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
        </ul>
      </div>
      <div id="mobile">
        <a class="active" href="cart.php"
          ><i class="fa fa-shopping-bag"></i
        ></a>
        <i id="bar" class="fas fa-outdent"></i>
      </div>
    </section>

    <section id="cart" class="section-p1">
      <table width="100%">
        <thead>
          <tr>
            <th>Title</th>
            <th>Price</th>
            <th>Image</th>
            <th>Quantity</th>
            <th>Remove</th>
          </tr>
        </thead>
        <tbody id="cartTableBody">
          <!-- Cart items will be dynamically added here -->
        </tbody>
      </table>
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
      document.addEventListener('DOMContentLoaded', displayCart);
      function displayCart() {
        // Get cart data from localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        // Get the table body element
        const cartTableBody = document.getElementById('cartTableBody');

        // Clear existing rows in the table
        cartTableBody.innerHTML = '';

        // Populate the table with cart items
        cart.forEach((item) => {
          const row = document.createElement('tr');

          // Add columns for title, price, image, quantity, and remove button
          row.innerHTML = `
            <td>${item.title}</td>
            <td>${item.price}</td>
            <td><img src="${item.image}" alt="${item.title}" style="width: 50px;"></td>
            <td>${item.quantity}</td>
            <td><button onclick="removeFromCart('${item.title}')">Remove</button></td>
        `;

          // Append the row to the table
          cartTableBody.appendChild(row);
        });
      }

      function removeFromCart(title) {
        // Get the cart data from localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Remove the item from the cart by filtering it out
        cart = cart.filter((item) => item.title !== title);

        // Save the updated cart data to localStorage
        localStorage.setItem('cart', JSON.stringify(cart));

        // Refresh the cart display on the page
        displayCart();
      }
    </script>
  </body>
</html>
