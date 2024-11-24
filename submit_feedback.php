<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['staff_id'], $_POST['agree'], $_POST['message'])) {


        $is_anonymous = isset($_POST['anonymous']) ? true : false;

        if ($is_anonymous) {
            $first_name = "John";
            $last_name = "Doe";
            $email = "default@gmail.com";
            $phone = "N/A";
        } else {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
        }

        $staff_id = $_POST['staff_id']; 
        $message = $_POST['message'];

        $target_dir = "files/Feedback/";

        $image = !empty($_FILES['image']['name']) ? $target_dir . basename($_FILES['image']['name']) : null;
        $pdf = !empty($_FILES['pdf']['name']) ? $target_dir . basename($_FILES['pdf']['name']) : null;
        $audio = !empty($_FILES['audio']['name']) ? $target_dir . basename($_FILES['audio']['name']) : null;
        $video = !empty($_FILES['video']['name']) ? $target_dir . basename($_FILES['video']['name']) : null;

        if (!empty($image)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        }
        if (!empty($pdf)) {
            move_uploaded_file($_FILES['pdf']['tmp_name'], $pdf);
        }
        if (!empty($audio)) {
            move_uploaded_file($_FILES['audio']['tmp_name'], $audio);
        }
        if (!empty($video)) {
            move_uploaded_file($_FILES['video']['tmp_name'], $video);
        }

        $stmt = $conn->prepare("
            INSERT INTO citizen_feedback (staff_id, first_name, last_name, email, phone, image, pdf, audio, video, message) 
            VALUES (:staff_id, :first_name, :last_name, :email, :phone, :image, :pdf, :audio, :video, :message)
        ");
        $stmt->bindParam(':staff_id', $staff_id);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':pdf', $pdf);
        $stmt->bindParam(':audio', $audio);
        $stmt->bindParam(':video', $video);
        $stmt->bindParam(':message', $message);
        $stmt->execute();

        echo "<script>
    alert('Feedback submitted successfully!');
    window.location.href = 'CitizenVoice.php'; // Change this to your desired redirect page
</script>";

// End the output buffering and flush the output
ob_end_flush();

    } else {
        echo "You must confirm that,You agree that what you are sending is true and You are sure to send it";
    }
}
?>

