<?php
    include("config.php");
    if(isset($_POST["submit"])){
        $brand = $_POST["storeBrand"];
        $password = $_POST["storePassword"];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $openingTime = $_POST["openingTime"];
        $closingTime = $_POST["closingTime"];
        
        $fileName = $_FILES["image"]["name"];
        $tmpName = $_FILES["image"]["tmp_name"];
        $validImageExtension = ['jpg', 'jpeg'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));
    
        if (!in_array($imageExtension, $validImageExtension)) {
            echo "Invalid image format. Please upload a JPG or JPEG file.";
            exit; 
        }
    
        $newName = uniqid() . '.' . $imageExtension;
        move_uploaded_file($tmpName, 'image/' . $newName); 

        $query = "INSERT INTO store (store_brand, store_password, opening_time, closing_time, store_image)
                VALUES ('$brand', '$hashedPassword', '$openingTime', '$closingTime', '$newName')";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            echo "Error: " . mysqli_error($conn);
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Register</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
      crossorigin="anonymous"
    />

    <style>

    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
    
        body{
            justify-content: center;
            allign-items: center;
            background:#EAEAEA;
        }

        h3 {
            display: flex;
            justify-content: center;
            font-weight: bold;
        }
        .container{
            display: flex;
            justify-content: center;
        }

        .form-container{
            background-color: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-family: "Poppins";
            border: 2px solid black;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            width: 420px;
            display: flex;
            justify-content: center;
        }

        .form-control {
            border-radius: 20px;
            padding: 15px;
        }

        .btn-primary{
            width: 350px;
        }
    </style>
</head>
<body>
<nav
      class="navbar navbar-expand-lg bg-body-tertiary"
      style="background-color: black"
    >
      <div class="container-fluid">
        <a class="navbar-brand" href="">
          <img src="./source/logo.png" alt="logo" height="45" />
        </a>    
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </nav><br>
        <h3>PU eCanteen Vendor Register</h3>

    <div class="container">
        <div class="form-container">
            <form class="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
                <label for="storeBrand">Store Brand : </label><br>
                <input type="text" class="form-control" name="storeBrand"><br>
                <label for="storePassword">Store Password : </label><br>
                <input type="text" class="form-control" name="storePassword"><br>
                <label for="openingTime">Opening Time : </label><br>
                <input type="time" class="form-control" name="openingTime"><br>
                <label for="closingTime">Closing Time : </label><br>
                <input type="time" class="form-control" name="closingTime"><br>
                <label for="image">Image : </label><br>
                <input type="file" name="image" accept=".jpg, .jpeg"><br><br>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </form>     
        </div>
    </div>
</body>
</html>