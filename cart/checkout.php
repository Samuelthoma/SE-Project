<?php
    require_once ("../config.php");
    $orderJSON = $_GET['order'];
    $orderArray = json_decode(urldecode($orderJSON), true);
    $total_item = 0;
    $total_price = 0;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tailwindcss-colors.css">
</head>
<body>
    

<div class="container">
    <div class="checkoutLayout">

        
        <div class="returnCart">
            <a href="../Canteen/home.php">keep shopping</a>
            <h1>List Product in Cart</h1>
            <div class="list">
                <?php
                    foreach ($orderArray as $orderItem) {
                        // Get product details from the database
                        $productId = $orderItem['product_id'];
                        $quantity = $orderItem['quantity'];
                    
                        // Query to retrieve product details
                        $sql = "SELECT product_name, product_image, product_price FROM product WHERE product_id = $productId";
                        $result = mysqli_query($conn, $sql);
                    
                        // Check if the query was successful
                        if ($result) {
                            // Fetch the row
                            $row = mysqli_fetch_assoc($result);

                            // Extract product details
                            $productName = $row['product_name'];
                            $productImage = $row['product_image'];
                            $productPrice = $row['product_price'];
                            $productTotal = $productPrice * $quantity;
                        
                            // Output the HTML for the item
                            echo '<div class="item" style="overflow: hidden; padding-left: 0;">';
                            echo '<img class="rounded" style="max-width: 120%; max-height: 100%; object-fit: cover;" src="../image/' . $productImage . '">';
                            echo '<div class="info" style=" padding-left: 5%;">';
                            echo '<div class="name">' . $productName . '</div>';
                            echo '<div class="price">' . $productPrice . ' per item</div>';
                            echo '</div>';
                            echo '<div class="quantity">' . $quantity . '</div>';
                            echo '<div class="returnPrice">' . $productTotal . '</div>';
                            echo '</div>';
                            $total_item += $quantity;
                            $total_price += $productTotal;
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                    }
                ?>

            </div>
        </div>

        <form action="data_insert.php" class="checkoutForm" method="POST">
            <div class="right">
                <h1>Checkout</h1>

                
                <div class="return">
                    <div class="row">
                        <div>Total Quantity</div>
                        <div class="totalQuantity"><?php echo ($total_item); ?></div>
                    </div>
                    <div class="row">
                        <div>Total Price</div>
                        <div class="totalPrice"><?php echo ($total_price); ?></div>
                    </div>
                </div>


                <div class="payment-wrapper">
                
                    <div class="payment-right">
                        
                            <h1 class="payment-title">Payment Details</h1>
                            <div class="payment-method">
                                <input type="radio" name="payment-method" id="method-1" value="QRIS" checked>
                                <label for="method-1" class="payment-method-item">
                                    <img src="./images/QRIS.png" alt="">
                                </label>

                                <input type="radio" name="payment-method" id="method-2" value="BCA">
                                <label for="method-2" class="payment-method-item">
                                    <img src="images/BCA.png" alt="">
                                </label>

                                <input type="radio" name="payment-method" id="method-3" value="Mandiri">
                                <label for="method-3" class="payment-method-item">
                                    <img src="images/mandiri.png" alt="">
                                </label>

                                <input type="radio" name="payment-method" id="method-4" value="Master-card">
                                <label for="method-4" class="payment-method-item">
                                    <img src="images/master-card.png" alt="">
                                </label>
                    
                            </div>
                            <h3 class="payment-title">Seat</h3>
                            <div class="payment-form-group">
                                <input type="text" placeholder=" " class="payment-form-control" id="cvv" style="padding: 21px 16px 7px 16px" name="seat">
                                <label for="cvv" class="payment-form-label payment-form-label-required">Put your seat location</label>
                            </div>
                            <h3 class="payment-title">Notes:</h3>
                            <div class="payment-form-group">
                                <input type="text" placeholder=" " class="payment-form-control" id="cvv" name="note">
                                <label for="cvv" class="payment-form-label payment-form-label-required">Note for seller</label>
                            </div>
                    </div>
                </div>
                <input type="hidden" name="order" value="<?php echo htmlspecialchars(json_encode($orderJSON)); ?>">
                <input type="hidden" name="total" value="<?php echo $total_price; ?>">
                <button type="submit" name="submit" class="buttonCheckout">CHECKOUT</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
