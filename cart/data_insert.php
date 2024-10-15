<?php
require_once "../config.php";
session_start();
if(isset($_POST['submit'])){
    $customer = $_SESSION["customer"];
    $seat = $_POST["seat"];
    $note = $_POST["note"];
    $orderJSON = $_POST["order"];
    //this process feels goofy
    $jsonWithoutSlashes = stripslashes($orderJSON);
    $jsonTrimmed = trim($jsonWithoutSlashes, '"');
    $orderArray = json_decode($jsonTrimmed, true);
    $total_price = $_POST["total"];
    $order_date = date("Y-m-d");
    $customer_id = $_SESSION['customer_id'];
    $store_id = $_SESSION["store_id"];
    $sql = "INSERT INTO orders (order_date, customer_id, store_id, order_note, order_seat)
            VALUES ('$order_date', $customer_id, $store_id, '$note', '$seat')";
    if (mysqli_query($conn, $sql)) {
        $order_id = mysqli_insert_id($conn);
        echo($order_id);
        foreach ($orderArray as $orderItem) {
            $product_id = $orderItem["product_id"];
            $quantity = $orderItem["quantity"];
            $total_price_item = $orderItem["quantity"] * $orderItem["price"];
            $sql = "INSERT INTO masterkey (order_id, product_id, quantity, total_price)
                     VALUES ('$order_id', '$product_id', '$quantity', '$total_price_item')";
            mysqli_query($conn, $sql);
        }
        $sql = "INSERT INTO payment (order_id, total_price, payment_status)
                VALUES ('$order_id', '$total_price', 'finished')";
        mysqli_query($conn, $sql);
        header("Location: paymentSuccess.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>