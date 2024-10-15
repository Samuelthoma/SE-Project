<?php
require ("../config.php");
$id = $_GET["product_id"]; 

if(isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $result = mysqli_query($conn, "SELECT * FROM product WHERE product_id = '$product_id'");
    
    if(mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_assoc($result);
    }
}

if (isset($_POST['submit'])) {
    $name = $_POST['productName'];
    $price = $_POST['productPrice'];
    $description = $_POST['description'];
    $availability = ($_POST['availability']);
    
    $updateQuery = mysqli_query($conn, 
                   "UPDATE product SET product_name = '$name', product_price = '$price', 
                    product_description = '$description', product_availability = $availability WHERE product_id = '$id'");

    if ($updateQuery) {
        header("Location: ./homepage.php");
        exit();
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFFDD0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 450px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: 20px;
            border: 2px solid black;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        input[type="text"], input[type="file"], select {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }
        select {
            height: 46px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 0;
            margin-top: 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .file-upload-btn {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
        }
        .file-upload-btn:hover {
            background-color: #45a049;
        }
        .file-upload-btn:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <div class="container">
    <img src="../source/logo.png" alt="Logo" style="position: absolute; top: 20px; width: 200px; height: auto;">
    <br><br><br><br><br><br>
        <h1>Update Product</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" value="<?php echo $product['product_name']?>">
            </div>
            <div class="form-group">
                <label for="productPrice">Product Price:</label>
                <input type="text" id="productPrice" name="productPrice" value="<?php echo $product['product_price']?>">
            </div>
            <div class="form-group">
                <label for="productDescription">Product Description:</label><br><br>
                <textarea class="form-control" id="description" name="description" 
                style="width: 400px; height:100px; resize:none;">
                <?php echo $product['product_description']?></textarea>
            </div>
            <div class="form-group">
                <label for="availability">Availability:</label><br>
                    <input type="radio" name="availability" value="b'1'" <?php if($product['product_availability'] == 1) echo "checked"; ?> required>
                        <label>In Stock</label><br>
                    <input type="radio" name="availability" value="b'0'" <?php if($product['product_availability'] == 0) echo "checked"; ?>>
                        <label>Out Of Stock</label><br>
            </div>
            <input type="submit" name="submit" value="Update" />
        </form>
    </div>
</body>
</html>