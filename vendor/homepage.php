<?php
    include("../config.php");
    session_start();
    if(!isset($_SESSION["store_id"])){
    header("Location: vendorlogin.html");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
      crossorigin="anonymous"
    />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            background: white;
            display: flex;
            flex-direction: column;
            min-height: 100vh;    
        }

        .table-container{
            padding-top: 20px;
            padding: 40px;
            margin: 20px;
            border: 2px solid black;
            border-radius: 10px;
        }

        table{
            justify-content: center;
        }

        thead{
            color: white;
            background-color: black;
        }

        .banner {
            color: black;
            padding: 50px;
            text-align: center;
        }

        .banner h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            background: #333;
            color: #fff;
            padding: 6px 24px;
            text-decoration: none;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .btn:hover {
            background: #555;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: auto;
            width: 100%;
        }

        footer p {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <nav
      class="navbar navbar-expand-lg bg-body-tertiary"
      style="background-color: #333"
    >
      <div class="container-fluid">
        <a class="navbar-brand" href="">
          <img src="../source/logo.png" alt="logo" height="45" />
        </a>    
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </nav>

    <div class="banner">
        <h2>PU eCanteen Vendor Menu</h2>
        <p>"Be a good seller, your food is your mirror"</p>
    </div>
    <br>
    
<?php
    $store_id = $_SESSION["store_id"];
    $sql = "SELECT * FROM product WHERE store_id = $store_id";
    $result = $conn->query($sql);
?> 

<div class="table-container">
    <h1>Product List</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><center>Product Name</center></th>
                    <th><center>Price</center></th>
                    <th><center>Product Image</center></th>
                    <th><center>Description</center></th>
                    <th><center>Availability</center></th>
                    <th><center>Action</center></th>
                </tr>
            </thead>
    <?php 
    //ini table
    if ($result->num_rows > 0) {
    
        while ($row = $result->fetch_assoc()) {  
        echo "<tr>";
        echo "<td><center>" . $row['product_name'] .  "</center></td>" ;
        echo "<td><center>" . $row['product_price'] .  "</center></td>";
        echo "<td><center><img src='../image/" . $row['product_image'] . "'alt='Product Image' width='200px'; heigth='200px'; ></center></td>";
        echo "<td><center>" . $row['product_description'] .  "</center></td>";
        echo "<td><center>" . $row['product_availability'] .  "</center></td>";
        echo "<td><center> 
        <a href='update.php?product_id=$row[product_id]' class='btn btn-primary btn-block' 
        style='background-color:#04AA6D; width:50%'>Edit</a> 
        <a href='delete.php?product_id=$row[product_id]' class='btn btn-primary btn-block' 
        style='background-color:#f44336; width:50%' >Delete</a></center> </td>";
        echo "</tr>";
        }
    }else{
        echo "<tr><td colspan='6'>No records found</td></tr>";
    }   
    ?>
    <td colspan='6'><a href="form.php" class="btn">Add Menu</a></td>
  </table>
</div>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Our Website. All rights reserved.</p>
    </footer>
</body>
</html>
