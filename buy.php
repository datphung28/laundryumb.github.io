<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['products']) || !isset($_POST['user'])) {
        die("Please select product and customer information!");
    }
    $user_id = $_POST['user']; 
    $products = $_POST['products']; 
    $quantities = $_POST['quantity']; 

    $total_price = 0;
    $connect->begin_transaction();
    try {
        $stmt = $connect->prepare("INSERT INTO order_list (user_id, total_price) VALUES (?, ?)");
        $stmt->bind_param("id", $user_id, $total_price);
        $stmt->execute();
        $order_id = $stmt->insert_id;
        $stmt->close();

        $stmt = $connect->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");

        foreach ($products as $product_id) {
            $query = $connect->prepare("SELECT price FROM price_list_product WHERE id = ?");
            $query->bind_param("i", $product_id);
            $query->execute();
            $result = $query->get_result();
            $row = $result->fetch_assoc();
            $price = $row['price'];
            $query->close();

            $quantity = $quantities[$product_id]; 
            $subtotal = $price * $quantity; 
            $total_price += $subtotal; 

           
            $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
            $stmt->execute();
        }

        $stmt->close();

        
        $stmt = $connect->prepare("UPDATE order_list SET total_price = ? WHERE order_id = ?");
        $stmt->bind_param("di", $total_price, $order_id);
        $stmt->execute();
        $stmt->close();

  
        $connect->commit();

        
        header("Location: vieworder.php?order_id=$order_id");
        exit();
    } catch (Exception $e) {
        $connect->rollback(); 
        die("Lỗi khi đặt hàng: " . $e->getMessage());
    }
}
?>
