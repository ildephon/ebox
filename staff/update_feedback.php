<?php
include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedbackId = $_POST['id'];
    $action = $_POST['action'];

    if ($action === 'pin') {
        $stmt = $conn->prepare("UPDATE citizen_feedback SET pin = 1 WHERE id = :id");
    } elseif ($action === 'unpin') {
        $stmt = $conn->prepare("UPDATE citizen_feedback SET pin = 0 WHERE id = :id");
    } elseif ($action === 'focus') {
        $stmt = $conn->prepare("UPDATE citizen_feedback SET focus = 1 WHERE id = :id");
    } elseif ($action === 'unfocus') {
        $stmt = $conn->prepare("UPDATE citizen_feedback SET focus = 0 WHERE id = :id");
    }

    $stmt->bindParam(':id', $feedbackId);
    $stmt->execute();

    echo json_encode(['success' => true]);
}
?>
