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
<style>
    .img-thumbnail.rounded-square {
    object-fit: cover;
    width: 100px;
    height: 100px;
    border-radius: 10px;
}
</style>
<section class="team_section layout_padding">
    <div class="container-fluid">
        <div class="row align-items-center">
        <!-- Heading Section -->
            <div class="col-lg-8 col-md-8 text-left">
                <div class="heading_container">
                    <h2>Our <span>Team</span></h2>
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
                            <img src="sector/uploads/staff/<?php echo $staff['image']; ?>" class="img1" alt="staff image">
                        </div>
                        
                        <div class="detail-box">
                            <h5><?php echo $staff['staffname']; ?></h5>
                            <hr>
                            <h6><?php echo $staff['staff_reader_name']; ?></h6>
                            <hr>
                            <p><?php echo $staff['description']; ?></p>
                        </div>
                        <div class="social_box">
                            <a href="#">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                            <a href="#">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                            <a href="#">
                                <i class="fa fa-linkedin" aria-hidden="true"></i>
                            </a>
                            <a href="#">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                            <a href="#">
                                <i class="fa fa-youtube-play" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Add new staff button -->
        

    </div>
</section>

<?php include 'footer.php'; ?>
