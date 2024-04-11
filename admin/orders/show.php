<?php 
if(isset($_GET['code'])){
//echo $_GET['Id'];
$code = $_GET['code'];
}else {
    echo "<h2 align='center'>Wrong Page</h2>";
    die();
}
include_once '../inc/config.php';
$query = "SELECT `order`.code, `order`.`date`, product.name AS product_name, product.price, users.user_name,isPaid,delivered FROM `order` LEFT JOIN product ON `order`.product_id = product.Id LEFT JOIN users ON `order`.user_id = users.user_Id WHERE code =$code;";
$result = $connect->query($query);
$order = $result->fetch(PDO::FETCH_ASSOC);
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
                  <h5 class="card-title">Order : <?php echo $order['user_name'] ?></h5>
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <tbody>
                        <tr>
                          <th>code</th>
                          <td><?php echo $order['code'] ?></td>
                        </tr>
                        <tr>
                          <th>date</th>
                          <td><?php echo $order['date'] ?></td>
                        </tr>
                        <tr>
                          <th>Product Name</th>
                          <td><?php echo $order['product_name'] ?></td>
                        </tr>
                        <tr>
                          <th>Product Price</th>
                          <td><?php echo $order['price'] ?></td>
                        </tr>
                        <tr>
                          <th>User Name</th>
                          <td><?php echo $order['user_name'] ?></td>
                        </tr>
                        <tr>
                          <th>Is Paid</th>
                          <td><?php echo $order['isPaid'] ?></td>
                          <td>
                            <?php if($order['isPaid'] == 0){ ?>
                              <button id="btnPaid" class="btn btn-danger">NoPaid</button>
                            <?php }else { ?>
                              <button id="btnPaid" class="btn btn-success">Paid</button>
                            <?php }?>
                        </td>
                        </tr>
                        <tr>
                          <th>Diliverd</th>
                          <td><?php echo $order['delivered'] ?></td>
                          <td>
                            <?php if($order['delivered']==0){ ?>
                              <button id="btnDiliverd" class="btn btn-danger">NoDiliverd</button>
                            <?php }else { ?>
                              <button id="btnDiliverd" class="btn btn-success">Diliverd</button>
                            <?php } ?>
                          </td>
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
    <script>
    var code = <?php echo json_encode($order['code']); ?>;
    var isPaid = <?php echo $order['isPaid']; ?>;
    var isDelivered = <?php echo $order['delivered']; ?>;

    function updateOrder(code, isPaid, isDelivered) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_order.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Refresh the page after updating the order
                window.location.reload();
            }
        };
        xhr.send("code=" + code + "&isPaid=" + isPaid + "&isDelivered=" + isDelivered);
    }

    var btnPaid = document.getElementById('btnPaid');
    var btnDiliverd = document.getElementById('btnDiliverd');

    btnPaid.addEventListener('click', function() {
        isPaid = isPaid ? 0 : 1; // Toggle isPaid value
        btnPaid.innerText = isPaid ? "Paid" : "NoPaid"; // Update button text
        btnPaid.classList.toggle('btn-success'); // Toggle button class
        btnPaid.classList.toggle('btn-danger'); // Toggle button class
        updateOrder(code, isPaid, isDelivered);
    });

    btnDiliverd.addEventListener('click', function() {
        isDelivered = isDelivered ? 0 : 1; // Toggle isDelivered value
        btnDiliverd.innerText = isDelivered ? "Delivered" : "NoDelivered"; // Update button text
        btnDiliverd.classList.toggle('btn-success'); // Toggle button class
        btnDiliverd.classList.toggle('btn-danger'); // Toggle button class
        updateOrder(code, isPaid, isDelivered);
    });
</script>

  </body>
</html>
