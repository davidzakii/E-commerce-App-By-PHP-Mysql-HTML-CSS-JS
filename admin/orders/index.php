<?php 
include_once '../inc/config.php'; 
$query = "SELECT `order`.code, `order`.`date`, product.name AS product_name, product.price, users.user_name,isPaid,delivered FROM `order` LEFT JOIN product ON `order`.product_id = product.Id LEFT JOIN users ON `order`.user_id = users.user_Id;";
$result = $connect->query($query);
$orders = $result->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
          <?php 
          include '../inc/head.php';
          ?>
          <link
          href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
          rel="stylesheet"
          />
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
        <?php  
        include '../inc/nav.php';
        ?>
      </header>
      <aside class="left-sidebar" data-sidebarbg="skin5">
        <?php include '../inc/aside.php' ?>;
      </aside>
      <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Tables</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      <a href="create.php">Add New</a>
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
          <!-- ============================================================== -->
          <!-- Start Page Content -->
          <!-- ============================================================== -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Users</h5>
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Code</th>
                          <th>Date</th>
                          <th>Product Name</th>
                          <th>Product Price</th>
                          <th>User Name</th>
                          <th>IsPaid</th>
                          <th>delivered</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($orders as $order){ ?>
                            <tr>
                                <td><?php echo $order['code'] ?></td>
                                <td><?php  echo $order['date'] ?></td>
                                <td><?php  echo $order['product_name'] ?></td>
                                <td><?php  echo $order['price'] ?></td>
                                <td><?php  echo $order['user_name'] ?></td>
                                <td><?php  echo $order['isPaid'] ?></td>
                                <td><?php  echo $order['delivered'] ?></td>
                                <td style="display: flex;gap:5px;width: 100%;height:100%">
                                <a href="show.php?code=<?php echo $order['code'] ?>" class="btn btn-primary">Show</a>
                                <a href="edit.php?code=<?php echo $order['code'] ?>" class="btn btn-success">Edit</a>
                                <a  class="btn btn-danger confirm">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>Code</th>
                          <th>Date</th>
                          <th>Product Name</th>
                          <th>Product Price</th>
                          <th>User Name</th>
                          <th>IsPaid</th>
                          <th>delivered</th>
                        </tr>
                      </tfoot>
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
    <script src="../assets/extra-libs/DataTables/datatables.min.js"></script>
    <script>
      /****************************************
       *       Basic Table                   *
       ****************************************/
      $('#zero_config').DataTable();
    </script>
    <script>
      var deleteOrder = document.getElementsByClassName('confirm');
        for(let i=0;i<deleteOrder.length;i++){
        deleteOrder[i].addEventListener('click',function(){
          var confirmUser = confirm('Are you sure');
          if(confirmUser){
          deleteOrder[i].href="delete.php?code=<?php echo $order['code'] ?>";
          }else {
            return false;
          }
        })
      }

    </script>
  </body>
</html>
