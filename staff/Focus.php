<?php
include 'header.php';
include '../conn.php';

$staff_email = $_SESSION['user'];
$staff_stmt = $conn->prepare("SELECT id FROM sectorstaff WHERE email = :email");
$staff_stmt->bindParam(':email', $staff_email);
$staff_stmt->execute();
$staff = $staff_stmt->fetch(PDO::FETCH_ASSOC);
$staff_id = $staff['id'];

// Fetch all feedback
$feedback_stmt = $conn->prepare("SELECT * FROM citizen_feedback WHERE staff_id = :staff_id AND focus = 1 ORDER BY created_at DESC");
$feedback_stmt->bindParam(':staff_id', $staff_id);
$feedback_stmt->execute();
$feedbacks = $feedback_stmt->fetchAll(PDO::FETCH_ASSOC);



$feedback_stmt = $conn->prepare("SELECT *, pin AS isPinned, focus AS isFocused FROM citizen_feedback WHERE staff_id = :staff_id AND focus = 1 ORDER BY created_at DESC");
$feedback_stmt->bindParam(':staff_id', $staff_id);
$feedback_stmt->execute();
$feedbacks = $feedback_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="service_section layout_padding"  style="background-color: #0f1b33; color: white;">
  <div class="service_container" >
    <div class="container">
        <div class="heading_container heading_center">
            <h2>All Citizen Feedback <span>Pin</span></h2>
            <p>Here is the latest feedback from citizens.</p>
        </div>
      <div class="row">
        <?php foreach ($feedbacks as $feedback): ?>
          <div class="col-md-4">
            <div class="box">
              <div class="detail-box text">
                <h5 style="color:black;"><?php echo htmlspecialchars($feedback['first_name']); ?></h5>
                <p style="color: black;"><?php echo htmlspecialchars(substr($feedback['message'], 0, 100)); ?>...</p>
                <hr>
                <a href="#" data-toggle="modal" data-target="#feedbackModal<?php echo $feedback['id']; ?>">Read More</a>
                <!-- Pin and Focus buttons -->
                <button class="btn <?php echo $feedback['isPinned'] ? 'btn-danger' : 'btn-warning'; ?> btn-sm" onclick="toggleFeedback(<?php echo $feedback['id']; ?>, '<?php echo $feedback['isPinned'] ? 'unpin' : 'pin'; ?>')">
                  <?php echo $feedback['isPinned'] ? 'Unpin' : 'Pin'; ?>
                </button>
                <button class="btn <?php echo $feedback['isFocused'] ? 'btn-danger' : 'btn-info'; ?> btn-sm" onclick="toggleFeedback(<?php echo $feedback['id']; ?>, '<?php echo $feedback['isFocused'] ? 'unfocus' : 'focus'; ?>')">
                  <?php echo $feedback['isFocused'] ? 'Unfocus' : 'Focus'; ?>
                </button>
              </div>
            </div>
          </div>

          <!-- Modal for Read More -->
          <div class="modal fade" id="feedbackModal<?php echo $feedback['id']; ?>" tabindex="-1" aria-labelledby="feedbackModalLabel<?php echo $feedback['id']; ?>" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="feedbackModalLabel<?php echo $feedback['id']; ?>">Feedback Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" >
                  <div class="row">
                    <!-- Personal Information Card -->
                    <div class="col-md-6">
                      <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                          <h5>Personal Information</h5>
                        </div>
                        <div class="card-body">
                          <p><strong>First Name:</strong> <?php echo htmlspecialchars($feedback['first_name']); ?></p>
                          <p><strong>Last Name:</strong> <?php echo htmlspecialchars($feedback['last_name']); ?></p>
                          <p><strong>Email:</strong> <?php echo htmlspecialchars($feedback['email']); ?></p>
                          <p><strong>Phone:</strong> <?php echo htmlspecialchars($feedback['phone']); ?></p>
                          <p><strong>Message:</strong> <?php echo htmlspecialchars($feedback['message']); ?></p>
                        </div>
                      </div>
                    </div>

                    <!-- Files Card -->
                    <div class="col-md-6">
                      <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                          <h5>Files</h5>
                        </div>
                        <div class="card-body">
                          <p><strong>Image:</strong> 
                            <?php if($feedback['image']): ?>
                              <a href="../<?php echo $feedback['image']; ?>" target="_blank" class="expand-image">View Image</a>
                            <?php endif; ?>
                          </p>
                          <p><strong>PDF:</strong> 
                            <?php if($feedback['pdf']): ?>
                              <a href="../<?php echo $feedback['pdf']; ?>" target="_blank">View PDF</a>
                            <?php endif; ?>
                          </p>
                          <p><strong>Audio:</strong> 
                            <?php if($feedback['audio']): ?>
                              <audio controls>
                                <source src="../<?php echo $feedback['audio']; ?>" type="audio/mpeg">
                                Your browser does not support the audio tag.
                              </audio>
                            <?php endif; ?>
                          </p>
                          <p><strong>Video:</strong> 
                            <?php if($feedback['video']): ?>
                              <video controls width="100%">
                                <source src="../<?php echo $feedback['video']; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                              </video>
                            <?php endif; ?>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <!-- Pin and Focus buttons in modal footer -->
                  <button class="btn <?php echo $feedback['isPinned'] ? 'btn-danger' : 'btn-warning'; ?>" onclick="toggleFeedback(<?php echo $feedback['id']; ?>, '<?php echo $feedback['isPinned'] ? 'unpin' : 'pin'; ?>')">
                    <?php echo $feedback['isPinned'] ? 'Unpin' : 'Pin'; ?>
                  </button>
                  <button class="btn <?php echo $feedback['isFocused'] ? 'btn-danger' : 'btn-info'; ?>" onclick="toggleFeedback(<?php echo $feedback['id']; ?>, '<?php echo $feedback['isFocused'] ? 'unfocus' : 'focus'; ?>')">
                    <?php echo $feedback['isFocused'] ? 'Unfocus' : 'Focus'; ?>
                  </button>
                </div>
              </div>
            </div>
          </div>

        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php include 'footer.php'; ?>

<script>
document.querySelectorAll('.expand-image').forEach(item => {
  item.addEventListener('click', function(e) {
    e.preventDefault();
    const imgSrc = this.href;
    const imgPopup = window.open(imgSrc, 'Image', 'width=800,height=600');
    imgPopup.focus();
  });
});

// Function to toggle pin and focus
function toggleFeedback(feedbackId, action) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "update_feedback.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function() {
    if (xhr.status === 200) {
      alert("Feedback updated successfully.");
      location.reload(); // Reload to see changes
    } else {
      alert("An error occurred while updating feedback.");
    }
  };
  xhr.send("id=" + feedbackId + "&action=" + action);
}
</script>


<style>
.modal-content {
  padding: 20px;
  width: 100%;
}

.modal-header {
  border-bottom: 1px solid #e9ecef;
}

.modal-body {
  max-height: calc(100vh - 200px);
  overflow-y: auto;
}

.box {
  border: 1px solid #ddd;
  border-radius: 5px;
  padding: 15px;
  margin-bottom: 20px;
}

.box h5 {
  font-size: 1.25rem;
}

.box p {
  font-size: 0.9rem;
}

.btn-box a {
  background-color: #007bff;
  color: white;
  padding: 10px 20px;
  border-radius: 5px;
  text-decoration: none;
}
</style>
