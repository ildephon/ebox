<?php
include 'conn.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['username']; 
    $password = $_POST['password'];

    $_SESSION['user'] = $email;
    $stmt = $conn->prepare("SELECT * FROM sectorofficer WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $check = 1;
    if ($user) {
        if (password_verify($password, $user['password'])) {
           
            $verification_code = rand(100000, 999999);
            $code_created_at = date('Y-m-d H:i:s');

            $_SESSION['verification_code'] = $verification_code;
            $_SESSION['code_created_at'] = $code_created_at;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION ['type'] = 1;
            header("Location: verifyCode.php?type=1");
            exit();
        } else {
            // $_SESSION['login_error'] = "Invalid password. Please try again.";
            // header("Location: login.php");
            // exit();
            $check = 2;
            // echo "hggfghgufdgbsrfhguyrkkfvb gwryuf ergue";
            // echo "No no";
        }
    } else {
        // User does not exist
        // $_SESSION['login_error'] = "User not found. Please check your credentials.";
        // header("Location: login.php");
        // exit();
        // echo "NO";
        $check = 2;


    }

    if ($check == 2) {
        
        $stmt = $conn->prepare("SELECT * FROM sectorstaff WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
            
                $verification_code = rand(100000, 999999);
                $code_created_at = date('Y-m-d H:i:s');

                $_SESSION['verification_code'] = $verification_code;
                $_SESSION['code_created_at'] = $code_created_at;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['type'] = 2;
                header("Location: verifyCode.php");
                exit();
            } else {
                $_SESSION['login_error'] = "Invalid password. Please try again.";
                header("Location: dashboard.php");
                exit();
            }
        } else {
            // User does not exist
            $_SESSION['login_error'] = "User not found. Please check your credentials.";
            header("Location: login.php");
            exit();
        }
    }
}
?>
