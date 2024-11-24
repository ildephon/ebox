<div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel">Crop Profile Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="file" id="upload_image" class="form-control" accept="image/*">
                <div id="crop_area" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="crop_save" class="btn btn-primary">Save Image</button>
            </div>
        </div>
    </div>
</div>

<script>
    let cropper;
    document.getElementById('upload_image').addEventListener('change', function(event) {
        let files = event.target.files;
        if (files && files.length > 0) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let image = document.createElement('img');
                image.src = e.target.result;
                image.style.maxWidth = '100%';
                document.getElementById('crop_area').innerHTML = '';
                document.getElementById('crop_area').appendChild(image);

                cropper = new Cropper(image, {
                    aspectRatio: 1, // Square crop
                    viewMode: 2
                });
            };
            reader.readAsDataURL(files[0]);
        }
    });

    document.getElementById('crop_save').addEventListener('click', function() {
        let canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300
        });

        canvas.toBlob(function(blob) {
            let formData = new FormData();
            formData.append('cropped_image', blob);

            fetch('upload_cropped_image.php', {
                method: 'POST',
                body: formData,
            }).then(response => response.text())
            .then(result => {
                alert(result);
                location.reload();
            }).catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>
