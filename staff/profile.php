<?php
include 'header.php';
include '../conn.php';

// Get the current sector staff email from the session
$sectorstaff_email = $_SESSION['user'];

try {
    // Fetch the sector staff's details
    $stmt = $conn->prepare("SELECT * FROM sectorstaff WHERE email = :email");
    $stmt->bindParam(':email', $sectorstaff_email);
    $stmt->execute();
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Failed: " . $e->getMessage();
}
?>

<section class="profile_section layout_padding"  style="background-color: #0f1b33;">
    <div class="container">
        <div class="heading_container heading_center">
            <h2 style="color:white;">Your <span>Profile</span></h2>
        </div>
        <br>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="color:black; ">
                        <h4>Profile Information</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Reader Name:</strong> <?php echo htmlspecialchars($staff['staff_reader_name']); ?></p>
                        <p><strong>Staff Name:</strong> <?php echo htmlspecialchars($staff['staffname']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($staff['email']); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($staff['description']); ?></p>
                        <img src="../sector/uploads/staff/<?php echo $staff['image']; ?>" alt="Profile Image" class="img-thumbnail" style="max-width: 150px;">

                        <!-- Edit Button triggers modal -->
                        <button class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">Edit Profile</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal for Editing Profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $staff['id']; ?>">

                    <div class="form-group">
                        <label for="staff_reader_name">Reader Name</label>
                        <input type="text" class="form-control" id="staff_reader_name" name="staff_reader_name" value="<?php echo htmlspecialchars($staff['staff_reader_name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="staffname">Staff Name</label>
                        <input type="text" class="form-control" id="staffname" name="staffname" value="<?php echo htmlspecialchars($staff['staffname']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($staff['description']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Profile Image (Upload New)</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($staff['email']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank if you don't want to change" autocomplete="off">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
