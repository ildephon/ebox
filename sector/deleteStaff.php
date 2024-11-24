<?php
include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staffId = $_POST['staff_id'];

    try {
        $stmt = $conn->prepare("DELETE FROM sectorstaff WHERE id = :staff_id");
        $stmt->bindParam(':staff_id', $staffId);
        $stmt->execute();

        // Redirect to the same page after deletion
        header('Location: staff.php'); // Adjust the redirect page as needed
        exit();
    } catch(PDOException $e) {
        echo "Failed to delete staff: " . $e->getMessage();
    }
}
?>
