<?php
include 'header.php';
include '../conn.php';

try {
    $stmt = $conn->prepare("SELECT * FROM sectorstaff WHERE sectorOfficer_email = :user_email");
    $stmt->bindParam(':user_email', $_SESSION['user']);
    $stmt->execute();
    $staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Failed: " . $e->getMessage();
}

?>

<section class="team_section layout_padding" style="background-image: url('../images/niboye2.png'); background-size: cover; background-position: center;">
    <div class="container-fluid bg-light p-4">
        <div class="row align-items-center">
        <!-- Heading Section -->
            <div class="col-lg-8 col-md-8 text-left">
                <div class="heading_container">
                    <h2 class="text-dark">Our <span>Departments</span> in sector</h2>
                </div>
            </div>

            <!-- Add New Staff Button Section -->
            <div class="col-lg-4 col-md-4 text-right">
                <a href="addStaff.php" class="btn add-staff-btn">
                    <i class="fa-solid fa-plus"></i> Add New Staff
                </a>
            </div>
        </div>

        <div class="team_container">
            <div class="row">
                <?php foreach ($staffs as $staff): ?>
                <div class="col-lg-3 col-sm-6">
                    <div class="box ">
                        <div class="img-box">
                            <!-- Display staff image -->
                            <img src="uploads/staff/<?php echo $staff['image']; ?>" class="img1" alt="staff image">
                        </div>
                        <div class="detail-box">
                            <h5><?php echo $staff['staffname']; ?></h5>
                            <hr>
                            <h6><?php echo $staff['staff_reader_name']; ?></h6>
                            <hr>
                            <p><?php echo $staff['description']; ?></p>
                            <!-- Delete Button -->
                            <button class="btn btn-danger" onclick="confirmDelete('<?php echo $staff['staffname']; ?>', '<?php echo $staff['id']; ?>')">Delete</button>
                        </div>
                        <hr>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <span id="staffToDelete"></span>?
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="post" action="deleteStaff.php">
                    <input type="hidden" name="staff_id" id="staffIdToDelete">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(staffname, staffId) {
    // Set the staff name and ID in the modal
    document.getElementById('staffToDelete').innerText = staffname;
    document.getElementById('staffIdToDelete').value = staffId;

    // Show the modal
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>

<?php include 'footer.php'; ?>
