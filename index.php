<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified CSS & JS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<script src="//code.jquery.com/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<title>Order List</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php include 'connect.php'; ?>
                
                <form action="buy.php" method="POST" class="form-inline" role="form">
                    <table class="table table-hover">
                        <tr>
                            <th>Select</th>
                            <th>ID</th>
                            <th>Name Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                        
                        <?php
                        $result = $connect->query("SELECT * FROM `price_list_product`") or die(mysqli_error($connect));
                        while ($row = mysqli_fetch_array($result)) { ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="product-checkbox" data-price="<?=$row['price'];?>" name="products[]" value="<?=$row['id'];?>">
                                </td>
                                <td><?=$row['id'];?></td>
                                <td><?=$row['items'];?></td>
                                <td>$<span class="price"><?=$row['price'];?></span></td>
                                <td>
                                    <input type="number" class="quantity" name="quantity[<?=$row['id'];?>]" min="1" value="1" data-price="<?=$row['price'];?>" disabled>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                    <br>
       
                <hr />
              <h1>Select Data User</h1>
                    <table class="table table-hover">
                        <tr>
                            <th>Select</th>
                            <th>ID</th>
                            <th>Last Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Zip</th>
                            <th>Phone</th>
                            <th>Email</th>
                        </tr>
                        
                        <?php
                        $results = $connect->query("SELECT * FROM `data_info_user`") or die(mysqli_error($connect));
                        while ($rows = mysqli_fetch_array($results)) { ?>
                            <tr>
                                <td>
                                    <input type="radio" class="user-radio" name="user" value="<?=$rows['id'];?>">
                                </td>
                                <td><?=$rows['id'];?></td>
                                <td><?=$rows['last_name'];?></td>
                                <td><?=$rows['address'];?></td>
                                <td><?=$rows['city'];?></td>
                                <td><?=$rows['state'];?></td>
                                <td><?=$rows['zip'];?></td>
                                <td><?=$rows['phone1'];?></td>
                                <td><?=$rows['email'];?></td>
                               
                            </tr>
                        <?php } ?>
                    </table>
                    <br>

                    <h3>Total amount : $<span id="total-price">0.00</span></h3>

                    <button type="submit" class="btn btn-primary">Buy</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function(){
        $(".product-checkbox").change(function(){
            var row = $(this).closest("tr");
            var quantityInput = row.find(".quantity");

            if ($(this).is(":checked")) {
                quantityInput.prop("disabled", false);
            } else {
                quantityInput.prop("disabled", true);
                quantityInput.val(1);
            }

            updateTotal();
        });

        // Khi số lượng thay đổi
        $(".quantity").on("input", function(){
            updateTotal();
        });

        function updateTotal() {
            var total = 0;
            
            $(".product-checkbox:checked").each(function(){
                var row = $(this).closest("tr");
                var price = parseFloat($(this).attr("data-price"));
                var quantity = parseInt(row.find(".quantity").val());

                if (!isNaN(quantity) && quantity > 0) {
                    total += price * quantity;
                }
            });
            $("#total-price").text(total.toFixed(2));
        }
    });
</script>
</body>

</html>