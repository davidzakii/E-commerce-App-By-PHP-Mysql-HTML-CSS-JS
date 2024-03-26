<?php 
if($_GET['Id']){
  $Id = $_GET['Id'];
}else {
  echo "<h1 style='text-align:center;margin-top:50%'>Wrong page!!</h1>";
  die();
}
include_once '../inc/config.php';
include '../inc/validate.php';
$query = "SELECT * FROM product WHERE Id = $Id";
$res = $connect->query($query);
$product = $res->fetch(PDO::FETCH_ASSOC);
if($_SERVER['REQUEST_METHOD']=="POST") {
  //$product_id=$_POST['Product_ID'];
  $name=$_POST['productName'];
  $category=$_POST['category'];
  $description=$_POST['description'];
  $price=$_POST['price'];
  checkBeNumber($price);;
  
  $image=$_FILES['image']['name'];
  if(!empty($image)){
    $tmp=$_FILES['image']['tmp_name'];
    $imageArr=explode(".",$image);
    $ext=end($imageArr);
    $ext=strtolower($ext);
    $allowedExt=['jpg','png','jpeg','bmp'];
    checkExt($ext,$allowedExt);
  }

  if(empty($errors)){
    if(empty($image)){
      $UpdateQuery = "UPDATE `product` SET 
                `name` = :pname,
                `category` = :pcategory,
                `description` = :pdescription,
                `price` = :price
                WHERE `Id` = :Id";
    }else {
      $UpdateQuery = "UPDATE `product` SET 
                `name` = :pname,
                `image` = :pimage,
                `category` = :pcategory,
                `description` = :pdescription,
                `price` = :price
                WHERE `Id` = :Id";
    }
    
    try {
      //$ress=$connect->query($UpdateQuery);
      $timeImage = time().$image;
      $stmt = $connect->prepare($UpdateQuery);
      $stmt->bindParam(':Id', $Id, PDO::PARAM_INT);
      $stmt->bindParam(':pname', $name, PDO::PARAM_STR);
      if(!empty($image)){
        $stmt->bindParam(':pimage', $timeImage, PDO::PARAM_STR);
      }
      $stmt->bindParam(':pcategory', $category, PDO::PARAM_STR);
      $stmt->bindParam(':pdescription', $description, PDO::PARAM_STR);
      $stmt->bindParam(':price', $price, PDO::PARAM_STR);
      $stmt->execute();
      if(isset($stmt)&&!empty($image)){
      $proImage = $product['image'];
      $oldImagePath = "../assets/products/images/$proImage";
        if (file_exists($oldImagePath)&&$image!=$product['image']) {
            unlink($oldImagePath);
            unlink("../../FrontEnd2/img/products/$proImage");
        }
        copy($tmp,"../assets/products/images/".$timeImage);
        copy($tmp,"../../FrontEnd2/img/products/".$timeImage);
      }
    }catch(Exception $e){
      echo $e->getMessage();
    }
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
          <?php
                    if(isset($errors)){
                    if(!empty($errors)){
                                            ?>
                    <div class="alert alert-danger">
                    <ul>
                    <?php foreach($errors as $error){  ?>
                    <li><?php echo $error?></li>
                <?php  }?>
                    </ul>
            </div>
                <?php }}?>
            <?php if(isset($stmt)){ ?>
              <p class="alert alert-success">Update Done</p>
            <?php } ?>
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
              <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?Id='.$Id; ?>">
                  <div class="card-body">
                    <h4 class="card-title">Edit Product</h4>
                    <div class="form-group row">
                      <label
                        for="pname"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Product Name</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          id="pname"
                          name="productName"
                          value="<?php echo $product['name'] ?>"
                          required
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="image"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Add Image</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="file"
                          class="form-control"
                          name='image'
                          id="image"
                          value="<?php echo $product['image'] ?>"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="category"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Category</label
                      >
                      <div class="col-sm-9">
                        <select required name="category" id="category">
                          <option <?php if($product['category']=="Men's Clothing") echo 'selected' ?> value="Men's Clothing">Men's Clothing</option>
                          <option <?php if($product['category']=="Jewelery") echo 'selected' ?> value="Jewelery">Jewelery</option>
                          <option <?php if($product['category']=="Mobile Phone") echo 'selected' ?> value="Mobile Phone">Mobile Phone</option>
                          <option <?php if($product['category']=="Electronics") echo 'selected' ?>  value="Electronics">Electronics</option>
                        </select>
                      </div>
                    </div>
                    <!-- ProDes = productDescription -->
                    <div class="form-group row">
                      <label
                         for="proDes" 
                        class="col-sm-3 text-end control-label col-form-label"
                        >Description</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="Text"
                          class="form-control"
                          id="proDes"
                          name="description"
                          value="<?php echo $product['description'] ?>"
                          required
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="price"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Price</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="Text"
                          class="form-control"
                          id="price"
                          name="price"
                          value="<?php echo $product['price'] ?>"
                          required
                        />
                      </div>
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <input type="submit" value="Update" class="btn-primary">
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
  </body>
</html>
