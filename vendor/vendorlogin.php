<?php
    require_once '../config.php';

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        // Prepare and execute a SELECT query to retrieve the row based on username
        $sql = "SELECT store_id, store_password FROM store WHERE store_brand = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result(); 
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $storedPassword = $row['store_password'];

                if (password_verify($password, $storedPassword)) {
                    $store_id = $row['store_id'];
                    session_start();
                    $_SESSION['store_id'] = $store_id;
                    header("Location: homepage.php");
                    exit;
                }
            }
            header("Location: vendorlogin.html?error=Invalid username or password");
            exit;
        } else {
            header("Location: vendorlogin.html?error=Invalid username or password");
            exit;
        }

        $stmt->close();
        $conn->close();
    } else {
        // If 'submit' was not set, redirect to login page with error message
        header("Location: vendorlogin.html?error=What are you doing?");
        exit;
    }    
?>
