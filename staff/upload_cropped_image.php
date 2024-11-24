<?php
session_start();
include '../conn.php';

if (isset($_FILES['cropped_image']['tmp_name'])) {
    $imageName = time() . '.jpg';
    $uploadPath = '../sector/uploads/staff/' . $imageName;

    if (move_uploaded_file($_FILES['cropped_image']['tmp_name'], $uploadPath)) {
        $sectorOfficer_email = $_SESSION['user'];
        
        // Update the officer's image in the database
        $stmt = $conn->prepare("UPDATE sectorofficer SET image = :image WHERE email = :email");
        $stmt->bindParam(':image', $imageName);
        $stmt->bindParam(':email', $sectorOfficer_email);
        if ($stmt->execute()) {
            echo "Image uploaded and profile updated!";
        } else {
            echo "Error updating profile image.";
        }
    } else {
        echo "Failed to upload image.";
    }
} else {
    echo "No image received.";
}
?>
