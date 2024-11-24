<?php
include 'header.php';
include '../conn.php';  // Include your connection file
// session_start();

// Get the current sector officer email from the session
$sectorOfficer_email = $_SESSION['user'];

// Prepare the SQL query with a JOIN to get feedback and sector staff information
$feedback_stmt = $conn->prepare("
  SELECT cf.*, ss.staff_reader_name, ss.staffname, ss.sectorOfficer_email, cf.pin AS isPinned, cf.focus AS isFocused
  FROM citizen_feedback cf
  JOIN sectorstaff ss ON cf.staff_id = ss.id
  WHERE ss.sectorOfficer_email = :sectorOfficer_email AND cf.focus = 1
  ORDER BY cf.created_at DESC
");

$feedback_stmt->bindParam(':sectorOfficer_email', $sectorOfficer_email);
$feedback_stmt->execute();
$feedbacks = $feedback_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="service_section layout_padding" style="background-image: url('../images/niboye2.png'); background-size: cover; background-position: center; ">
  <div class="service_container py-5" >
    <div class="container bg-light py-2">
      <div class="heading_container heading_center align-items-center" style="background-color: #010029; opacity: 90%; color: black; font-weight: 400;">
        <h2 class="text-light">Latest <span>Issues</span> Pinned</h2>
        <p class="text-light">Here is the latest issues from citizens.</p>
      </div>

      <div class="row border">
        <?php foreach ($feedbacks as $feedback): ?>
          <div class="col-md-4 m-2 ">
            <div class="box card-body  border m-4">
              <div class="detail-box " style="color: black;">
                <h5><?php echo htmlspecialchars($feedback['first_name']); ?> </h5>
                <p><?php echo htmlspecialchars(substr($feedback['message'], 0, 100)); ?>...</p>
                <hr>
                Handled by: <?php echo htmlspecialchars($feedback['staffname']); ?>
                <hr>
                <a href="#" class="btn btn-outline-primary text-black" data-toggle="modal" data-target="#feedbackModal<?php echo $feedback['id']; ?>">Read More</a>

              </div>
            </div>
          </div>

          <!-- Modal for Read More -->
          <div class="modal fade " id="feedbackModal<?php echo $feedback['id']; ?>" tabindex="-1" aria-labelledby="feedbackModalLabel<?php echo $feedback['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="feedbackModalLabel<?php echo $feedback['id']; ?>" style="color: black;">Feedback Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body ">
                  <div class="row">
                    <!-- Personal Information Card -->
                    <div class="col-md-6">
                      <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                          <h5>Personal Information</h5>
                        </div>
                        <div class="card-body " style="color:black;">
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
                        <div class="card-body" style="color:black;">
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

      <!-- View All Button -->
      <!-- <div class="btn-box">
        <a href="view_all_feedback.php">View All</a>
      </div> -->
    </div>
  </div>
</section>

<script>
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

<?php include 'footer.php'; ?>
