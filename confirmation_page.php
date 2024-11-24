<?php
// Include database connection
include 'conn.php';

// Check if email is set in the URL
if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    die("Email address not provided.");
}

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = $_POST['confirmation_code'];

    // Verify the confirmation code
    $stmt = $conn->prepare("SELECT * FROM sectorofficer WHERE email = :email AND confirmation_code = :confirmation_code");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':confirmation_code', $entered_code);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Confirmation successful, activate the user account
        $update_stmt = $conn->prepare("UPDATE sectorofficer SET confirmation_code = NULL WHERE email = :email");
        $update_stmt->bindParam(':email', $email);
        if ($update_stmt->execute()) {
            echo "Account confirmed successfully! You can now <a href='login.php'>log in</a>.";
        } else {
            echo "An error occurred while confirming your account. Please try again.";
        }
    } else {
        echo "Invalid confirmation code. Please check your email and try again.";
    }
}
?>

<?php include 'header.php'; ?>

<section class="CitizenVoice_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Account Confirmation</h2>
            <p>Please enter the confirmation code that was sent to your email address.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="confirmation-box">
                    <form action="confirmation_page.php?email=<?php echo $email; ?>" method="post">
                        <div class="form-group">
                            <label for="confirmation_code">Confirmation Code</label>
                            <input type="text" class="form-control" id="confirmation_code" name="confirmation_code" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Confirm Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
