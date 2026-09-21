<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Upload Image - Alzikrayat</title>
    <link href="/project/public/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container" style="max-width: 500px; margin-top: 60px;">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h4 class="mb-4">  Upload New Image</h4>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger small"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="/project/public/photos/store" enctype="multipart/form-data" novalidate>
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" maxlength="200" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description (Optional)</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Select Image</label>
                    <input type="file" name="photo" class="form-control" accept="image/png, image/jpeg, image/gif" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Upload image</button>
            </form>

            <a href="/project/public/photos" class="d-block text-center mt-3 small">Return to Gallery</a>
        </div>
    </div>
</div>

<script>
    
    document.querySelector('form').addEventListener('submit', function (e) {
        const title = document.querySelector('input[name="title"]').value.trim();
        const fileInput = document.querySelector('input[name="photo"]');
        const file = fileInput.files[0];

        if (title === '') {
            e.preventDefault();
            alert('Please enter a title for the image.');
            return;
        }

        if (!file) {
            e.preventDefault();
            alert('Please select an image.');
            return;
        }

        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            e.preventDefault();
            alert('The file must be an image in jpg, png, or gif format.');
            return;
        }

        
        const maxSizeBytes = 5 * 1024 * 1024;
        if (file.size > maxSizeBytes) {
            e.preventDefault();
            alert('The image must not exceed 5 megabytes.');
        }
    });
</script>

</body>
</html>