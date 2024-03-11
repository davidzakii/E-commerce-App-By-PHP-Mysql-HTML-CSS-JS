<?php
include_once '../inc/config.php';
$usersQuery = 'SELECT `user_Id`,`user_name` FROM users';
$usersResult = $connect->query($usersQuery);
$users = $usersResult->fetchAll(PDO::FETCH_ASSOC);

$productsQuery = 'SELECT `Id`,`name` FROM product';
$productsResult = $connect->query($productsQuery);
$products = $productsResult->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD']=="POST"){
$orderUser = $_POST['orderUser'];
$orderProduct = $_POST['orderProduct'];
$orderDate = $_POST['orderDate'];
$orderQuery = "INSERT INTO `order`(`date`,`product_id`,`user_id`) VALUES ('$orderDate',$orderProduct,$orderUser)";
try{
  $orderResult = $connect->query($orderQuery);
}catch(PDOException $e){
  echo "Error: " . $e->getMessage();
  die();
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
              <h4 class="page-title">Add Order</h4>
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
                <?php if(isset($orderResult)){ ?>
                  <p class="alert alert-success">Order Created</p>
                <?php } ?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="form-horizontal" method="post">
                  <div class="card-body">
                    <h4 class="card-title">Add Order</h4>
                    <div class="form-group row">
                      <label
                        for="orderUser"
                        class="col-sm-3 text-end control-label col-form-label"
                        >User Name</label
                      >
                      <div class="col-sm-9">
                        <select required name="orderUser" id="orderUser">
                          <?php foreach($users as $user){ ?>
                          <option value="<?php echo $user['user_Id'] ?>"><?php echo $user['user_name'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="orderProduct"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Product Name</label
                      >
                      <div class="col-sm-9">
                        <select required name="orderProduct" id="orderProduct">
                          <?php foreach($products as $product){ ?>
                          <option value="<?php echo $product['Id'] ?>"><?php echo $product['name'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    <div class="form-group row">
                      <label
                        for="orderDate"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Current Date</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="datetime-local"
                          class="form-control"
                          id="orderDate"
                          name="orderDate"
                          required
                          readonly
                        />
                      </div>
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                    <input type="submit" value="Create" class="btn-primary">
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
    <script>
        function updateDateTime() {
                    const now = new Date();
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const day = String(now.getDate()).padStart(2, '0');
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    const second = String(now.getSeconds()).padStart(2, '0');
                    const currentDatetime = `${year}-${month}-${day}T${hours}:${minutes}:${second}`;
                    // Set the value for the input field
                    document.getElementById('orderDate').value = currentDatetime;
        }
        // Update the date and time every second (1000 milliseconds)
        setInterval(updateDateTime, 1000);
        // Initial update
        updateDateTime();
    </script>
  </body>
</html>
