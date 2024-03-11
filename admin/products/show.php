<?php 
if(isset($_GET['Id'])){
  //echo $_GET['Id'];
$Id = $_GET['Id'];
  
}else {
  echo "<h2 align='center'>Wrong Page</h2>";
  die();
}
include_once '../inc/config.php';
$query = "SELECT * FROM product WHERE Id=$Id";
$result = $connect->query($query);
$product = $result->fetch(PDO::FETCH_ASSOC);
// var_dump($product);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <?php include '../inc/head.php' ?>
    <style>
      table {
        margin-bottom: 0px !important;
      }
      th {
        width: 25% !important;
        background-color: #1f262d !important;
        color: #fff !important;
        font-weight: bold;

      }
    </style>
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
              <h4 class="page-title">Form Basic</h4>
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
                <div class="card-body">
                  <h5 class="card-title">All Products</h5>
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <tbody>
                        <tr>
                          <th>Id</th>
                          <td><?php echo $product['Id'] ?></td>
                        </tr>
                        <tr>
                          <th>name</th>
                          <td><?php echo $product['name'] ?></td>
                        </tr>
                        <tr>
                          <th>image</th>
                          <td> <img style="width:100px;justify-content:center;align-items:center" src="../assets/products/images/<?php echo $product['image'] ?>" alt=""></td>
                        </tr>
                        <tr>
                          <th>category</th>
                          <td><?php echo $product['category'] ?></td>
                        </tr>
                        <tr>
                          <th>description</th>
                          <td><?php echo $product['description'] ?></td>
                        </tr>
                        <tr>
                          <th>price</th>
                          <td><?php echo $product['price'] ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
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
