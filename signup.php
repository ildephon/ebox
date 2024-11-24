<?php include 'header.php'; ?>
<?php include 'conn.php'; ?>
</div>
<section class="CitizenVoice_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Welcome to <span>OSBS - Online Suggestion Box System</span></h2>
            <p>Please sign up to create your account and start sharing your feedback with leaders.</p>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="signup-box">
                    <h3>Sign Up</h3>
                    <form action="signup_handler.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="district">Select District</label>
                                    <select class="form-control" id="district" name="district" required>
                                        <option value="">Select District</option>
                                        <?php
                                        $stmt = $conn->query("SELECT id, name FROM tbl_district");
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sector">Select Sector</label>
                                    <select class="form-control" id="sector" name="sector" required>
                                        <option value="">Select Sector</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                    </form>

                    <div class="text-center mt-3">
                        Already have an account? <a href="login.php">Log In</a>
                    </div>
                </div>
            </div>

            <!-- Right side: Information Section -->
            <div class="col-md-6">
                <div class="detail-box">
                    <h3>About OSBS - Online Suggestion Box System</h3>
                    <p>
                        OSBS - Online Suggestion Box System is a platform for citizens to share feedback with district leaders. Join OSBS - Online Suggestion Box System to make sure your voice reaches the right people in charge of your community.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('district').addEventListener('change', function() {
    var district_id = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get_sectors.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200) {
            document.getElementById('sector').innerHTML = this.responseText;
        }
    }
    xhr.send('district_id=' + district_id);
});
</script>

<?php include 'footer.php'; ?>
