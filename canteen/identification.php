<?php
    session_start();
    if(isset($_POST['submit'])){
        $name = $_POST["name"];
        $phone = $_POST["phone"];

        include_once("../config.php");
        $query = "INSERT INTO customer (customer_name, customer_number) VALUES (?,?)";
        $result = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($result, "ss", $name, $phone);
        $result->execute();

        if($result){
            $_SESSION["customer"] = $name;
            $customer_id = mysqli_insert_id($conn);
            $_SESSION["customer_id"] = $customer_id;
            header("Location: home.php");
        }
        $conn->close();
        $result->close();
    }
?>