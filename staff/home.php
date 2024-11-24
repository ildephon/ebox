<?php include 'header.php'; ?>
<?php
include '../conn.php';  // Include your connection file

// Get the current staff ID based on session email
$staff_email = $_SESSION['user'];
$staff_stmt = $conn->prepare("SELECT id FROM sectorstaff WHERE email = :email");
$staff_stmt->bindParam(':email', $staff_email);
$staff_stmt->execute();
$staff = $staff_stmt->fetch(PDO::FETCH_ASSOC);
$staff_id = $staff['id'];

// Fetch the latest feedback
$feedback_stmt = $conn->prepare("SELECT *, pin AS isPinned, focus AS isFocused FROM citizen_feedback WHERE staff_id = :staff_id ORDER BY created_at DESC LIMIT 3");
$feedback_stmt->bindParam(':staff_id', $staff_id);
$feedback_stmt->execute();
$feedbacks = $feedback_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="service_section layout_padding" style="background-image: url('../images/niboye2.png'); background-size: cover; background-position: center; ">
  <div class="service_container">
    <div class="container bg-light rounded py-4">
      <div class="heading_container heading_center">
        <h2 style="color: black;">Citizen <span>Feedback</span> and Problems</h2>
        <p style="color: black;">Here is the latest feedback from citizens.</p>
      </div>

      <div class="row">
        <?php foreach ($feedbacks as $feedback): ?>
          <div class="col-md-4">
            <div class="box">
              <div class="detail-box">
                <h5><?php echo htmlspecialchars($feedback['first_name']); ?></h5>
                <p><?php echo htmlspecialchars(substr($feedback['message'], 0, 100)); ?>...</p>
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
          <div class="modal fade" id="feedbackModal<?php echo $feedback['id']; ?>" tabindex="-1" aria-labelledby="feedbackModalLabel<?php echo $feedback['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="feedbackModalLabel<?php echo $feedback['id']; ?>">Feedback Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
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
                            <?php if ($feedback['image']): ?>
                              <a href="../<?php echo $feedback['image']; ?>" target="_blank" class="expand-image">View Image</a>
                            <?php endif; ?>
                          </p>
                          <p><strong>PDF:</strong>
                            <?php if ($feedback['pdf']): ?>
                              <a href="../<?php echo $feedback['pdf']; ?>" target="_blank">View PDF</a>
                            <?php endif; ?>
                          </p>
                          <p><strong>Audio:</strong>
                            <?php if ($feedback['audio']): ?>
                              <audio controls>
                                <source src="../<?php echo $feedback['audio']; ?>" type="audio/mpeg">
                                Your browser does not support the audio tag.
                              </audio>
                            <?php endif; ?>
                          </p>
                          <p><strong>Video:</strong>
                            <?php if ($feedback['video']): ?>
                              <video controls width="100%">
                                <source src="../<?php echo $feedback['video']; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                              </video>
                            <?php endif; ?>
                          </p>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12 mt-4">
                      <h5>Previous Replies</h5>
                      <div id="previousReplies<?php echo $feedback['id']; ?>">
                        <?php
                        try {
                          $reply_stmt = $conn->prepare("SELECT r.*, s.staff_reader_name FROM replies r JOIN sectorstaff s ON r.staff_id = s.id WHERE r.feedback_id = :feedback_id ORDER BY r.created_at DESC");
                          $reply_stmt->bindParam(':feedback_id', $feedback['id']);
                          $reply_stmt->execute();
                          $replies = $reply_stmt->fetchAll(PDO::FETCH_ASSOC);

                          foreach ($replies as $reply) {
                            echo '<div class="card mb-2">';
                            echo '<div class="card-body">';
                            echo '<p class="mb-1"><strong>' . htmlspecialchars($reply['staff_reader_name']) . '</strong> - ' . $reply['created_at'] . '</p>';
                            echo '<p class="mb-0">' . htmlspecialchars($reply['reply_text']) . '</p>';
                            echo '</div>';
                            echo '</div>';
                          }
                        } catch (\Throwable $th) {
                          die($th->getMessage());
                        }

                        ?>
                      </div>
                    </div>
                    <div class="col-md-12 mt-4">
                      <h5>Add Reply</h5>
                      <textarea class="form-control" id="reply" rows="4" placeholder="Write your reply here"></textarea>
                      <button class="btn btn-primary mt-2" onclick="replyFeedback(<?php echo $feedback['id']; ?>)">Submit Reply</button>
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
  function toggleFeedback(feedbackId, action) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_feedback.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
      if (xhr.status === 200) {
        alert("Feedback updated successfully.");
        location.reload();
      } else {
        alert("An error occurred while updating feedback.");
      }
    };
    xhr.send("id=" + feedbackId + "&action=" + action);
  }

  function replyFeedback(feedbackId) {
    const replyText = document.getElementById('reply').value;
    if (!replyText.trim()) {
      alert("Please enter a reply before submitting.");
      return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "replyFeedback.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
      if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        console.log(response);
        if (response.success) {
          alert("Reply submitted successfully.");
          location.reload();
        } else {
          alert("An error occurred while submitting the reply: " + response.message);
        }
      } else {
        alert("An error occurred while submitting the reply.");
      }
    };
    xhr.send("id=" + feedbackId + "&reply=" + encodeURIComponent(replyText));
  }
</script>

<style>
  .modal-content {
    padding: 20px;
    width: 100%;
  }

  .box {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
  }

  .btn-sm {
    margin-right: 5px;
  }
</style>