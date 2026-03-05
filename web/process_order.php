<?php
include 'config.php';

if(isset($_POST['place_order'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_phone = $_POST['customer_phone'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];
    $payment_method = $_POST['payment_method'];
    $delivery_address = $_POST['delivery_address'];
    
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_email, customer_phone, product_name, quantity, total_price, payment_method, delivery_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssidss", $customer_name, $customer_email, $customer_phone, $product_name, $quantity, $total_price, $payment_method, $delivery_address);
    
    if($stmt->execute()) {
        // Send email notification (optional)
        $to = "muhirejoseph46@gmail.com";
        $subject = "New Order Received";
        $message = "New order from: $customer_name\nProduct: $product_name\nQuantity: $quantity\nTotal: $total_price RWF\nPayment: $payment_method";
        mail($to, $subject, $message);
        
        echo "<script>
            alert('Order placed successfully! We will contact you within 24 hours.');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Error placing order. Please try again.');
            window.location.href = 'index.php';
        </script>";
    }
    $stmt->close();
}
?>