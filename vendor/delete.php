<?php
    include ("../config.php");
    $product_id = $_GET["product_id"];
    $query = "DELETE FROM product WHERE product_id = $product_id";
    $result = mysqli_query($conn, $query);
    header("Location: ./homepage.php");
?>  