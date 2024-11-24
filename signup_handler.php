<?php
include 'conn.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $district = $_POST['district'];
    $sector = $_POST['sector'];
    
    // Generate confirmation code
    $confirmation_code = rand(100000, 999999);
    $code_created_at = date('Y-m-d H:i:s');
    $_SESSION['verification_code'] = $confirmation_code;
    // Insert user into the database
    $_SESSION['user'] = $_POST['email'];
    $stmt = $conn->prepare("INSERT INTO sectorofficer (first_name, last_name, email, password, district, sector, confirmation_code, code_created_at) VALUES (:first_name, :last_name, :email, :password, :district, :sector, :confirmation_code, :code_created_at)");
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':district', $district);
    $stmt->bindParam(':sector', $sector);
    $stmt->bindParam(':confirmation_code', $confirmation_code);
    $stmt->bindParam(':code_created_at', $code_created_at);

    if ($stmt->execute()) {
        $_SESSION['email'] = $email; // Store user's email in session
        header("Location: verifyCode.php");
        exit();
    } else {
        echo "There was an error signing up. Please try again.";
    }
}
?>
