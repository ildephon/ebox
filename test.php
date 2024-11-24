<?php
include 'conn.php';

if (isset($_POST['sector_id'])) {
    $sector_id = $_POST['sector_id'];
    
    $stmt = $conn->prepare("SELECT * FROM sectorstaff WHERE sectorOfficer_email IN (SELECT email FROM sectorofficer WHERE sector = :sector_id)");
    $stmt->bindParam(':sector_id', $sector_id);
    $stmt->execute();
    $staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($staffs)) {
        foreach ($staffs as $staff) {
            echo '
            <div class="col-md-4">
                <div class="box staff-card">
                    <div class="img-box">
                        <img src="sector/uploads/staff/' . $staff['image'] . '" class="img-circle" alt="staff image">
                    </div>
                    <div class="detail-box">
                        <h5>' . $staff['staffname'] . ' ' . $staff['id'].'</h5>
                        <h6>' . $staff['staff_reader_name'] . '</h6>
                        <p>' . $staff['description'] . '</p>
                        <button type="button" class="btn btn-primary select-staff-btn" data-staff-id="1" data-toggle="modal" data-target="#feedbackModal">
                          Select Staff
                        </button>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<p>No staff available for the selected sector.</p>';
    }
}
?>

<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document"> <!-- Modal width increased -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="feedbackModalLabel">Send Feedback</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="feedbackForm" action="submit_feedback.php" method="post" enctype="multipart/form-data">
          
          <!-- Updated Input Field to Hold Staff ID -->
          <input type="text" id="staffId" value="" name="staff_id" readonly>

          <!-- Rest of the form fields -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name" required>
            </div>
            <div class="form-group col-md-6">
              <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group col-md-6">
              <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="image">Upload Image</label>
              <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            </div>
            <div class="form-group col-md-6">
              <label for="pdf">Upload PDF</label>
              <input type="file" class="form-control-file" id="pdf" name="pdf" accept="application/pdf">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="audio">Upload Audio</label>
              <input type="file" class="form-control-file" id="audio" name="audio" accept="audio/*">
            </div>
            <div class="form-group col-md-6">
              <label for="video">Upload Video</label>
              <input type="file" class="form-control-file" id="video" name="video" accept="video/*">
            </div>
          </div>

          <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
          </div>

          <div class="form-group">
            <input type="checkbox" id="agreeTerms"> I agree that what I am sending is true and I am sure to send it
          </div>

          <button type="submit" id="submitFeedback" class="btn btn-primary" disabled>Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>


