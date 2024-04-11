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
    <style>
      .btn-delete{
        padding: 5px;
        background-color:  #ec9999;
        border-color: #ec9999;
      }
      .btn-delete:hover{
        background-color:  red;
      }
      table {
        width: 100%;
      }
      table th {
        text-align: start;
        width: 20%;
        padding: 20px;
      }
      table td {
        padding: 20px;
        border: 2px solid #eee;
      }
    </style>
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
              ><i class="fa fa-shopping-bag"></i> <span id="cartItemCount"></span>
            </a>
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
            <th>Total Price</th>
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

    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID"></script>
    <div id="paypal-button-container"></div>

    <footer class="section-p1">
      <?php include './Inc/footer.php' ?>
    </footer>
    <script src="script.js"></script>
    <script>
      <?php include './script2.php' ?>
    </script>
    <script>
      document.addEventListener('DOMContentLoaded', displayCart);
      const cartItemCount = document.getElementById('cartItemCount');
      function displayCart() {
        const user_Id = <?php echo json_encode($user_Id); ?>;
        // Get cart data from localStorage
        let cart = JSON.parse(localStorage.getItem(`cart_${user_Id}`)) || [];
        // Get the table body element
        const cartTableBody = document.getElementById('cartTableBody');
        // Clear existing rows in the table
        cartTableBody.innerHTML = '';
        // Populate the table with cart items
        cart.forEach((item) => {
          const row = document.createElement('tr');
          const totlaPrice = item.price * item.quantity;
          // Add columns for title, price, image, quantity, and remove button
          row.innerHTML = `
            <td>${item.title}</td>
            <td>${item.price}$</td>
            <td><img src="${item.image}" alt="${item.title}" style="width: 50px;"></td>
            <td><input type='number' value='${item.quantity}' data-id='${item.id}' class='quantityInput'></td>
            <td>${totlaPrice}$</td>
            <td><button class='btn-delete' onclick="removeFromCart('${item.id}')">Remove</button></td>
        `;
          // Append the row to the table
          cartTableBody.appendChild(row);
          updateCartCount();
          attachQuantityChangeListeners();
          
        });
      }

      function removeFromCart(id) {
        const user_Id = <?php echo json_encode($user_Id); ?>;
        // Get the cart data from localStorage
        let cart = JSON.parse(localStorage.getItem(`cart_${user_Id}`)) || [];
        // Remove the item from the cart by filtering it out
        cart = cart.filter((item) => item.id !== id);
        // Save the updated cart data to localStorage
        localStorage.setItem(`cart_${user_Id}`, JSON.stringify(cart));
        // Refresh the cart display on the page
        if(cartItemCount.textContent == 1){
          cartItemCount.textContent = parseInt(cartItemCount.textContent) - 1;
        }
        displayCart();
      };

      function updateCartCount() {
          const user_Id = <?php echo json_encode($user_Id); ?>;
          const cart = JSON.parse(localStorage.getItem(`cart_${user_Id}`)) || [];
          const totalCount = cart.reduce((total, item) => total + item.quantity, 0);
          // Update the cart count element on the page
          if (cartItemCount) {
          cartItemCount.textContent = totalCount;
          }
        }
        updateCartCount();

        function attachQuantityChangeListeners() {
            const quantityInputs = document.querySelectorAll('.quantityInput');
            quantityInputs.forEach((input) => {
                input.addEventListener('input', function () {
                    const newQuantity = parseInt(input.value);
                    const productId = input.dataset.id;
                    if (newQuantity > 0) {
                      updateCartQuantity(productId, newQuantity);
                    } else {
                   // Reset the input value to 1 if the user tries to set it to 0 or a negative number
                      input.value = 1;
                    }
                });
            });
        }
        function updateCartQuantity(productId, newQuantity) {
            const user_Id = <?php echo json_encode($user_Id); ?>;
            let cart = JSON.parse(localStorage.getItem(`cart_${user_Id}`)) || [];
            const cartItem = cart.find((item) => item.id == productId);
            if (cartItem) {
                cartItem.quantity = newQuantity;
                localStorage.setItem(`cart_${user_Id}`, JSON.stringify(cart));
                displayCart(); // Update the displayed cart
            }
        }

        paypal.Buttons({
          createOrder: function(data, actions) {
            // Set up the transaction details
            return actions.order.create({
              purchase_units: [{
              amount: {
              value: '10.00' // Total amount
              }
              }]
            });
          },
          onApprove: function(data, actions) {
            // Capture the transaction when the customer approves the payment
            return actions.order.capture().then(function(details) {
            // Handle successful payment
            });
          }
        }).render('#paypal-button-container');

        // Stripe integration
        document.getElementById('checkout-button').addEventListener('click', function() {
        // Call your server-side code to create a Stripe Checkout Session
        fetch('/create-checkout-session', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
            items: [
            { id: 'item1', quantity: 1 },
            { id: 'item2', quantity: 2 }
            ]
            })
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(session) {
        // Redirect to Stripe Checkout
            return stripe.redirectToCheckout({ sessionId: session.id });
        })
        .then(function(result) {
        if (result.error) {
        // Handle errors
        }
        })
        .catch(function(error) {
        console.error('Error:', error);
        });
        });
    </script>
  </body>
</html>
