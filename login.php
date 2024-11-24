<?php include 'header.php'; ?>
</div>

<section class="CitizenVoice_section bg-light layout_padding"style="background-image: url('images/niboye.jpg'); background-size: cover; background-position: center; ">
    
    <div class="container rounded py-5" style="background-color: white; opacity: 90%; color: black; font-weight: 400;" >
        <div class="heading_container heading_center">
            <h2>Welcome to <span>NIBOYE SECTOR!</span></h2>
           
        </div>
        <hr>
        <div class="row " >
            <!-- Left side: Login Form -->
            <div class="col-md-6 " >
                <div class="heading_container heading_center" style="background-color:white;">
            <h2><span>Login </span>Admin & Staff portal</h2>
            <p>Please log in to access your account.</p>
        </div>
            <div class="login-box">
 
                    <form action="login_handler.php" method="post" class="bg-light">
                        <div class="row">
                            <!-- Username -->
                            <div class="col-md-6 form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6 form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                        </div>
                    </form>

                    <!-- Forgot Password and Sign Up Links -->
                    <div class="text-center mt-3">
                        <!-- <a href="#">Forgot Password?</a> | <a href="signup.php">Sign Up</a> -->
                    </div>
                </div>

            </div>
            
            <!-- Right side: About the System -->
            <div class="col-md-6">
                <div class="detail-box">
                    <h3>About the System</h3>
                    <p>
                        The Online suggestion box system is designed to allow citizens to submit their feedback directly to sector leaders. Your input helps to improve decision-making and public service delivery.
                    </p>
                    <p>
                        If you're new, create an account to get started. Together, we can create a more responsive and inclusive community.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
