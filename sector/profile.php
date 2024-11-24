<?php
include 'header.php';
include '../conn.php';

// Get the current sector officer email from the session
$sectorOfficer_email = $_SESSION['user'];

try {
    // Fetch the sector officer's details
    $stmt = $conn->prepare("SELECT * FROM sectorofficer WHERE email = :email");
    $stmt->bindParam(':email', $sectorOfficer_email);
    $stmt->execute();
    $officer = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Failed: " . $e->getMessage();
}
?>

<section class="profile_section layout_padding" style="background-image: url('../images/niboye2.png'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="heading_container heading_center">
            <h2 class="rounded"style="color:black ;background-color: white; padding: 1rem;">Your Profile</h2>
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
                    <div class="card-header">
                        <h4>Profile Information</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>First Name:</strong> <?php echo htmlspecialchars($officer['first_name']); ?></p>
                        <p><strong>Last Name:</strong> <?php echo htmlspecialchars($officer['last_name']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($officer['email']); ?></p>
                        
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
            <form action="update_profile.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $officer['id']; ?>">

                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($officer['first_name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($officer['last_name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($officer['email']); ?>" required>
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
