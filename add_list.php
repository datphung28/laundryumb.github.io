<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Latest compiled and minified CSS & JS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  <title>Add list Product</title>
</head>
<?php
include'connect.php';
if (isset($_POST['add_products'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
      if ($name == "" || $price == "") {
        exit("Do not leave data blank");
      }else{
       $query = "INSERT INTO `price_list_product` (`items`, `price`) VALUES ('$name', '$price')";
      $result = mysqli_query($connect,$query); 
       if( $result )
       {
          echo 'Success';
       }
       else
       {
          echo 'Query Failed';
      }
}
}
?>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
                <div class="row">
                  <div class="col-xl-12">
                    <div class="row">
                      <div class="col-xl-12">
                        <!--begin::Mixed Widget 10-->
                        <div class="card card-custom gutter-b example example-compact">
                        <div class="col-lg-12">
                           <div class="card-body">
                              <div class="table-responsive">
                                <table class="table">
                                <form action="" method="POST" role="form">
                                  <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="" required="required" placeholder="Pls input name Products" title="Pls input name Products">
                                    </div>
                                  <div class="form-group">
                                    <label for="">Price</label>
                                    <input type="text" name="price" id="price" class="form-control" value="" required="required" placeholder="Pls input Price Products" title="Pls input Price Products">
                                  </div>
                                  <button type="submit" name="add_products" class="btn btn-primary">Add</button>
                                </form>
                                </table>
                              </div>
                            </div>
                         </div>
                       </div>
                      </div>
                    </div>
                  </div>
                </div>