<?php include 'header.php'; ?>
<?php include '../conn.php'; ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
<style>
  /* Custom style for the image container */
  .img-container {
    width: 100%;
    max-height: 400px;
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
  }
  img {
    max-width: 100%;
  }
</style>

<section class="CitizenVoice_section layout_padding" style="background-image: url('../images/niboye2.png'); background-size: cover; background-position: center;">
    <div class="container bg-light text-dark " style="margin-top: -4rem;">
        <div class="heading_container heading_center">
            <h2>Add New <span>Staff</span></h2>
            <p>Please provide the staff details to add them to departments.</p>
        </div>
        <hr>
        <div class="row ">
            <div class="col-md-6 ">
            <div class="signup-box">
            <h3>Staff Information</h3>
            <form id="staffForm" action="add_staff_handler.php" class="p-3" method="post" enctype="multipart/form-data">
                <div class="row">
                    <!-- Staff Reader Name -->
                    <div class="col-md-6 form-group">
                        <label for="staff_reader_name">Staff Reader Name</label>
                        <input type="text" class="form-control" id="staff_reader_name" name="staff_reader_name" required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Password -->
                    <div class="col-md-6 form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <!-- Staff Name -->
                    <div class="col-md-6 form-group">
                        <label for="staffname">Staff Name</label>
                        <input type="text" class="form-control" id="staffname" name="staffname" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Description (Full width) -->
                    <div class="col-md-12 form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                </div>

                <div class="row">
                    <!-- Image Upload -->
                    <div class="col-md-12 form-group">
                        <label for="image">Upload Staff Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                </div>

                <!-- Preview and Crop Section -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="img-container" id="image-preview">
                            <img id="preview-img" style="display:none;">
                        </div>

                        <!-- Basic Filters -->
                        <div id="filters" style="display: none;">
                            <label for="brightness">Brightness</label>
                            <input type="range" id="brightness" name="brightness" min="0" max="200" value="100">
                            <br>
                            <label for="contrast">Contrast</label>
                            <input type="range" id="contrast" name="contrast" min="0" max="200" value="100">
                        </div>
                    </div>
                </div>

                <!-- Hidden field for cropped image -->
                <input type="hidden" name="cropped_image" id="cropped_image">

                <!-- Hidden field for sectorOfficer_email -->
                <input type="hidden" name="sectorOfficer_email" value="<?php echo $_SESSION['user']; ?>">

                <!-- Submit Button -->
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block">Add Staff</button>
                    </div>
                </div>
            </form>
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

<!-- Cropper.js and necessary scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
    let cropper;
    const imageInput = document.getElementById('image');
    const previewImg = document.getElementById('preview-img');
    const croppedImageInput = document.getElementById('cropped_image');
    const filtersDiv = document.getElementById('filters');
    const brightnessInput = document.getElementById('brightness');
    const contrastInput = document.getElementById('contrast');

    imageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(previewImg, {
                    aspectRatio: 1,
                    viewMode: 2,
                    crop(event) {
                        const canvas = cropper.getCroppedCanvas();
                        croppedImageInput.value = canvas.toDataURL('image/jpeg');
                    }
                });

                filtersDiv.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Apply filters
    brightnessInput.addEventListener('input', function () {
        applyFilters();
    });

    contrastInput.addEventListener('input', function () {
        applyFilters();
    });

    function applyFilters() {
        const brightness = brightnessInput.value;
        const contrast = contrastInput.value;
        previewImg.style.filter = `brightness(${brightness}%) contrast(${contrast}%)`;

        if (cropper) {
            const canvas = cropper.getCroppedCanvas();
            croppedImageInput.value = canvas.toDataURL('image/jpeg');
        }
    }
</script>

<?php include 'footer.php'; ?>
