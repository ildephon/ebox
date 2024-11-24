<?php
session_start();

$stored_code = isset($_SESSION['verification_code']) ? $_SESSION['verification_code'] : null;

$entered_code = isset($_POST['verification_code']) ? $_POST['verification_code'] : '';

if (!$stored_code) {
    $_SESSION['error'] = "Verification code not found. Please request a new code.";
    header("Location: verifyCode.php");
    exit;
}

if ($entered_code == $stored_code) {
    
    unset($_SESSION['verification_code']);

    $_SESSION['success'] = "Verification successful!";
    if ($_SESSION['type'] == 1) {
        header("Location: sector/home.php");
        exit;
    }
    elseif ($_SESSION['type'] == 2) {
        header("Location: staff/home.php");
        exit;
    }
    
} else {
    
    $_SESSION['error'] = "The verification code is incorrect. Please try again.";
    header("Location: verifyCode.php");
    exit;
}
