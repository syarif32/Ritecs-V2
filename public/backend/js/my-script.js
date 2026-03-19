

      /* FORM UPLOAD */

    const uploadBox = document.getElementById('uploadBox');
    const coverImage = document.getElementById('coverImage');
    const previewImage = document.getElementById('previewImage');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');

    uploadBox.addEventListener('click', () => coverImage.click());

    coverImage.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
        previewImage.src = e.target.result;
        previewImage.style.display = 'block';
        uploadPlaceholder.style.display = 'none';
        }
        reader.readAsDataURL(file);
    }
    });

    // Drag & drop support
    uploadBox.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadBox.classList.add('bg-light');
    });

    uploadBox.addEventListener('dragleave', () => {
    uploadBox.classList.remove('bg-light');
    });

    uploadBox.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadBox.classList.remove('bg-light');
    const file = e.dataTransfer.files[0];
    coverImage.files = e.dataTransfer.files;
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
        previewImage.src = e.target.result;
        previewImage.style.display = 'block';
        uploadPlaceholder.style.display = 'none';
        }
        reader.readAsDataURL(file);
    }
    });

    // icon selection
    