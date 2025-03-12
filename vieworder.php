<?php
include 'connect.php';
error_reporting(0);

if (!isset($_GET['order_id'])) {
    die("Order not found!");
}

$order_id = intval($_GET['order_id']); 
$order_query = $connect->prepare("
    SELECT o.order_id, o.total_price, o.order_date, 
           u.last_name, u.address, u.city, u.state, u.zip, u.phone1, u.email
    FROM order_list o
    JOIN data_info_user u ON o.user_id = u.id
    WHERE o.order_id = ?
");
$order_query->bind_param("i", $order_id);
$order_query->execute();
$order = $order_query->get_result()->fetch_assoc();
$order_query->close();

if (!$order) {
    die("Order does not exist!");
}

// Chuyển đổi múi giờ sang Mỹ (New York)
date_default_timezone_set('America/New_York');
$order_date_usa = date("Y-m-d h:i A", strtotime($order['order_date'])); 

$product_query = $connect->prepare("
    SELECT p.items, d.quantity, d.price
    FROM order_details d
    JOIN price_list_product p ON d.product_id = p.id
    WHERE d.order_id = ?
");
$product_query->bind_param("i", $order_id);
$product_query->execute();
$products = $product_query->get_result();
$product_query->close();

$width = 800;
$height = 450 + (mysqli_num_rows($products) * 40);
$image = imagecreate($width, $height);

$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$gray = imagecolorallocate($image, 200, 200, 200);

$font = __DIR__ . '/Arial.ttf';
if (!file_exists($font)) {
    $font = __DIR__ . '/LiberationSans-Regular.ttf'; // 
}

// Tiêu đề
imagettftext($image, 20, 0, 250, 50, $black, $font, "Bill Order #"  . $order_id);
imageline($image, 50, 60, 750, 60, $black);

$text_y = 100;
imagettftext($image, 12, 0, 50, $text_y, $black, $font, "Name : " . $order['last_name']);
imagettftext($image, 12, 0, 50, $text_y + 30, $black, $font, "Address : " . $order['address'] . ", " . $order['city']);
imagettftext($image, 12, 0, 50, $text_y + 60, $black, $font, "Phone: " . $order['phone1'] . " | Email: " . $order['email']);

// Hiển thị ngày giờ đặt hàng
imagettftext($image, 12, 0, 50, $text_y + 90, $black, $font, "Order Time (USA) : " . $order_date_usa);

$start_y = 220;
imagettftext($image, 12, 0, 50, $start_y, $black, $font, "Products");
imagettftext($image, 12, 0, 400, $start_y, $black, $font, "Quantity");
imagettftext($image, 12, 0, 550, $start_y, $black, $font, "Unit price");
imagettftext($image, 12, 0, 700, $start_y, $black, $font, "Total amount");

$y = $start_y + 30;
while ($row = $products->fetch_assoc()) {
    imagettftext($image, 12, 0, 50, $y, $black, $font, $row['items']);
    imagettftext($image, 12, 0, 400, $y, $black, $font, $row['quantity']);
    imagettftext($image, 12, 0, 550, $y, $black, $font, "$" . number_format($row['price'], 2));
    imagettftext($image, 12, 0, 700, $y, $black, $font, "$" . number_format($row['quantity'] * $row['price'], 2));
    $y += 40;
}

imageline($image, 50, $y, 750, $y, $black);
imagettftext($image, 14, 0, 550, $y + 30, $black, $font, "Total amount : $" . number_format($order['total_price'], 2));

header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
?>
