<?php
session_start();
include 'header.php'; ?>
</div>

<section class="CitizenVoice_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Verification Code</h2>
            <p>Please enter the verification code sent to your email. The code will expire in 1 minute.</p>
        </div>
        
        <div class="row">
            <!-- Left side: Code Verification Form -->
            <div class="col-md-6">
                <div class="verify-codOSBS - Online Suggestion Box System">
                    <h3>Enter Code</h3>
                    <?php
                    
                    
                    if(isset($_SESSION['error']))
                    {
                        echo "<p class='text-danger'>{$_SESSION['error']}</p>";
                        
                    }
                    $verification_code = isset($_SESSION['verification_code']) ? $_SESSION['verification_code'] : null; // Default value for testing
                    
                    echo "<p><strong>Your Code: </strong><span class='text-success'>$verification_code</span></p>"; // Display the code to the user
                    ?>
                    <form action="verify_handler.php" method="post">
                        <div class="form-group">
                            <label for="verification_code">Verification Code</label>
                            <input type="text" class="form-control" id="verification_code" name="verification_code" required>
                        </div>
                        <div id="countdown" class="text-danger font-weight-bold"></div>
                        <button type="submit" class="btn btn-primary btn-block">Verify</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="resend_code.php"><button id="resendCode" class="btn btn-secondary btn-block" disabled>Resend Code</button></a>
                    </div>
                </div>
            </div>

            <!-- Right side: About the System -->
            <div class="col-md-6">
                <div class="detail-box">
                    <h3>About the System</h3>
                    <p>
                        The Responsive Secretary of Sector system is designed to allow citizens to submit their feedback directly to sector leaders. Your input helps improve decision-making and public service delivery.
                    </p>
                    <p>
                        Please complete your registration by entering the code sent to your email.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Countdown timer for code expiration
var countdownElement = document.getElementById('countdown');
var resendButton = document.getElementById('resendCode');
var timeLeft = 60; // 1 minute in seconds

var countdown = setInterval(function() {
    if (timeLeft <= 0) {
        clearInterval(countdown);
        countdownElement.innerHTML = 'Code expired. Please resend the code.';
        resendButton.disabled = false; // Enable the resend button
    } else {
        countdownElement.innerHTML = 'Code expires in ' + timeLeft + ' seconds';
    }
    timeLeft -= 1;
}, 1000);


</script>

<?php include 'footer.php'; ?>
