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
                <div class="card staff-card shadow-sm mb-4">
                    <div class="card-body text-center">
                        <div class="img-box mb-3">
                            <img src="sector/uploads/staff/' . $staff['image'] . '" class="img-fluid rounded-circle staff-img" alt="staff image" style="width: 150px; height: 150px;">
                        </div>
                        <h5 class="card-title">' . $staff['staffname'] . '</h5>
                        <h6 class="card-subtitle mb-2 text-muted">' . $staff['staff_reader_name'] . '</h6>
                        <p class="card-text">' . $staff['description'] . '</p>
                        <hr>
                        <button type="button" class="btn btn-primary select-staff-btn add-staff-btn" data-staff-id="' . $staff['id'] . '" data-toggle="modal" data-target="#feedbackModal">
                            <i class="fa-solid fa-circle-check"></i> Staff
                        </button>
                    </div>
                </div>
            </div>';
    }
  } else {
    echo '<div class="col-12"><p class="text-center">No staff available for the selected sector.</p></div>';
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
          <input type="hidden" id="staffId" value="" name="staff_id" readonly>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="anonymousCheck" name="anonymous">
              <label class="custom-control-label" for="anonymousCheck">Send anonymously</label>
            </div>
          </div>

          <!-- Rest of the form fields -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name">
            </div>
            <div class="form-group col-md-6">
              <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name" >
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-group col-md-6">
              <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number">
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
            <input type="checkbox" id="agreeTerms" name="agree"> I agree that what I am sending is true and I am sure to send it
          </div>

          <!-- <button type="submit" id="submitFeedback" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Submit</button> -->

          <button type="submit" id="submitFeedback" class="btn btn-primary add-staff-btn"><i class="fa-solid fa-paper-plane"></i> Send</button>

        </form>
      </div>
    </div>
  </div>
</div>

<head>

</head>

<script>
  // Wait for the page content to load
  document.addEventListener('DOMContentLoaded', function() {
    var agreeCheckbox = document.getElementById('agreeTerms');
    console.log(agreeCheckbox); // This will output 'null' if the checkbox is not found
    if (agreeCheckbox) {
      // Only attach event listener if the element exists
      var submitButton = document.getElementById('submitFeedback');
      submitButton.disabled = !agreeCheckbox.checked;

      agreeCheckbox.addEventListener('change', function() {
        submitButton.disabled = !agreeCheckbox.checked;
      });
    } else {
      console.error('Checkbox with id="agreeTerms" not found.');
    }
  });


</script>


<style>
  .staff-card {
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s ease;
  }

  .staff-card:hover {
    transform: scale(1.05);
  }

  .staff-img {
    width: 150px;
    height: 150px;
    object-fit: cover;
  }

  .img-box {
    margin-bottom: 15px;
  }
</style>

<!-- Bootstrap CSS -->