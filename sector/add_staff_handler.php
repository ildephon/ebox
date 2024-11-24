<?php
include '../conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staff_reader_name = $_POST['staff_reader_name'];
    $staffname = $_POST['staffname'];
    $email = $_POST['email'];   // New field for email
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // New field for password (hashed)
    $description = $_POST['description'];
    $sectorOfficer_email = $_POST['sectorOfficer_email'];

    // Decode the cropped image data
    $cropped_image_data = $_POST['cropped_image'];
    $image_parts = explode(";base64,", $cropped_image_data);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file_name = uniqid() . '.jpg'; // Save image as JPG
    $file_path = "uploads/staff/" . $file_name;

    // Save the image file
    file_put_contents($file_path, $image_base64);

    // Insert data into the table
    $stmt = $conn->prepare("INSERT INTO sectorstaff (staff_reader_name, staffname, description, image, sectorOfficer_email, email, password) 
                            VALUES (:staff_reader_name, :staffname, :description, :image, :sectorOfficer_email, :email, :password)");
    $stmt->bindParam(':staff_reader_name', $staff_reader_name);
    $stmt->bindParam(':staffname', $staffname);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $file_name);
    $stmt->bindParam(':sectorOfficer_email', $sectorOfficer_email);
    $stmt->bindParam(':email', $email);  // Bind email
    $stmt->bindParam(':password', $password);  // Bind hashed password

    if ($stmt->execute()) {
        header('Location: staff.php');
    } else {
        echo "Error adding staff member.";
    }
}
?>
