<?php
include '../conn.php';
session_start();

// Get the current sector officer email from the session
$sectorOfficer_email = $_SESSION['user'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Start building the SQL query
        $sql = "UPDATE sectorofficer SET first_name = :first_name, last_name = :last_name, email = :email";
        
        // Check if a new password is provided
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql .= ", password = :password";
        }
        
        // Complete the SQL query
        $sql .= " WHERE id = :id AND email = :sectorOfficer_email";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the parameters
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        if (!empty($password)) {
            $stmt->bindParam(':password', $hashed_password);
        }
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':sectorOfficer_email', $sectorOfficer_email);

        // Execute the statement
        if ($stmt->execute()) {
            // Update the session email if the user has changed it
            if ($email !== $sectorOfficer_email) {
                $_SESSION['user'] = $email;
            }

            // Redirect back to the profile page with success message
            $_SESSION['success'] = "Profile updated successfully!";
            header("Location: profile.php");
        } else {
            // If the update fails
            $_SESSION['error'] = "Failed to update profile. Please try again.";
            header("Location: profile.php");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
