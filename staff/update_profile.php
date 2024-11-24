<?php
include '../conn.php';
session_start();

// Get the current sector staff email from the session
$sectorstaff_email = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $staff_reader_name = $_POST['staff_reader_name'];
    $staffname = $_POST['staffname'];
    $description = $_POST['description'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $image = $_FILES['image'];

    try {
        $sql = "UPDATE sectorstaff SET staff_reader_name = :staff_reader_name, staffname = :staffname, description = :description, email = :email";

        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql .= ", password = :password";
        }

        // Handle image upload
        if (!empty($image['name'])) {
            $image_name = time() . "_" . basename($image['name']);
            $target_dir = "../sector/uploads/staff/";
            $target_file = $target_dir . $image_name;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                // Update the image column in the database
                $sql .= ", image = :image";
            } else {
                $_SESSION['error'] = "Failed to upload the image.";
                header("Location: profile.php");
                exit();
            }
        }

        $sql .= " WHERE id = :id AND email = :sectorstaff_email";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':staff_reader_name', $staff_reader_name);
        $stmt->bindParam(':staffname', $staffname);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':email', $email);
        if (!empty($password)) {
            $stmt->bindParam(':password', $hashed_password);
        }
        if (!empty($image['name'])) {
            $stmt->bindParam(':image', $image_name);
        }
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':sectorstaff_email', $sectorstaff_email);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Profile updated successfully!";
            header("Location: profile.php");
        } else {
            $_SESSION['error'] = "Failed to update profile.";
            header("Location: profile.php");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
