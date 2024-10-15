<?php
require_once '../config.php'; 
$store_id = $_GET['store_id'];
$query = "SELECT * FROM product where store_id = $store_id";
$result = mysqli_query($conn, $query);
session_start();
$_SESSION['store_id'] = $store_id;
if(!isset($_SESSION["customer"])){
    header("Location: identification.html");
  }
  $storeRes = mysqli_query($conn, "SELECT store_brand, store_id FROM store");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="menu.css">
    <script>
        var order = [];
        var total = 0;  //I **totally** didnt forget to use this value, pun intended
        //function to add order
        function addToOrder(productId, productPrice) {
            var index = order.findIndex(item => item.product_id === productId);
            if (index !== -1) {
                order[index].quantity += 1;
            } else {
                order.push({ product_id: productId, quantity: 1 , price: productPrice });
            }
        
            total += productPrice;
            tot_up();
            updateQuantityDisplay(productId);
        }
        //function to remove order
        function removeFromOrder(productId, productPrice) {
            var index = order.findIndex(item => item.product_id === productId);
            if (index !== -1) {
                order[index].quantity -= 1;
                if (order[index].quantity <= 0) {
                    order.splice(index, 1);
                }
                total -= productPrice;
                tot_down();
                updateQuantityDisplay(productId);
            }
        }
        //function to maintain dynamic update for quantity
        function updateQuantityDisplay(productId) {
            var quantitySpans = document.querySelectorAll('[id^="quantity-' + productId + '"]');
            quantitySpans.forEach(function(quantitySpan) {
                var index = order.findIndex(item => item.product_id === productId);
                if (index !== -1) {
                    quantitySpan.textContent = order[index].quantity;
                } else {
                    quantitySpan.textContent = '0';
                }
            });
        }
        //function to checkout
        function checkout(order) {
            var orderJson = JSON.stringify(order);
            var orderQueryParam = encodeURIComponent(orderJson);
            var url = '../cart_test/checkout.php?order=' + orderQueryParam;
            window.location.href = url;
        }
        //function to well toggle the cart
        function toggleCart() {
          var cart = $('.cart');
          var container = $('.container');
          var css =  cart.css('right');
          if (css !== "0px") {
            cart.css('right', '0');
            container.css('transform', 'translateX(-400px)');
          } else {
            cart.css('right', '-100%');
            container.css('transform', 'translateX(0)');
          }
        }
        //dynamic update for quantity but inside cart
        function tot_up(){
            var currentQuantity = parseInt($('.totalQuantity').text());
            var newQuantity = currentQuantity + 1;
            $('.totalQuantity').text(newQuantity);
        };
        function tot_down() {
            var currentQuantity = parseInt($('.totalQuantity').text());
            if(currentQuantity > 0){
                var newQuantity = Math.max(0, currentQuantity - 1);
                $('.totalQuantity').text(newQuantity);
            }
        };
        //function to spawn item in cart
        function addDisplay(id, name, price, image) {
            var productExists = false;
            for (var i = 0; i < order.length; i++) {
                if (order[i].product_id === id) {
                    productExists = true;
                    break;
                }
            }
            if (!productExists) {
                var newItem = '<div class="item" id=item-' + id + '>';
                newItem += '<img src="../image/' + image + '">';
                newItem += '<div class="content">';
                newItem += '<div class="name">' + name + '</div>';
                newItem += '<div class="price">$' + price + ' per order</div>';
                newItem += '</div>';
                newItem += '<div class="quantity">';
                newItem += '<button onclick="removeDisplay(' + id + '); removeFromOrder(' + id + ','+ price + ')">-</button>';
                newItem += '<span class="value quantity" id="quantity-' + id + '">1</span>';
                newItem += '<button onclick="addDisplay(' + id + ', \''+ name+ '\', \''+ price + '\', \''+ image + '\'); addToOrder(' + id + ','+ price + ')">+</button>';
                newItem += '</div>';
                newItem += '</div>';
                $('.listCart').append(newItem);

            }
        }
        //function to demolish item from cart
        function removeDisplay(id) {
            var index = order.findIndex(item => item.product_id === id);
            if (index !== -1) { 
                var quantity = order[index].quantity;
                if (quantity <= 1) { 
                    var itemToRemove = $('.listCart').find('#item-' + id);
                    if (itemToRemove.length > 0) { 
                        itemToRemove.remove(); 
                        console.log("Item removed successfully (ID:", id, ")"); 
                    } else {  
                        console.error("Item with ID", id, "not found in DOM"); 
                    }
                }
            } else {
                console.error("Item with ID", id, "not found in order array"); 
            }
        }

    </script>
</head>
<body>
    <div style="transition: right 1s;">
        <nav class="navbar navbar-expand-lg" 
            style="background-color:#fcf2e8">
            <div class="container">
                <a class="navbar-brand" href="home.php">
                    <img src="../source/logo.png" alt="logo" height="45" />
                </a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="btn-group">
                            <a class="btn dropdown-toggle" style="background-color:#F7C566;" href="#" id="navbardrop" data-toggle="dropdown">
                            Check Another Store
                            </a>
                            <div class="dropdown-menu">
                            <?php
                                if(mysqli_num_rows($storeRes) > 0){
                                    while($row = mysqli_fetch_assoc($storeRes)){
                                        echo '<a class="dropdown-item" href="menu.php?store_id='. $row["store_id"].'">' . $row["store_brand"] . '</a>';
                                    }
                                }
                            ?>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-block" style="background-color:#90D26D;" href="./home.php">Back To Home</a>
                        </li>
                        <li class="nav-item">
                        <a class="btn btn-primary btn-block" style="background-color:#FA7070;" href="./logout.php">Log Out</a>
                        </li>
                    </ul>
                </div>
                <div class="iconCart" onclick="toggleCart()">
                    <img src="../cart_test/icon.png" style="height:60px; width:60px;">
                    <div class="totalQuantity">0</div>
                </div>
            </div>
        </nav>

    
        <div class="container mt-5">
            <div class="row">
                <?php
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $product_name = $row['product_name'];
                        $product_description = $row['product_description'];
                        $product_price = $row['product_price'];
                        $product_image = $row['product_image'];
                        $quantity = 0;
                        $id = $row['product_id'];
                        $availability = $row['product_availability'];
                    
                        if ($availability) {
                            echo '<div class="col-md-6 mb-4">';
                            echo '<div class="card food-item rounded border-0">'; 
                            echo '<img src="../image/' . $product_image . '" class="card-img-top rounded" style="max-width: 200px; max-height: 169px; object-fit: cover;" alt="Food Image">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $product_name . '</h5>';
                            echo '<p class="card-text">' . $product_description . '</p>';
                            echo '<p class="card-text">$' . $product_price . '</p>';
                            echo '</div>';
                            echo '<div class="quantity-position">';
                            echo '<button class="btn btn-primary mr-2" onclick="removeDisplay(' . $id .'); removeFromOrder(' . $id . ' , ' . $product_price .')">-</button>';
                            echo '<span class="quantity" id="quantity-' . $id . '">' . $quantity . '</span>';
                            echo '<button class="btn btn-primary ml-2" onclick="addDisplay('.$id.', \''.$product_name.'\', \''.$product_price.'\', \''.$product_image.'\'); addToOrder(' . $id . ',' . $product_price .');">+</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                
                    mysqli_free_result($result);
                } else {
                    echo json_encode(array('error' => 'Failed to fetch products.'));
                }
                ?>
            </div>
        </div>
    </div>
    <div class="cart" id="cart">
        <h2>
            CART
        </h2>
        <div class="listCart">
        </div>
        <div class="buttons">
            <div class="close" style="color: #E8bc0e; text-shadow:none;" onclick="toggleCart()">CLOSE</div>
            <div class="checkout">
                <a  onclick="checkout(order)">CHECKOUT</a>
            </div>
        </div>
    </div>
</body>
</html>
