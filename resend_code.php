<?php
include 'conn.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: signup.php");
    exit();
}

$email = $_SESSION['email'];

$new_code = rand(100000, 999999);
$code_created_at = date('Y-m-d H:i:s');
$_SESSION['verification_code'] = $new_code;
$stmt = $conn->prepare("UPDATE sectorofficer SET confirmation_code = :new_code, code_created_at = :code_created_at WHERE email = :email");
$stmt->bindParam(':new_code', $new_code);
$stmt->bindParam(':code_created_at', $code_created_at);
$stmt->bindParam(':email', $email);

if ($stmt->execute()) {
    header("Location: verifyCode.php");
    exit();
} else {
    echo "Error resending the code.";
}
?>
