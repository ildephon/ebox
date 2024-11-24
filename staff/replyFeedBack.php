<?php
session_start();
include '../conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedbackId = $_POST['id'];
    $reply = $_POST['reply'];
    $staff_email = $_SESSION['user']; 

    if ($feedbackId && $reply) {
        try {
            // Get the staff ID
            $staff_stmt = $conn->prepare("SELECT id, staff_reader_name FROM sectorstaff WHERE email = :email");
            $staff_stmt->bindParam(':email', $staff_email);
            $staff_stmt->execute();
            $staff = $staff_stmt->fetch(PDO::FETCH_ASSOC);
            $staff_id = $staff['id'];
            $staff_name = $staff['staff_reader_name'];


            // Insert the reply
            $stmt = $conn->prepare("INSERT INTO replies (feedback_id, staff_id, reply_text, created_at) VALUES (:feedback_id, :staff_id, :reply_text, NOW())");
            $stmt->bindParam(':feedback_id', $feedbackId);
            $stmt->bindParam(':staff_id', $staff_id);
            $stmt->bindParam(':reply_text', $reply);
            $stmt->execute();


            // Get feedback provider's email and original message
            $feedback_stmt = $conn->prepare("SELECT email, first_name, last_name, message FROM citizen_feedback WHERE id = :id");
            $feedback_stmt->bindParam(':id', $feedbackId);
            $feedback_stmt->execute();
            $feedback = $feedback_stmt->fetch(PDO::FETCH_ASSOC);
            $user_email = $feedback['email'];
            $user_name = $feedback['first_name'] . ' ' . $feedback['last_name'];
            $original_message = $feedback['message'];


            // Send email to user
            $mail = new PHPMailer(true);
            try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Replace with your SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'maniragabaeldephonse@gmail.com'; // Replace with your email
            $mail->Password   = 'hiumscluyqjteokp'; // Replace with your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('manigabaildephonse@gmail.com', 'Online suggestion box system');
            $mail->addAddress($user_email,
                $user_name
            );


                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Response to Your Feedback';
                $mail->Body    = "
                    <html>
                    <body>
                        <h2>Dear $user_name,</h2>
                        <p>Thank you for your feedback. Our staff member, $staff_name, has responded to your message:</p>
                        <h3>Your original feedback:</h3>
                        <blockquote>$original_message</blockquote>
                        <h3>Our response:</h3>
                        <blockquote>$reply</blockquote>
                        <p>If you have any further questions or concerns, please don't hesitate to contact us.</p>
                        <p>Best regards,<br>Online suggestion box system</p>
                    </body>
                    </html>
                ";

                $mail->send();

                // Now send the SMS
                $sms_url = 'http://localhost:3000/send-sms';  // Your SMS API URL
                $sms_data = [
                    'to' => "+250789707181",
                    'body' => "Hello $user_name, we have responded to your feedback: '$original_message'. Response: '$reply'."
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $sms_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sms_data));

                $response = curl_exec($ch);
                curl_close($ch);

                // Check if SMS was sent successfully
                if ($response === false) {
                    echo json_encode(['success' => false, 'message' => 'Failed to send SMS']);
                } else {
                    echo json_encode(['success' => true, 'message' => 'Reply submitted, email and SMS sent successfully']);
                }

            
            echo json_encode(['success' => true, 'message' => 'Reply submitted and email sent successfully']);
        } catch (Exception $e) {
            echo json_encode(['success' => true, 'message' => 'Reply submitted successfully, but failed to send email: ' . $mail->ErrorInfo]);
        }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
