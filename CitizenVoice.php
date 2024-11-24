<?php include 'header.php'; ?>
<?php include 'conn.php'; ?>
</div>

<section class="service_section layout_padding "style="background-color: #0f1b33;">

    <div class="service_container " style=" min-height: 60vh;">
        <div class="container col-12 border p-4 border-1 border-light text-light rounded " >
            <div class="heading_container heading_center">
                <h2>Select <span>District</span> and <span>Sector</span></h2>
                <p>Choose your district and sector to find the staff you'd like to communicate with.</p>
            </div>
            <hr>
            <div class="row col-6 mx-auto">
                <!-- District Selection -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="district">Select District</label>
                        <select class="form-control" id="district" name="district">
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
                        <select class="form-control" id="sector" name="sector">
                            <option value="">Select Sector</option>
                            <?php
                            $stmt = $conn->query("SELECT id, name FROM tbl_sector");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['id']}'>{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row" id="staff_cards" style="display: none; color: black;"></div>
            <hr>
        </div>
    </div>
</section>



<script>
    // Wait for the page content to load
document.addEventListener('DOMContentLoaded', function() {


// Fetch sectors based on district selection
document.getElementById('district').addEventListener('change', function() {
    var district_id = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get_write_sectors.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200) {
            document.getElementById('sector').innerHTML = this.responseText;
        }
    };
    xhr.send('district_id=' + district_id);
});

// Fetch staff based on sector selection
document.getElementById('sector').addEventListener('change', function() {
    var sector_id = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get_staffs.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200) {
            document.getElementById('staff_cards').innerHTML = this.responseText;
            document.getElementById('staff_cards').style.display = 'flex';

            // Now attach event listeners to the dynamically loaded staff buttons
            attachStaffSelectEvents();
        }
    };
    xhr.send('sector_id=' + sector_id);
});

// Function to attach the click event to dynamically loaded staff buttons
function attachStaffSelectEvents() {
    document.querySelectorAll('.select-staff-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var staffId = this.getAttribute('data-staff-id');
            if (staffId) {
                document.getElementById('staffId').value = staffId; // Set the staffId value in the input
            } else {
                alert("Staff ID not found. Please try again.");
            }
        });
    });
}

// Enable submit button only when the agree checkbox is checked
// document.getElementById('agreeTerms').addEventListener('change', function() {
//     document.getElementById('submitFeedback').disabled = !this.checked;
// });

});

</script>




<?php include 'footer.php'; ?>
