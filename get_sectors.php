<?php
include 'conn.php';

if (isset($_POST['district_id'])) {
    $district_id = $_POST['district_id'];
    
    $stmt = $conn->prepare("SELECT id, name FROM tbl_sector WHERE district_id = ?");
    $stmt->execute([$district_id]);
    
    echo '<option value="">Select Sector</option>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='{$row['id']}'>{$row['name']}</option>";
    }
}
?>
